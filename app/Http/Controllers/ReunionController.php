<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reunion;
use App\Models\ReunionRsvp;
use App\Models\ReunionMessage;

use Illuminate\Support\Facades\RateLimiter;

class ReunionController extends Controller
{
    private function getDemoReunion(): Reunion
    {
        return Reunion::firstOrCreate(
            ['slug' => 'hop-lop-nien-khoa-2003-2006-que-vo-2'],
            [
                'school_name' => 'THPT Quế Võ 2', 
                'class_name' => 'Niên Khóa 2003-2006', 
                'graduation_year' => '2006', 
                'status' => 'published',
                'user_id' => 1
            ]
        );
    }

    public function show(Reunion $reunion, Request $request)
    {
        // Forward dynamic slugs to our Que Vo 2 interface for now
        // since it's the main template we are working with.
        return $this->renderQueVo2($reunion);
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
                'user_id' => 1
            ]
        );
        $messages = \App\Models\ReunionMessage::where('reunion_id', $reunion->id)
                        ->where('is_approved', true)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $classDirs = [];
        for ($i = 1; $i <= 13; $i++) {
            $classDirs['12A' . $i] = [];
        }

        return view('reunions.que-vo-1', compact('reunion', 'messages', 'classDirs'));
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
                'user_id' => 1
            ]
        );
        $messages = \App\Models\ReunionMessage::where('reunion_id', $reunion->id)
                        ->where('is_approved', true)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $classDirs = [];
        for ($i = 1; $i <= 13; $i++) {
            $classDirs['12A' . $i] = [];
        }

        return view('reunions.que-vo-1-teacher', compact('reunion', 'messages', 'classDirs'));
    }

    public function showQueVo2Demo()
    {
        $reunion = $this->getDemoReunion();
        return $this->renderQueVo2($reunion);
    }

    private function scanGalleryDir(string $basePath, string $folderName): array
    {
        $classDirs = [];
        if (is_dir($basePath)) {
            $dirs = array_filter(glob($basePath . '/*'), 'is_dir');
            sort($dirs, SORT_NATURAL | SORT_FLAG_CASE);
            foreach ($dirs as $dir) {
                $className = basename($dir);
                $photos = glob($dir . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
                if (!empty($photos)) {
                    sort($photos, SORT_NATURAL | SORT_FLAG_CASE);
                    $classDirs[$className] = array_map(function ($p) use ($folderName) {
                        return '/images/' . $folderName . '/' . basename(dirname($p)) . '/' . basename($p);
                    }, $photos);
                }
            }
        }
        return $classDirs;
    }

    private function renderQueVo2(Reunion $reunion)
    {
        $basePath = public_path('images/' . $reunion->slug);
        
        // Auto create folder if missing
        if (!is_dir($basePath)) {
            \Illuminate\Support\Facades\File::makeDirectory($basePath . '/12A1', 0755, true, true);
        }

        $classDirs = $this->scanGalleryDir($basePath, $reunion->slug);

        // Fallback thư mục tĩnh mẫu nếu rỗng
        if (empty($classDirs)) {
            $fallbackPath = public_path('images/que-vo-2');
            $classDirs = $this->scanGalleryDir($fallbackPath, 'que-vo-2');
        }

        $organizers = $reunion->content['organizers'] ?? [
            [
                'role' => 'T/M Ban liên lạc – Trưởng Ban tổ chức',
                'name' => 'Ban Tổ Chức',
                'phone' => ''
            ]
        ];

        /* ... existing variable definitions ... */

        $className = $reunion->class_name ?: '2003-2006';
        $courseText = mb_stripos($className, 'niên khóa') !== false 
            ? $className 
            : 'Niên khóa ' . $className;

        $schoolInfo = [
            'name' => $reunion->school_name ?: 'Trường THPT Quế Võ 2',
            'course' => $courseText,
            'years' => $reunion->graduation_year ? (str_contains($reunion->graduation_year, '-') ? $reunion->graduation_year : ((int)$reunion->graduation_year - 3) . ' - ' . $reunion->graduation_year) : '2003 - 2006',
            'anniversary' => $reunion->content['schoolInfo']['anniversary'] ?? '20 Năm',
            'slogan' => $reunion->content['schoolInfo']['slogan'] ?? 'Trở Về Thanh Xuân',
        ];

        \Carbon\Carbon::setLocale('vi');
        // Ưu tiên event_time (chứa cả giờ chính xác), dự phòng event_date cũ
        $eventDate = $reunion->event_time ?? $reunion->event_date;

        // Xử lý thông minh: Nếu Admin dán nguyên cục <iframe> của Google Maps, tự động bóc tách lấy mỗi cái <src> url để khỏi bị lỗi 404
        $mapIframe = $reunion->map_iframe;
        if ($mapIframe && preg_match('/src="([^"]+)"/', $mapIframe, $matches)) {
            $mapIframe = $matches[1];
        }

        $eventInfo = [
            'time' => $eventDate ? $eventDate->format('H\hi') : '07h00',
            'time_short' => $eventDate ? $eventDate->format('H\h') : '07h',
            'day' => $eventDate ? ucfirst($eventDate->isoFormat('dddd')) : 'Chủ nhật',
            'date' => $eventDate ? $eventDate->format('d/m/Y') : '17/05/2026',
            'date_formatted' => $eventDate ? $eventDate->format('d . m . Y') : '17 . 05 . 2026',
            'date_full_tail' => $eventDate ? $eventDate->format('d \t\h\á\n\g m \n\ă\m Y') : '17 tháng 05 năm 2026',
            'location_name' => $reunion->venue_name ?? 'Trường THPT Quế Võ 2',
            'location_address' => $reunion->venue_address ?? 'Phố Mới, Quế Võ, Bắc Ninh',
            'datetime_iso' => $eventDate ? $eventDate->format('Y-m-d\TH:i:sP') : '2026-05-17T07:00:00+07:00',
            'map_query' => urlencode($reunion->venue_address ?? 'Truong+THPT+Que+Vo+2+Bac+Ninh'),
            'map_iframe' => $mapIframe ?: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3726.5!2d106.1614!3d21.1234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDA3JzI0LjQiTiAxMDbCsDA5JzQxLjAiRQ!5e0!3m2!1svi!2s!4v1234567890'
        ];
        
        $openLetter = $reunion->getContentValue('open_letter', '<p><strong>Trân trọng kính mời:</strong> Ban Giám hiệu các thời kỳ, quý thầy cô giáo cùng toàn thể các bạn cựu học sinh niên khóa 2003-2006.</p><p>Thời gian trôi qua thật nhanh... mới ngày nào chúng ta còn là những cô cậu học trò hồn nhiên dưới mái trường THPT Quế Võ Số 2 thân yêu, vậy mà đã tròn 20 năm kể từ ngày chia tay.</p><p>Hai mươi năm – mỗi người một hành trình, một ngả rẽ riêng. Nhưng chắc chắn rằng, trong sâu thẳm trái tim mỗi người vẫn luôn lưu giữ vẹn nguyên những ký ức của một thời áo trắng.</p><p>✨ Nhân dịp kỷ niệm <strong>20 năm ngày ra trường</strong>, Ban liên lạc trân trọng kính mời Ban Giám hiệu, quý thầy cô giáo cùng toàn thể các bạn khóa 2003–2006 trở về tham dự buổi hội ngộ đầy ý nghĩa.</p><p>💛 Đây là dịp để chúng ta cùng gặp lại nhau, ôn lại những kỷ niệm đẹp và bày tỏ lòng tri ân sâu sắc tới Ban Giám hiệu cùng quý thầy cô.</p><p>💐 Rất mong sự hiện diện của quý thầy cô và toàn thể các bạn để buổi hội ngộ thêm trọn vẹn, ấm áp và đáng nhớ.</p><p><strong>Hẹn gặp lại – Thanh xuân của chúng ta!</strong></p>');
        $greeting = $reunion->getContentValue('invitation_greeting', 'Quý thầy cô & Các bạn');

        $messages = \App\Models\ReunionMessage::where('reunion_id', $reunion->id)
                        ->where('is_approved', true)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('reunions.que-vo-2', compact('classDirs', 'organizers', 'eventInfo', 'schoolInfo', 'openLetter', 'greeting', 'messages', 'reunion'));
    }

    public function storeRsvpDemo(Request $request)
    {
        $key = 'rsvp:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            return response()->json(['message' => 'Bạn đã gửi quá nhiều lần. Vui lòng thử lại sau.'], 429);
        }
        RateLimiter::hit($key, 3600);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'guest_count' => 'nullable|integer|min:1|max:50',
            'class' => 'nullable|string|max:100',
            'note' => 'nullable|string|max:500',
        ]);

        $reunion = $this->getDemoReunion();

        $note = $validated['note'] ?? '';
        if (!empty($validated['class'])) {
            $classNote = 'Lớp: ' . $validated['class'];
            $note = $note ? $classNote . "\n" . $note : $classNote;
        }

        ReunionRsvp::create([
            'reunion_id' => $reunion->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'guest_count' => $validated['guest_count'] ?? 1,
            'note' => $note,
            'status' => 'attending',
        ]);

        return response()->json(['success' => true]);
    }

    public function storeMessageDemo(Request $request)
    {
        $key = 'message:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['message' => 'Bạn đã gửi quá nhiều lần. Vui lòng thử lại sau.'], 429);
        }
        RateLimiter::hit($key, 3600);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $reunion = $this->getDemoReunion();

        ReunionMessage::create([
            'reunion_id' => $reunion->id,
            'name' => $validated['name'],
            'content' => $validated['content'],
            'is_approved' => true,
        ]);

        return response()->json(['success' => true]);
    }
}
