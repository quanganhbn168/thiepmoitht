<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class WeddingController extends Controller
{
    private const DEFAULT_TEMPLATE_VIEW = 'templates.wedding-modern';

    public function show(Wedding $wedding)
    {
        abort_unless($wedding->is_active && $wedding->status === 'published', 404);

        $content = is_array($wedding->content) ? $wedding->content : [];
        $eventDateTime = $wedding->event_time
            ?: $wedding->event_date?->copy()->setTime(11, 0);
        $paymentEnabled = (bool) data_get($content, 'payment.enabled', false);
        $paymentDeadline = trim((string) data_get($content, 'payment.deadline'));
        $url = route('wedding.show', ['wedding' => $wedding->slug]);

        $event = (object) [
            'title' => data_get($content, 'seo.title') ?: 'Thiệp cưới '.$wedding->groom_name.' & '.$wedding->bride_name,
            'description' => data_get($content, 'seo.description') ?: 'Trân trọng kính mời bạn đến chung vui cùng gia đình chúng tôi.',
            'headline' => data_get($content, 'invitation_headline') ?: 'Trân trọng kính mời',
            'introduction' => data_get($content, 'introduction') ?: 'Sự hiện diện của bạn là niềm vinh hạnh cho gia đình chúng tôi.',
            'cover' => $wedding->getCoverUrl(),
            'share_image' => $wedding->getShareUrl(),
            'event_datetime' => $eventDateTime,
            'url' => $url,
            'payment' => (object) [
                'enabled' => $paymentEnabled,
                'qr_url' => $wedding->getFirstMediaUrl('payment_qr') ?: null,
                'bank_name' => trim((string) data_get($content, 'payment.bank_name')),
                'account_number' => trim((string) data_get($content, 'payment.account_number')),
                'account_holder' => trim((string) data_get($content, 'payment.account_holder')),
                'transfer_note' => trim((string) data_get($content, 'payment.transfer_note')),
                'deadline' => $paymentDeadline !== '' ? Carbon::parse($paymentDeadline) : null,
                'note' => trim((string) data_get($content, 'payment.note')),
            ],
            'gallery' => $wedding->getMedia('gallery')
                ->filter(fn ($media): bool => str_starts_with((string) $media->mime_type, 'image/'))
                ->map(fn ($media) => (object) [
                    'url' => $media->getUrl(),
                    'alt' => $media->name ?: 'Khoảnh khắc của cô dâu chú rể',
                ])
                ->values(),
        ];

        return view($this->resolveViewPath($wedding), compact('event', 'wedding'));
    }

    private function resolveViewPath(Wedding $wedding): string
    {
        $template = $wedding->template;

        if ($template?->is_active && $template->type === 'wedding' && View::exists($template->view_path)) {
            return $template->view_path;
        }

        return self::DEFAULT_TEMPLATE_VIEW;
    }
}
