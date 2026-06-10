<?php

namespace App\Http\Controllers;

use App\Models\Reunion;
use App\Models\ReunionMessage;
use App\Models\ReunionRsvp;
use App\Models\User;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ReunionController extends Controller
{
    private const DEFAULT_TEMPLATE_VIEW = 'templates.standard';
    private const QUE_VO_2_TEMPLATE_VIEW = 'templates.que-vo-2';

    private const DEFAULT_HERO_IMAGE = 'images/hop-lop-que-vo-2.png';
    private const DEFAULT_DEMO_SCHOOL = 'THPT Quế Võ 2';
    private const DEFAULT_DEMO_CLASS = 'Niên Khóa 2003-2006';
    private const DEFAULT_DEMO_YEAR = '2006';
    private const DEFAULT_EVENT_DATETIME = '2026-05-17T07:00:00+07:00';

    private function demoUserId(): ?int
    {
        return User::query()->value('id');
    }

    private function getDemoReunion(): Reunion
    {
        return Reunion::firstOrCreate(
            ['slug' => 'hop-lop-nien-khoa-2003-2006-que-vo-2'],
            [
                'school_name' => self::DEFAULT_DEMO_SCHOOL,
                'class_name' => self::DEFAULT_DEMO_CLASS,
                'graduation_year' => self::DEFAULT_DEMO_YEAR,
                'status' => 'published',
                'user_id' => $this->demoUserId(),
            ]
        );
    }

    public function show(Reunion $reunion, Request $request)
    {
        return $this->renderReunionTemplate($reunion, $this->resolveReunionViewPath($reunion));
    }

    public function showTeacherInvitation(Reunion $reunion, Request $request)
    {
        abort_unless($this->hasTeacherInvitation($reunion), 404);

        return $this->renderReunionTemplate($reunion, $this->resolveTeacherInvitationViewPath($reunion), 'teacher');
    }

    public function showThankYouLetter(Reunion $reunion, Request $request, ?string $recipient = null)
    {
        abort_unless($this->hasThankYouLetter($reunion), 404);

        return $this->renderReunionTemplate($reunion, 'templates.thank-you', 'thank_you', [
            'thank_you_recipient' => $this->resolveThankYouRecipient($reunion, $recipient ?: $request->query('to')),
        ]);
    }

    public function showQueVoDemo()
    {
        $reunion = Reunion::firstOrCreate(
            ['slug' => 'hop-lop-nien-khoa-1998-2001-que-vo-1'],
            [
                'school_name' => 'THPT Quế Võ Số 1',
                'class_name' => 'Niên Khóa 1998-2001',
                'graduation_year' => '2001',
                'status' => 'published',
                'user_id' => $this->demoUserId(),
            ]
        );

        $messages = $this->approvedMessages($reunion);

        $classDirs = [];
        for ($i = 1; $i <= 13; $i++) {
            $classDirs['A' . $i] = [];
        }

        return view('templates.que-vo-1', compact('reunion', 'messages', 'classDirs'));
    }

    public function showQueVoTeacherDemo()
    {
        $reunion = Reunion::firstOrCreate(
            ['slug' => 'hop-lop-que-vo-1-teacher'],
            [
                'school_name' => 'THPT Quế Võ Số 1',
                'class_name' => 'Niên Khóa 1998-2001 (Dành cho Thầy cô)',
                'graduation_year' => '2001',
                'status' => 'published',
                'user_id' => $this->demoUserId(),
            ]
        );

        $messages = $this->approvedMessages($reunion);

        $classDirs = [];
        for ($i = 1; $i <= 13; $i++) {
            $classDirs['A' . $i] = [];
        }

        return view('templates.que-vo-1-teacher', compact('reunion', 'messages', 'classDirs'));
    }

    public function showQueVo2Demo()
    {
        return $this->renderReunionTemplate(
            $this->getDemoReunion(),
            self::QUE_VO_2_TEMPLATE_VIEW
        );
    }

    private function renderReunionTemplate(Reunion $reunion, ?string $viewPath = null, string $audience = 'default', array $context = [])
    {
        $viewPath = $this->resolveTemplateView($viewPath);

        $classDirs = $this->getClassGalleryDirs($reunion, $viewPath);
        $content = $this->contentArray($reunion);

        $schoolInfo = $this->buildSchoolInfo($reunion, $content);
        $eventInfo = $this->buildEventInfo($reunion);
        $openLetter = $this->getOpenLetter($reunion, $content, $audience, $schoolInfo);
        $greeting = $this->getInvitationGreeting($content, $audience);
        $timeline = $this->getTimeline($content);
        $organizers = $this->getOrganizers($content);
        $messages = $this->approvedMessages($reunion);

        $event = $this->buildTemplateEventData(
            reunion: $reunion,
            schoolInfo: $schoolInfo,
            eventInfo: $eventInfo,
            openLetter: $openLetter,
            timeline: $timeline,
            organizers: $organizers,
            messages: $messages,
            classDirs: $classDirs,
            greeting: $greeting,
            audience: $audience,
            context: $context
        );

        $rsvpUrl = route('reunion.rsvp.store', ['reunion' => $reunion->slug]);

        return view($viewPath, compact(
            'event',
            'rsvpUrl',
            'reunion',

            // Giữ lại để các template cũ vẫn dùng được.
            'classDirs',
            'organizers',
            'eventInfo',
            'schoolInfo',
            'openLetter',
            'greeting',
            'timeline',
            'messages'
        ));
    }

    private function resolveReunionViewPath(Reunion $reunion): string
    {
        $template = $reunion->template;

        return $template?->is_active && $template?->type === 'reunion'
            ? $template->view_path
            : self::DEFAULT_TEMPLATE_VIEW;
    }

    private function resolveTeacherInvitationViewPath(Reunion $reunion): string
    {
        $templateId = (int) data_get($this->contentArray($reunion), 'teacher_invitation.template_id');

        if ($templateId > 0) {
            $template = Template::query()
                ->whereKey($templateId)
                ->where('type', 'reunion_teacher')
                ->where('is_active', true)
                ->first();

            if ($template?->view_path) {
                return $template->view_path;
            }
        }

        return $this->resolveReunionViewPath($reunion);
    }

    private function resolveTemplateView(?string $viewPath): string
    {
        return $viewPath && View::exists($viewPath)
            ? $viewPath
            : self::DEFAULT_TEMPLATE_VIEW;
    }

    private function contentArray(Reunion $reunion): array
    {
        return is_array($reunion->content) ? $reunion->content : [];
    }

    private function hasTeacherInvitation(Reunion $reunion): bool
    {
        return (bool) data_get($this->contentArray($reunion), 'teacher_invitation.enabled', false);
    }

    private function hasThankYouLetter(Reunion $reunion): bool
    {
        $content = $this->contentArray($reunion);

        return (bool) (
            data_get($content, 'thank_you_letter.enabled', false)
            ?: data_get($content, 'benefactor_thank_you.enabled', false)
        );
    }

    private function getThankYouRecipients(Reunion $reunion): array
    {
        $recipients = data_get($this->contentArray($reunion), 'thank_you_letter.recipients', []);

        if (!is_iterable($recipients)) {
            return [];
        }

        return collect($recipients)
            ->filter(fn ($item): bool => is_array($item) && trim((string) ($item['name'] ?? '')) !== '')
            ->map(function (array $item): array {
                $name = trim((string) ($item['name'] ?? ''));
                $code = trim((string) ($item['code'] ?? ''));

                return [
                    'name' => $name,
                    'role' => trim((string) ($item['role'] ?? '')),
                    'note' => trim((string) ($item['note'] ?? '')),
                    'code' => $code !== '' ? Str::slug($code) : Str::slug($name),
                ];
            })
            ->values()
            ->all();
    }

    private function resolveThankYouRecipient(Reunion $reunion, ?string $code): ?array
    {
        $code = Str::slug(trim((string) $code));

        if ($code === '') {
            return null;
        }

        return collect($this->getThankYouRecipients($reunion))
            ->first(fn (array $recipient): bool => ($recipient['code'] ?? '') === $code);
    }

    private function approvedMessages(Reunion $reunion)
    {
        return ReunionMessage::query()
            ->where('reunion_id', $reunion->id)
            ->where('is_approved', true)
            ->orderByDesc('created_at')
            ->get();
    }

    private function getClassGalleryDirs(Reunion $reunion, string $viewPath): array
    {
        $configuredClassDirs = $this->getConfiguredClassGalleryDirs($reunion);

        if (!empty($configuredClassDirs)) {
            return $configuredClassDirs;
        }

        $basePath = public_path('images/' . $reunion->slug);

        if ($viewPath === self::QUE_VO_2_TEMPLATE_VIEW && !is_dir($basePath)) {
            File::makeDirectory($basePath . '/A1', 0755, true, true);
        }

        $classDirs = $this->scanGalleryDir($basePath, $reunion->slug);

        if ($viewPath === self::QUE_VO_2_TEMPLATE_VIEW && empty($classDirs)) {
            $fallbackPath = public_path('images/que-vo-2');
            $classDirs = $this->scanGalleryDir($fallbackPath, 'que-vo-2');
        }

        return $classDirs;
    }

    private function getConfiguredClassGalleryDirs(Reunion $reunion): array
    {
        $albums = data_get($this->contentArray($reunion), 'class_albums', []);

        if (!is_iterable($albums)) {
            return [];
        }

        $classDirs = [];

        foreach ($albums as $album) {
            if (!is_array($album)) {
                continue;
            }

            $className = trim((string) ($album['name'] ?? ''));

            if ($className === '') {
                continue;
            }

            $photos = [];
            $coverImage = $this->publicDiskUrl($album['cover_image'] ?? null);

            if ($coverImage) {
                $photos[] = $coverImage;
            }

            foreach ($this->normalizeUploadPaths($album['photos'] ?? []) as $path) {
                $url = $this->publicDiskUrl($path);

                if ($url) {
                    $photos[] = $url;
                }
            }

            $classDirs[$className] = array_values(array_unique($photos));
        }

        uksort($classDirs, fn (string $first, string $second): int => strnatcasecmp($first, $second));

        return $classDirs;
    }

    private function normalizeUploadPaths(mixed $value): array
    {
        if (is_string($value)) {
            return [$value];
        }

        if (!is_array($value)) {
            return [];
        }

        $paths = [];

        foreach ($value as $item) {
            $paths = array_merge($paths, $this->normalizeUploadPaths($item));
        }

        return $paths;
    }

    private function publicDiskUrl(mixed $path): ?string
    {
        $paths = $this->normalizeUploadPaths($path);
        $path = trim((string) ($paths[0] ?? ''));

        if ($path === '') {
            return null;
        }

        $path = str_replace('\\', '/', $path);

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    private function scanGalleryDir(string $basePath, string $folderName): array
    {
        if (!is_dir($basePath)) {
            return [];
        }

        $classDirs = [];
        $dirs = array_filter(glob($basePath . '/*'), 'is_dir');

        sort($dirs, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($dirs as $dir) {
            $className = basename($dir);
            $photos = glob($dir . '/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE) ?: [];

            if (!empty($photos)) {
                sort($photos, SORT_NATURAL | SORT_FLAG_CASE);

                $classDirs[$className] = array_map(function ($path) use ($folderName) {
                    return '/images/' . $folderName . '/' . basename(dirname($path)) . '/' . basename($path);
                }, $photos);
            } else {
                $classDirs[$className] = [];
            }
        }

        return $classDirs;
    }

    private function buildSchoolInfo(Reunion $reunion, array $content): array
    {
        $className = trim((string) ($reunion->class_name ?: self::DEFAULT_DEMO_CLASS));

        $courseText = preg_match('/niên khóa/ui', $className)
            ? $className
            : 'Niên khóa ' . $className;

        return [
            'name' => $reunion->school_name ?: self::DEFAULT_DEMO_SCHOOL,
            'course' => $courseText,
            'years' => $this->formatGraduationYears($reunion->graduation_year),
            'anniversary' => data_get($content, 'schoolInfo.anniversary', '20 Năm'),
            'slogan' => data_get($content, 'schoolInfo.slogan', 'Trở Về Thanh Xuân'),
        ];
    }

    private function formatGraduationYears(?string $graduationYear): string
    {
        $graduationYear = trim((string) $graduationYear);

        if ($graduationYear === '') {
            return '2003 - 2006';
        }

        if (str_contains($graduationYear, '-')) {
            return preg_replace('/\s*-\s*/', ' - ', $graduationYear);
        }

        if (preg_match('/^\d{4}$/', $graduationYear)) {
            $endYear = (int) $graduationYear;
            return ($endYear - 3) . ' - ' . $endYear;
        }

        return $graduationYear;
    }

    private function buildEventInfo(Reunion $reunion): array
    {
        Carbon::setLocale('vi');

        $eventDate = $reunion->event_time ?? $reunion->event_date;
        $mapEmbedUrl = $this->extractMapEmbedUrl($reunion->map_iframe);

        $locationName = $reunion->venue_name ?: self::DEFAULT_DEMO_SCHOOL;
        $locationAddress = $reunion->venue_address ?: 'Phố Mới, Quế Võ, Bắc Ninh';

        return [
            'time' => $eventDate ? $eventDate->format('H\hi') : '07h00',
            'time_short' => $eventDate ? $eventDate->format('H\h') : '07h',
            'day' => $eventDate ? ucfirst($eventDate->isoFormat('dddd')) : 'Chủ nhật',
            'date' => $eventDate ? $eventDate->format('d/m/Y') : '17/05/2026',
            'date_formatted' => $eventDate ? $eventDate->format('d . m . Y') : '17 . 05 . 2026',
            'date_full_tail' => $eventDate ? $eventDate->format('d \t\h\á\n\g m \n\ă\m Y') : '17 tháng 05 năm 2026',
            'location_name' => $locationName,
            'location_address' => $locationAddress,
            'datetime_iso' => $eventDate ? $eventDate->format('Y-m-d\TH:i:sP') : self::DEFAULT_EVENT_DATETIME,
            'map_query' => urlencode($locationAddress),
            'map_url' => $reunion->map_url ?: 'https://maps.google.com/?q=' . urlencode($locationAddress),
            'map_iframe' => $mapEmbedUrl,
        ];
    }

    private function extractMapEmbedUrl(?string $mapIframe): string
    {
        $defaultMapUrl = 'https://www.google.com/maps?q=Tr%C6%B0%E1%BB%9Dng%20THPT%20Qu%E1%BA%BF%20V%C3%B5%202&output=embed';

        if (!$mapIframe) {
            return $defaultMapUrl;
        }

        if (preg_match('/src=["\']([^"\']+)["\']/', $mapIframe, $matches)) {
            return $matches[1];
        }

        return $mapIframe;
    }

    private function makeMapEmbed(?string $mapUrl): string
    {
        if (!$mapUrl) {
            $mapUrl = 'https://www.google.com/maps?q=Tr%C6%B0%E1%BB%9Dng%20THPT%20Qu%E1%BA%BF%20V%C3%B5%202&output=embed';
        }

        if (str_contains($mapUrl, '<iframe')) {
            return $mapUrl;
        }

        return '<iframe loading="lazy" src="' . e($mapUrl) . '" width="100%" height="300" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    }

    private function getInvitationGreeting(array $content, string $audience = 'default'): string
    {
        if ($audience === 'teacher') {
            $greeting = trim((string) data_get($content, 'teacher_invitation.greeting'));

            return $greeting !== '' ? $greeting : 'Kính gửi Quý thầy cô giáo';
        }

        if ($audience === 'thank_you') {
            $greeting = trim((string) (
                data_get($content, 'thank_you_letter.greeting')
                ?: data_get($content, 'benefactor_thank_you.greeting')
            ));

            return $greeting !== '' ? $greeting : 'Kính gửi Quý mạnh thường quân';
        }

        $greeting = trim((string) data_get($content, 'invitation_greeting'));

        return $greeting !== '' ? $greeting : 'Quý thầy cô & Các bạn';
    }

    private function getOpenLetter(Reunion $reunion, array $content, string $audience = 'default', array $schoolInfo = []): string
    {
        if ($audience === 'teacher') {
            $openLetter = trim((string) data_get($content, 'teacher_invitation.open_letter'));

            return $openLetter !== ''
                ? $openLetter
                : $this->defaultTeacherOpenLetter($schoolInfo);
        }

        if ($audience === 'thank_you') {
            $openLetter = trim((string) (
                data_get($content, 'thank_you_letter.open_letter')
                ?: data_get($content, 'benefactor_thank_you.open_letter')
            ));

            return $openLetter !== ''
                ? $openLetter
                : $this->defaultThankYouLetter($schoolInfo);
        }

        $openLetter = trim((string) data_get($content, 'open_letter'));

        return $openLetter !== ''
            ? $openLetter
            : '<p><strong>Trân trọng kính mời:</strong> Ban Giám hiệu các thời kỳ, quý thầy cô giáo cùng toàn thể các bạn cựu học sinh niên khóa 2003-2006.</p>
            <p>Thời gian trôi qua thật nhanh... mới ngày nào chúng ta còn là những cô cậu học trò hồn nhiên dưới mái trường THPT Quế Võ Số 2 thân yêu, vậy mà đã tròn 20 năm kể từ ngày chia tay.</p>
            <p>Hai mươi năm – mỗi người một hành trình, một ngả rẽ riêng. Nhưng chắc chắn rằng, trong sâu thẳm trái tim mỗi người vẫn luôn lưu giữ vẹn nguyên những ký ức của một thời áo trắng.</p>
            <p>✨ Nhân dịp kỷ niệm <strong>20 năm ngày ra trường</strong>, Ban liên lạc trân trọng kính mời Ban Giám hiệu cùng toàn thể các bạn khóa 2003–2006 trở về tham dự buổi hội ngộ đầy ý nghĩa.</p>
            <p>💛 Đây là dịp để chúng ta cùng gặp lại nhau, ôn lại những kỷ niệm đẹp và bày tỏ lòng tri ân sâu sắc tới quý thầy cô.</p>
            <p>💐 Rất mong sự hiện diện của quý thầy cô và toàn thể các bạn để buổi hội ngộ thêm trọn vẹn, ấm áp và đáng nhớ.</p>
            <p><strong>Hẹn gặp lại – Thanh xuân của chúng ta!</strong></p>';
    }

    private function defaultTeacherOpenLetter(array $schoolInfo): string
    {
        $schoolName = $schoolInfo['name'] ?? 'mái trường xưa';
        $course = $schoolInfo['course'] ?? 'niên khóa';
        $anniversary = $schoolInfo['anniversary'] ?? 'ngày hội ngộ';

        return '<p><strong>Trân trọng kính mời:</strong> Quý thầy cô giáo đã từng giảng dạy, dìu dắt tập thể ' . e($course) . ' - ' . e($schoolName) . '.</p>'
            . '<p>Nhân dịp ' . e($anniversary) . ' ngày ra trường, tập thể cựu học sinh kính mong được đón quý thầy cô về tham dự buổi hội ngộ, cùng ôn lại những kỷ niệm đẹp dưới mái trường xưa.</p>'
            . '<p>Sự hiện diện của quý thầy cô là niềm vinh dự và là món quà ý nghĩa nhất đối với tập thể chúng em.</p>'
            . '<p><strong>Ban liên lạc trân trọng kính mời.</strong></p>';
    }

    private function defaultThankYouLetter(array $schoolInfo): string
    {
        $schoolName = $schoolInfo['name'] ?? 'mái trường xưa';
        $course = $schoolInfo['course'] ?? 'niên khóa';
        $anniversary = $schoolInfo['anniversary'] ?? 'ngày hội ngộ';

        return '<p>Ban tổ chức chương trình ' . e($anniversary) . ' của tập thể ' . e($course) . ' - ' . e($schoolName) . ' xin được gửi lời cảm ơn chân thành tới Quý mạnh thường quân.</p>'
            . '<p>Sự đồng hành, sẻ chia và đóng góp quý báu của Quý vị đã tiếp thêm nguồn lực để chương trình được chuẩn bị chu đáo, ấm áp và ý nghĩa hơn.</p>'
            . '<p>Ban tổ chức trân trọng ghi nhận tấm lòng của Quý vị và kính chúc Quý vị cùng gia đình luôn mạnh khỏe, bình an, hạnh phúc và thành công.</p>'
            . '<p><strong>Xin trân trọng cảm ơn.</strong></p>';
    }

    private function getTimeline(array $content): array
    {
        $timeline = data_get($content, 'timeline');

        if (is_array($timeline) && !empty($timeline)) {
            return array_values($timeline);
        }

        return [
            [
                'time' => '7h00 - 8h00',
                'title' => 'Đón tiếp thầy cô và các bạn',
                'description' => 'Giao lưu, nhận áo đồng phục và chụp ảnh lưu niệm tại backdrop.',
                'is_highlight' => false,
            ],
            [
                'time' => '8h00 - 8h30',
                'title' => 'Văn nghệ chào mừng',
                'description' => 'Các tiết mục văn nghệ đặc sắc do cựu học sinh biểu diễn.',
                'is_highlight' => false,
            ],
            [
                'time' => '8h30 - 8h45',
                'title' => 'Phát biểu khai mạc',
                'description' => 'Tuyên bố lý do, giới thiệu đại biểu và khai mạc chương trình.',
                'is_highlight' => true,
            ],
            [
                'time' => '8h45 - 9h00',
                'title' => 'Phát biểu của Thầy Hiệu trưởng cũ',
                'description' => 'Lắng nghe những chia sẻ đầy kỷ niệm từ Thầy hiệu trưởng nhiệm kỳ 2003-2006.',
                'is_highlight' => false,
            ],
            [
                'time' => '9h00 - 9h15',
                'title' => 'Phát biểu của Thầy Hiệu trưởng đương nhiệm',
                'description' => 'Thầy hiệu trưởng hiện tại phát biểu về sự phát triển của nhà trường.',
                'is_highlight' => false,
            ],
            [
                'time' => '9h15 - 9h30',
                'title' => 'Phát biểu của Học sinh',
                'description' => 'Đại diện cựu học sinh gửi lời tri ân sâu sắc tới mái trường và thầy cô.',
                'is_highlight' => false,
            ],
            [
                'time' => '9h30 - 10h00',
                'title' => 'Tặng quà tri ân Thầy cô giáo',
                'description' => 'Gửi tặng những món quà ý nghĩa đến các thầy cô nguyên là giáo viên giảng dạy khóa 2003-2006.',
                'is_highlight' => true,
            ],
            [
                'time' => '10h00 - 10h15',
                'title' => 'Tặng quà Nhà trường',
                'description' => 'Tập thể cựu học sinh dâng tặng hoa và kỷ vật cho trường THPT Quế Võ 2.',
                'is_highlight' => false,
            ],
            [
                'time' => '10h15 - 10h30',
                'title' => 'Chúc mừng BGH',
                'description' => 'Tập thể Ban tổ chức lên tặng hoa và chúc sức khỏe Ban Giám Hiệu.',
                'is_highlight' => false,
            ],
            [
                'time' => '10h30 - 10h45',
                'title' => 'Trao bằng vinh danh BTC',
                'description' => 'Vinh danh cảm ơn các cá nhân Tập thể BTC đã tích cực kết nối và xây dựng chương trình.',
                'is_highlight' => false,
            ],
            [
                'time' => '11h00 - 11h30',
                'title' => 'Chụp ảnh dạo quanh trường xưa',
                'description' => 'Di chuyển quanh sân trường, các góc lớp để cùng nhau lưu lại bức ảnh Thanh Xuân.',
                'is_highlight' => true,
            ],
        ];
    }

    private function getOrganizers(array $content): array
    {
        $organizers = data_get($content, 'organizers');

        if (is_array($organizers) && !empty($organizers)) {
            return array_values($organizers);
        }

        return [
            [
                'role' => 'T/M Ban liên lạc – Trưởng Ban tổ chức',
                'name' => 'Ban Tổ Chức',
                'phone' => '',
            ],
        ];
    }

    private function buildTemplateEventData(
        Reunion $reunion,
        array $schoolInfo,
        array $eventInfo,
        string $openLetter,
        array $timeline,
        array $organizers,
        $messages,
        array $classDirs,
        string $greeting = 'Quý thầy cô & Các bạn',
        string $audience = 'default',
        array $context = []
    ): object {
        $isTeacherInvitation = $audience === 'teacher';
        $isThankYouLetter = $audience === 'thank_you';
        $logoUrl = $reunion->getLogoUrl();
        $shareUrl = $reunion->getShareUrl();
        $coverUrl = $reunion->getCoverUrl();
        $heroUrl = $reunion->getHeroUrl();

        $heroPhoto1Url = $reunion->getHeroPhoto1Url();
        $heroPhoto2Url = $reunion->getHeroPhoto2Url();
        $heroPhoto3Url = $reunion->getHeroPhoto3Url();

        $videoCoverUrl = $reunion->getVideoCoverUrl();
        $videoUrl = $reunion->getVideoUrl();

        $templateMedia = $this->mapTemplateMedia($reunion);

        $eventName = $schoolInfo['name'] ?? 'Trường THPT';
        $eventCourse = $schoolInfo['course'] ?? 'Niên khóa';
        $eventAnniversary = $schoolInfo['anniversary'] ?? 'Ngày hội ngộ';
        $eventSlogan = $schoolInfo['slogan'] ?? 'Trở về thanh xuân';

        $eventDateLabel = trim(
            ($eventInfo['time_short'] ?? '') . ' ' .
            ($eventInfo['day'] ?? '') . ', ' .
            ($eventInfo['date'] ?? '')
        );

        $eventAddress = trim(
            ($eventInfo['location_address'] ?? ''),
            ' -'
        );

        $openLetterText = $this->htmlToPlainText($openLetter);
        $content = $this->contentArray($reunion);
        $thankYouRecipients = $this->getThankYouRecipients($reunion);
        $thankYouRecipient = $context['thank_you_recipient'] ?? null;
        $eventSlug = match ($audience) {
            'teacher' => $reunion->slug . '/thay-co',
            'thank_you' => $reunion->slug . '/thu-cam-on' . (!empty($thankYouRecipient['code']) ? '/' . $thankYouRecipient['code'] : ''),
            default => $reunion->slug,
        };
        $eventUrl = url('/' . $eventSlug);
        $teacherInvitationUrl = $this->hasTeacherInvitation($reunion)
            ? url('/' . $reunion->slug . '/thay-co')
            : null;
        $thankYouLetterUrl = $this->hasThankYouLetter($reunion)
            ? url('/' . $reunion->slug . '/thu-cam-on')
            : null;

        $defaultTitle = match ($audience) {
            'teacher' => 'Thư Mời Thầy Cô | ' . $eventName,
            'thank_you' => 'Thư Cảm Ơn' . (!empty($thankYouRecipient['name']) ? ' ' . $thankYouRecipient['name'] : '') . ' | ' . $eventName,
            default => 'Thư Mời Họp Lớp | ' . $eventName,
        };

        $defaultMetaDescription = match ($audience) {
            'teacher' => $this->makeDefaultTeacherMetaDescription($eventName, $eventCourse, $eventInfo),
            'thank_you' => $this->makeDefaultThankYouMetaDescription($eventName, $eventCourse),
            default => $this->makeDefaultMetaDescription($eventName, $eventCourse, $eventAnniversary, $eventInfo),
        };

        $metaTitlePath = match ($audience) {
            'teacher' => 'teacher_invitation.seo.title',
            'thank_you' => 'thank_you_letter.seo.title',
            default => 'seo.title',
        };
        $metaDescriptionPath = match ($audience) {
            'teacher' => 'teacher_invitation.seo.description',
            'thank_you' => 'thank_you_letter.seo.description',
            default => 'seo.description',
        };
        $fallbackMetaTitle = $audience === 'thank_you'
            ? data_get($content, 'benefactor_thank_you.seo.title')
            : null;
        $fallbackMetaDescription = $audience === 'thank_you'
            ? data_get($content, 'benefactor_thank_you.seo.description')
            : null;
        $metaTitle = $this->cleanMetaText(data_get($content, $metaTitlePath) ?: $fallbackMetaTitle) ?: $defaultTitle;
        $metaDescription = $this->cleanMetaText(data_get($content, $metaDescriptionPath) ?: $fallbackMetaDescription) ?: $defaultMetaDescription;
        $description = match ($audience) {
            'teacher' => '<p>Trân trọng kính mời quý thầy cô tham dự ngày hội ngộ - ' . e($eventSlogan) . '</p>',
            'thank_you' => '<p>Trân trọng cảm ơn ' . e($thankYouRecipient['name'] ?? 'Quý mạnh thường quân') . ' đã đồng hành cùng chương trình - ' . e($eventSlogan) . '</p>',
            default => '<p>' . e($eventAnniversary) . ' ngày ra trường - ' . e($eventSlogan) . '</p>',
        };

        return (object) [
            'title' => $metaTitle,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'slug' => $eventSlug,
            'url' => $eventUrl,
            'canonical_url' => $eventUrl,
            'main_url' => url('/' . $reunion->slug),
            'teacher_url' => $teacherInvitationUrl,
            'thank_you_url' => $thankYouLetterUrl,
            'benefactor_url' => $thankYouLetterUrl,
            'thank_you_recipient' => $thankYouRecipient,
            'thank_you_recipients' => $thankYouRecipients,
            'audience' => $audience,
            'is_teacher_invitation' => $isTeacherInvitation,
            'is_thank_you_letter' => $isThankYouLetter,
            'is_benefactor_thank_you' => $isThankYouLetter,
            'open_letter_title' => $isThankYouLetter ? 'Thư cảm ơn' : 'Thư ngỏ',
            'open_letter_nav_label' => $isThankYouLetter ? 'Thư cảm ơn' : 'Thư ngỏ',
            'open_letter_sign' => $isThankYouLetter ? 'Ban tổ chức trân trọng cảm ơn' : 'Ban tổ chức trân trọng kính mời',

            // Có cả 2 tên để không vỡ Blade cũ.
            'course_name' => $eventCourse,
            'cource_name' => $eventCourse,

            'school_name' => $eventName,
            'greeting' => $greeting,

            // Media dùng chung.
            'logo' => $logoUrl,
            'share_image' => $shareUrl,
            'cover' => $coverUrl,
            'video_cover' => $videoCoverUrl,
            'video_url' => $videoUrl,

            // Media hero.
            'hero_image' => $heroUrl,
            'background' => $heroUrl,
            'hero_photo_1' => $heroPhoto1Url,
            'hero_photo_2' => $heroPhoto2Url,
            'hero_photo_3' => $heroPhoto3Url,

            // Toàn bộ media động theo template.media_schema.
            // Blade có thể gọi: $event->media['hero_photo_1'] ?? null
            'media' => $templateMedia,

            'slogan' => $this->makeHeroSlogan($eventSlogan),
            'description' => $description,
            'time' => $eventDateLabel,
            'address' => $eventAddress,

            'thungo' => $openLetterText,
            'programs' => $this->mapTimelineForTemplate($timeline),
            'classes' => $this->mapClassesForTemplate($classDirs, $heroUrl),
            'album_photos' => $this->mapAlbumPhotosForTemplate($reunion, $classDirs),
            'album_masonry_enabled' => (bool) data_get($content, 'album_masonry_enabled', true),
            'guestbooks' => $this->mapMessagesForTemplate($messages),
            'contacts' => $this->mapOrganizersForTemplate($organizers),

            'map_embed' => $this->makeMapEmbed($eventInfo['map_iframe'] ?? null),
            'countdown_time' => $eventInfo['datetime_iso'] ?? self::DEFAULT_EVENT_DATETIME,
            'time_countdown' => $eventInfo['datetime_iso'] ?? self::DEFAULT_EVENT_DATETIME,
        ];
    }

    private function makeDefaultMetaDescription(string $eventName, string $eventCourse, string $eventAnniversary, array $eventInfo): string
    {
        $eventDate = trim(
            ($eventInfo['time'] ?? '') . ' ' .
            ($eventInfo['day'] ?? '') . ' ' .
            ($eventInfo['date'] ?? '')
        );

        return trim(
            'Thư mời họp lớp ' . $eventCourse . ' - ' . $eventName . '. ' .
            $eventAnniversary . ' ngày ra trường. ' .
            $eventDate . '.',
            " .\t\n\r\0\x0B"
        ) . '.';
    }

    private function makeDefaultTeacherMetaDescription(string $eventName, string $eventCourse, array $eventInfo): string
    {
        $eventDate = trim(
            ($eventInfo['time'] ?? '') . ' ' .
            ($eventInfo['day'] ?? '') . ' ' .
            ($eventInfo['date'] ?? '')
        );

        return trim(
            'Trân trọng kính mời quý thầy cô tham dự buổi hội ngộ ' . $eventCourse . ' - ' . $eventName . '. ' .
            $eventDate . '.',
            " .\t\n\r\0\x0B"
        ) . '.';
    }

    private function makeDefaultThankYouMetaDescription(string $eventName, string $eventCourse): string
    {
        return 'Thư cảm ơn Quý mạnh thường quân đã đồng hành cùng chương trình hội ngộ ' . $eventCourse . ' - ' . $eventName . '.';
    }

    private function cleanMetaText(mixed $value): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return '';
        }

        return trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }

    private function mapTemplateMedia(Reunion $reunion): array
    {
        $schema = $reunion->template?->media_schema;

        if (!is_array($schema)) {
            return [];
        }

        $media = [];

        foreach (($schema['groups'] ?? []) as $group) {
            foreach (($group['fields'] ?? []) as $field) {
                $key = $field['key'] ?? null;
                $collection = $field['collection'] ?? $key;

                if (!$key || !$collection) {
                    continue;
                }

                $media[$key] = $reunion->getMediaUrlByCollection($collection);
            }
        }

        return $media;
    }

    private function htmlToPlainText(?string $html): string
    {
        $html = (string) $html;

        $text = str_replace(
            ['</p>', '<br>', '<br/>', '<br />'],
            "\n",
            $html
        );

        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace("/\n{3,}/", "\n\n", $text));
    }

    private function mapTimelineForTemplate(array $timeline)
    {
        return collect($timeline)
            ->map(fn ($item) => (object) [
                'time' => $item['time'] ?? '',
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'is_highlight' => (bool) ($item['is_highlight'] ?? false),
            ])
            ->values();
    }

    private function mapClassesForTemplate(array $classDirs, string $fallbackImage)
    {
        return collect($classDirs)
            ->map(function ($photos, $className) use ($fallbackImage) {
                $photos = is_array($photos)
                    ? array_values(array_filter($photos))
                    : [];

                $firstPhoto = !empty($photos)
                    ? $photos[0]
                    : $fallbackImage;

                return (object) [
                    'name' => $className,
                    'thumbnail' => $firstPhoto,
                    'url' => !empty($photos) ? $photos[0] : '#',
                    'photos' => $photos,
                    'photo_count' => count($photos),
                ];
            })
            ->values();
    }

    private function mapAlbumPhotosForTemplate(Reunion $reunion, array $classDirs)
    {
        $photos = collect();

        foreach ($reunion->getMedia('gallery') as $index => $media) {
            if (!Str::startsWith((string) $media->mime_type, 'image/')) {
                continue;
            }

            $url = $media->getUrl();

            if (!$url) {
                continue;
            }

            $photos->push((object) [
                'url' => $url,
                'thumb' => $url,
                'title' => $media->name ?: 'Ảnh kỷ niệm ' . ($index + 1),
                'source' => 'gallery',
            ]);
        }

        foreach ($classDirs as $className => $classPhotos) {
            foreach ((array) $classPhotos as $index => $photo) {
                $photo = trim((string) $photo);

                if ($photo === '') {
                    continue;
                }

                $photos->push((object) [
                    'url' => $photo,
                    'thumb' => $photo,
                    'title' => trim((string) $className) !== ''
                        ? $className . ' - Ảnh ' . ($index + 1)
                        : 'Ảnh kỷ niệm ' . ($index + 1),
                    'source' => 'class_album',
                ]);
            }
        }

        return $photos
            ->unique('url')
            ->values()
            ->take(100);
    }

    private function mapMessagesForTemplate($messages)
    {
        return collect($messages)
            ->map(fn ($message) => (object) [
                'name' => $message->name ?? '',
                'class_name' => '',
                'content' => $message->content ?? '',
            ])
            ->values();
    }

    private function mapOrganizersForTemplate(array $organizers)
    {
        return collect($organizers)
            ->map(fn ($item) => (object) [
                'role' => $item['role'] ?? 'Ban tổ chức',
                'name' => $item['name'] ?? 'Ban Tổ Chức',
                'phone' => $item['phone'] ?? '',
            ])
            ->values();
    }

    private function makeHeroSlogan(?string $slogan): string
    {
        $slogan = trim($slogan ?: 'Trở Về Thanh Xuân');

        $words = preg_split('/\s+/u', $slogan);

        if (count($words) <= 2) {
            return '<span class="pretitle">' . e($slogan) . '</span>';
        }

        $lineOne = implode(' ', array_slice($words, 0, 2));
        $lineTwo = implode(' ', array_slice($words, 2));

        return '<span class="pretitle">' . e($lineOne) . '</span><h3>' . e($lineTwo) . '</h3>';
    }

    public function storeRsvpDemo(Request $request)
    {
        return $this->storeRsvpForReunion($request, $this->getDemoReunion());
    }

    public function storeRsvp(Request $request, Reunion $reunion)
    {
        return $this->storeRsvpForReunion($request, $reunion);
    }

    private function storeRsvpForReunion(Request $request, Reunion $reunion)
    {
        $key = 'rsvp:' . $reunion->id . ':' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 10)) {
            return response()->json([
                'message' => 'Bạn đã gửi quá nhiều lần. Vui lòng thử lại sau.',
            ], 429);
        }

        RateLimiter::hit($key, 3600);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'guest_count' => 'nullable|integer|min:1|max:50',
            'class' => 'nullable|string|max:100',
            'note' => 'nullable|string|max:500',
        ]);

        $noteLines = [];

        if (!empty($validated['class'])) {
            $noteLines[] = 'Lớp: ' . $validated['class'];
        }

        if (!empty($validated['note'])) {
            $noteLines[] = $validated['note'];
        }

        ReunionRsvp::create([
            'reunion_id' => $reunion->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'guest_count' => $validated['guest_count'] ?? 1,
            'note' => implode(PHP_EOL, $noteLines),
            'status' => 'attending',
        ]);

        return response()->json(['success' => true]);
    }

    public function storeMessageDemo(Request $request)
    {
        return $this->storeMessageForReunion($request, $this->getDemoReunion());
    }

    public function storeMessage(Request $request, Reunion $reunion)
    {
        return $this->storeMessageForReunion($request, $reunion);
    }

    private function storeMessageForReunion(Request $request, Reunion $reunion)
    {
        $key = 'message:' . $reunion->id . ':' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'message' => 'Bạn đã gửi quá nhiều lần. Vui lòng thử lại sau.',
            ], 429);
        }

        RateLimiter::hit($key, 3600);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        ReunionMessage::create([
            'reunion_id' => $reunion->id,
            'name' => $validated['name'],
            'content' => $validated['content'],
            'is_approved' => (bool) $reunion->is_auto_approve_messages,
        ]);

        return response()->json(['success' => true]);
    }
}
