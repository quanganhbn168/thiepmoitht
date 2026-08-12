<?php

namespace App\Http\Controllers;

use App\Models\Gathering;
use App\Models\GatheringGuest;
use App\Support\VietQrQuickLink;
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
        $layout = is_array(data_get($content, 'layout')) ? data_get($content, 'layout') : [];
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
        $paymentAmountForInvitation = $guest ? $paymentAmount * $paymentGuestCount : $paymentAmount;
        $paymentBankBin = trim((string) data_get($content, 'payment.bank_bin'));
        $paymentAccountNumber = trim((string) data_get($content, 'payment.account_number'));
        $paymentAccountHolder = trim((string) data_get($content, 'payment.account_holder'));
        $paymentQrUrl = VietQrQuickLink::imageUrl(
            $paymentBankBin,
            $paymentAccountNumber,
            $paymentAmountForInvitation,
            $paymentReference,
            $paymentAccountHolder,
        ) ?: $gathering->getFirstMediaUrl('payment_qr');
        $paymentAccountInfo = trim((string) data_get($content, 'payment.account_info'));

        if ($paymentAccountInfo === '') {
            $paymentAccountInfo = collect([
                data_get($content, 'payment.bank_name') ? 'Ngân hàng: '.data_get($content, 'payment.bank_name') : null,
                data_get($content, 'payment.account_number') ? 'Số TK: '.data_get($content, 'payment.account_number') : null,
                data_get($content, 'payment.account_holder') ? 'Chủ TK: '.data_get($content, 'payment.account_holder') : null,
            ])->filter()->implode("\n");
        }
        $paymentDeadline = trim((string) data_get($content, 'payment.deadline'));
        $inviteeName = trim((string) $guest?->name);
        $invitationTitle = $inviteeName !== ''
            ? 'Trân trọng kính mời '.$inviteeName
            : 'Trân trọng kính mời bạn';
        $invitationDescription = $inviteeName !== ''
            ? $inviteeName.', mời bạn đến chung vui trong buổi hội ngộ '.$gathering->title.'.'
            : 'Mời bạn đến chung vui trong buổi hội ngộ '.$gathering->title.'.';
        $layoutValue = static function (string $key, string $default = '') use ($layout): string {
            $value = trim((string) data_get($layout, $key));

            return $value !== '' ? $value : $default;
        };
        $eventDateLabel = $eventDateTime?->locale('vi')->translatedFormat('d.m.Y') ?: 'Ngày gặp lại';
        $timeline = collect(data_get($layout, 'timeline', []))
            ->filter(fn ($item): bool => is_array($item) && filled($item['title'] ?? null))
            ->map(fn (array $item) => (object) [
                'date' => $item['date'] ?? '',
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
            ])
            ->values();

        if ($timeline->isEmpty()) {
            $timeline = collect([
                (object) [
                    'date' => 'Ngày ấy',
                    'title' => 'Những kỷ niệm còn đây',
                    'description' => 'Những con người từng đồng hành, những câu chuyện từng kể và một chặng đường đáng nhớ.',
                ],
                (object) [
                    'date' => $eventDateLabel,
                    'title' => 'Hẹn gặp lại nhau',
                    'description' => 'Một cuộc hẹn để cùng nhìn lại, kể chuyện cũ và nối tiếp những kết nối đã từng có.',
                ],
            ]);
        }
        $invitationUrl = $guest
            ? route('gathering.invitation.show', ['gathering' => $gathering->slug, 'guest' => $guest->code])
            : route('gathering.show', ['gathering' => $gathering->slug]);

        $event = (object) [
            'title' => $inviteeName !== ''
                ? $invitationTitle.' | '.$gathering->title
                : (data_get($content, 'seo.title') ?: 'Lời mời hội ngộ | '.$gathering->title),
            'meta_title' => $inviteeName !== ''
                ? $invitationTitle.' | '.$gathering->title
                : (data_get($content, 'seo.title') ?: 'Lời mời hội ngộ | '.$gathering->title),
            'meta_description' => $inviteeName !== ''
                ? $invitationDescription
                : (data_get($content, 'seo.description') ?: $invitationDescription),
            'url' => $invitationUrl,
            'canonical_url' => $invitationUrl,
            'main_url' => route('gathering.show', ['gathering' => $gathering->slug]),
            'headline' => data_get($content, 'invitation_headline') ?: 'Kèo này không được vắng mặt',
            'invitation_title' => $invitationTitle,
            'invitation_description' => $invitationDescription,
            'greeting' => $guest?->greeting ?: ('Gửi ' . ($guest?->name ?: 'người bạn thân mến') . ','),
            'introduction' => data_get($content, 'introduction') ?: '<p>Đủ lâu rồi chúng ta chưa ngồi lại với nhau. Mời bạn đến một buổi gặp gỡ thật vui, kể chuyện cũ và cụng ly cho những ngày mới.</p>',
            'dress_code' => data_get($content, 'dress_code'),
            'menu_note' => data_get($content, 'menu_note'),
            'host_note' => data_get($content, 'host_note'),
            'layout' => (object) [
                'hero_kicker' => $layoutValue('hero_kicker', ($gathering->host_name ?: $gathering->title).' · Hội ngộ '.($eventDateTime?->format('Y') ?: '')),
                'hero_title' => $layoutValue('hero_title', "Hẹn gặp lại\nnhững người bạn cũ"),
                'hero_note' => $layoutValue('hero_note', 'Một cuộc hẹn để cùng nhắc về những ngày đã qua và những câu chuyện vẫn còn nguyên trong ký ức.'),
                'hero_photo_label' => $layoutValue('hero_photo_label', $gathering->host_name ?: $gathering->title),
                'hero_photo_caption' => $layoutValue('hero_photo_caption', 'Một dấu mốc để chúng ta cùng trở về và gặp lại nhau.'),
                'timeline' => $timeline,
                'milestone_label' => $layoutValue('milestone_label', 'Tư liệu kỷ niệm'),
                'milestone_heading' => $layoutValue('milestone_heading', "Một dấu mốc\nđể nhớ"),
                'milestone_date' => $layoutValue('milestone_date', 'Ký ức chung'),
                'milestone_title' => $layoutValue('milestone_title', $gathering->title),
                'milestone_description' => $layoutValue('milestone_description', 'Một khoảnh khắc thật được lưu lại để những người từng có mặt có thể cùng nhớ về.'),
                'team_label' => $layoutValue('team_label', 'Những gương mặt năm ấy'),
                'team_heading' => $layoutValue('team_heading', "Tập thể\nngày ấy"),
                'team_intro' => $layoutValue('team_intro', 'Bức ảnh được giữ lại như một phần tư liệu của hành trình chung.'),
                'team_credit_label' => $layoutValue('team_credit_label', 'Ký ức tập thể'),
                'team_credit' => $layoutValue('team_credit', 'Không chỉ là một tấm ảnh. Đó là những con người từng cùng bắt đầu.'),
            ],
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
                'qr_url' => $paymentQrUrl ?: null,
                'amount' => $paymentAmount,
                'amount_for_guest' => $guest ? $paymentAmountForInvitation : null,
                'guest_count' => $paymentGuestCount,
                'account_info' => $paymentAccountInfo,
                'bank_bin' => $paymentBankBin,
                'bank_name' => trim((string) data_get($content, 'payment.bank_name')),
                'account_number' => $paymentAccountNumber,
                'account_holder' => $paymentAccountHolder,
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
