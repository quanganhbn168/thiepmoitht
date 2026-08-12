<?php

namespace App\Http\Controllers;

use App\Models\Gathering;
use App\Models\GatheringGuest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;

class GatheringController extends Controller
{
    private const DEFAULT_TEMPLATE_VIEW = 'templates.gathering-cheers';

    public function show(Gathering $gathering)
    {
        return $this->render($gathering);
    }

    public function showInvitation(Gathering $gathering, GatheringGuest $guest)
    {
        abort_unless($guest->gathering_id === $gathering->id, 404);

        return $this->render($gathering, $guest);
    }

    public function storeRsvp(Request $request, Gathering $gathering, GatheringGuest $guest)
    {
        abort_unless($this->isPublic($gathering) && $guest->gathering_id === $gathering->id, 404);

        $key = 'gathering-rsvp:' . $gathering->id . ':' . $guest->id . ':' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 10)) {
            return back()->withErrors([
                'rsvp' => 'Bạn đã gửi quá nhiều lần. Vui lòng thử lại sau.',
            ]);
        }

        RateLimiter::hit($key, 3600);

        $validated = $request->validate([
            'rsvp_status' => 'required|in:attending,declined',
            'guest_count' => 'nullable|integer|min:1|max:50',
            'phone' => 'nullable|string|max:30',
            'note' => 'nullable|string|max:1000',
        ]);

        $guest->update([
            'rsvp_status' => $validated['rsvp_status'],
            'guest_count' => $validated['guest_count'] ?? 1,
            'phone' => $validated['phone'] ?? $guest->phone,
            'note' => $validated['note'] ?? $guest->note,
            'responded_at' => now(),
        ]);

        return redirect()
            ->route('gathering.invitation.show', [
                'gathering' => $gathering->slug,
                'guest' => $guest->code,
            ])
            ->with('gathering_rsvp_success', true);
    }

    private function render(Gathering $gathering, ?GatheringGuest $guest = null)
    {
        abort_unless($this->isPublic($gathering), 404);

        $content = is_array($gathering->content) ? $gathering->content : [];
        $viewPath = $this->resolveViewPath($gathering);
        $eventDateTime = $gathering->event_time
            ?: $gathering->event_date?->copy()->setTime(18, 0);
        $paymentEnabled = (bool) data_get($content, 'payment.enabled', false);
        $paymentAmount = max(0, (int) data_get($content, 'payment.amount', 0));
        $paymentGuestCount = max(1, (int) ($guest?->guest_count ?: 1));
        $paymentPrefix = trim((string) data_get($content, 'payment.transfer_prefix', 'HOINGO'));
        $paymentReference = $guest
            ? trim($paymentPrefix . ' ' . $guest->code)
            : trim($paymentPrefix . ' ' . $gathering->slug);
        $paymentDeadline = trim((string) data_get($content, 'payment.deadline'));
        $invitationUrl = $guest
            ? route('gathering.invitation.show', ['gathering' => $gathering->slug, 'guest' => $guest->code])
            : route('gathering.show', ['gathering' => $gathering->slug]);

        $event = (object) [
            'title' => data_get($content, 'seo.title') ?: 'Lời mời hội ngộ | ' . $gathering->title,
            'meta_title' => data_get($content, 'seo.title') ?: 'Lời mời hội ngộ | ' . $gathering->title,
            'meta_description' => data_get($content, 'seo.description') ?: 'Trân trọng mời bạn đến buổi hội ngộ ' . $gathering->title . '.',
            'url' => $invitationUrl,
            'canonical_url' => $invitationUrl,
            'main_url' => route('gathering.show', ['gathering' => $gathering->slug]),
            'headline' => data_get($content, 'invitation_headline') ?: 'Kèo này không được vắng mặt',
            'greeting' => $guest?->greeting ?: ('Gửi ' . ($guest?->name ?: 'người bạn thân mến') . ','),
            'introduction' => data_get($content, 'introduction') ?: '<p>Đủ lâu rồi chúng ta chưa ngồi lại với nhau. Mời bạn đến một buổi gặp gỡ thật vui, kể chuyện cũ và cụng ly cho những ngày mới.</p>',
            'dress_code' => data_get($content, 'dress_code'),
            'menu_note' => data_get($content, 'menu_note'),
            'host_note' => data_get($content, 'host_note'),
            'schedule' => collect(data_get($content, 'schedule', []))
                ->filter(fn ($item) => is_array($item) && filled($item['title'] ?? null))
                ->map(fn (array $item) => (object) [
                    'time' => $item['time'] ?? '',
                    'title' => $item['title'] ?? '',
                    'description' => $item['description'] ?? '',
                ])
                ->values(),
            'cover' => $gathering->getCoverUrl(),
            'share_image' => $gathering->getShareUrl(),
            'gallery' => $gathering->getMedia('gallery')
                ->filter(fn ($media): bool => str_starts_with((string) $media->mime_type, 'image/'))
                ->map(fn ($media) => (object) [
                    'url' => $media->getUrl(),
                    'alt' => $media->name ?: 'Khoảnh khắc hội ngộ',
                ])
                ->values(),
            'payment' => (object) [
                'enabled' => $paymentEnabled,
                'qr_url' => $gathering->getFirstMediaUrl('payment_qr') ?: null,
                'amount' => $paymentAmount,
                'amount_for_guest' => $guest ? $paymentAmount * $paymentGuestCount : null,
                'guest_count' => $paymentGuestCount,
                'bank_name' => trim((string) data_get($content, 'payment.bank_name')),
                'account_number' => trim((string) data_get($content, 'payment.account_number')),
                'account_holder' => trim((string) data_get($content, 'payment.account_holder')),
                'transfer_prefix' => $paymentPrefix,
                'transfer_reference' => $paymentReference,
                'deadline' => $paymentDeadline !== '' ? Carbon::parse($paymentDeadline) : null,
                'note' => trim((string) data_get($content, 'payment.note')),
            ],
            'event_datetime' => $eventDateTime,
        ];

        return view($viewPath, compact('event', 'gathering', 'guest', 'invitationUrl'));
    }

    private function resolveViewPath(Gathering $gathering): string
    {
        $template = $gathering->template;

        if ($template?->is_active && $template->type === 'gathering' && View::exists($template->view_path)) {
            return $template->view_path;
        }

        return self::DEFAULT_TEMPLATE_VIEW;
    }

    private function isPublic(Gathering $gathering): bool
    {
        return $gathering->is_active && $gathering->status === 'published';
    }
}
