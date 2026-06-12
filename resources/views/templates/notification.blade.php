{{-- Template Name: Trang thông báo chương trình --}}
{{-- Template Type: reunion_notification --}}
@extends('layouts.reunion')

@section('title', $event->title)
@section('meta_title', $event->meta_title)
@section('meta_description', $event->meta_description)
@section('share_image', $event->share_image)
@section('canonical_url', $event->canonical_url ?? url('/' . $event->slug))

@push('styles')
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: #fff8eb;
            color: #14213d;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-accent {
            font-family: 'Dancing Script', cursive;
        }

        .notification-timeline:before {
            content: '';
            position: absolute;
            left: 1.5rem;
            top: .75rem;
            bottom: .75rem;
            width: 4px;
            border-radius: 999px;
            background: linear-gradient(180deg, #1d4ed8, #dc2626, #f59e0b, #16a34a, #7c3aed);
            box-shadow: 0 0 0 8px rgba(255, 255, 255, .78);
        }

        @media (min-width: 768px) {
            .notification-timeline:before {
                left: 2.25rem;
                transform: none;
            }
        }

        .program-card {
            box-shadow: 0 18px 50px rgba(21, 74, 140, .1);
        }

        .memory-polaroid {
            position: relative;
            width: min(92vw, 620px);
            aspect-ratio: 1 / 1;
            filter: drop-shadow(0 28px 45px rgba(48, 37, 23, .2));
        }

        .memory-polaroid__photo {
            position: absolute;
            left: 51.85%;
            top: 46.36%;
            width: 46.92%;
            height: 44.51%;
            transform: translate(-50%, -50%) rotate(3.85deg);
            transform-origin: center;
            overflow: hidden;
            z-index: 1;
            background: #111;
        }

        .memory-polaroid__photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .memory-polaroid__frame {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            z-index: 2;
            pointer-events: none;
            user-select: none;
        }

        .decor-float {
            position: absolute;
            pointer-events: none;
            user-select: none;
            z-index: 0;
        }

        @media (max-width: 768px) {
            .memory-polaroid {
                width: min(96vw, 430px);
            }
        }
    </style>
@endpush

@section('body_class', 'bg-[#fff8eb] text-slate-950 antialiased overflow-x-hidden')

@section('content')
    @php
        $notification = $event->notification ?? null;
        $timelineItems = collect($notification->timeline ?? $event->programs ?? []);
        $mainUrl = $event->main_url ?? url('/' . $reunion->slug);
        $pageUrl = $event->canonical_url ?? url('/' . $event->slug);
        $heroImage = $event->share_image ?: ($event->hero_image ?? $event->background ?? null);
        $logoImage = $event->logo ?: null;
        if (!$logoImage || str_contains($logoImage, 'default-logo')) {
            $logoImage = asset('images/20-nam-tro-ve-thanh-xuan.png');
        }
        $polaroidImage = $logoImage;
        $videoUrl = $event->video_url ?? null;
        $videoCover = $event->video_cover ?? $event->cover ?? $heroImage;
        $showVideo = (bool) ($notification->show_video ?? true);
        $showOrganizers = (bool) ($notification->show_organizers ?? true);
        $contacts = collect($event->contacts ?? [])->filter(fn ($item) => !empty($item->name) || !empty($item->phone));
        $programName = $schoolInfo['anniversary'] ?? 'Ngày hội ngộ';
        $programSlogan = $schoolInfo['slogan'] ?? 'Trở về thanh xuân';
        $countdownTarget = $event->countdown_time ?? $event->time_countdown ?? null;
        $locationLabel = trim((string) ($event->address ?? ($eventInfo['location_address'] ?? '') ?: ($eventInfo['location_name'] ?? '')));
    @endphp

    <main class="min-h-screen bg-[#fff8eb]">
        <section class="relative isolate overflow-hidden bg-[#fff4dc]">
            @if($heroImage)
                <img src="{{ $heroImage }}" alt="{{ $event->school_name }}" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-16">
            @endif
            <div class="absolute inset-0 -z-10 bg-[linear-gradient(135deg,rgba(255,251,240,.98),rgba(231,246,255,.9)_48%,rgba(255,238,220,.92))]"></div>
            <div class="absolute inset-x-0 bottom-0 -z-10 h-32 bg-gradient-to-t from-[#fff8eb] to-transparent"></div>
            <img src="{{ asset('images/decor/hoa-phuong-do.png') }}" alt="" class="decor-float right-[-7rem] top-[-4rem] hidden w-80 rotate-[-8deg] opacity-90 lg:block">
            <img src="{{ asset('images/decor/hoa-bang-lang.png') }}" alt="" class="decor-float bottom-[-8rem] left-[-7rem] hidden w-80 rotate-12 opacity-85 lg:block">
            <img src="{{ asset('images/decor/4.png') }}" alt="" class="decor-float right-[35%] top-16 hidden w-44 opacity-80 xl:block">
            <img src="{{ asset('images/decor/6.png') }}" alt="" class="decor-float bottom-8 right-[3%] hidden w-48 opacity-75 lg:block">

            <div class="relative z-10 mx-auto grid min-h-[92vh] max-w-7xl gap-9 px-5 py-8 sm:px-8 lg:grid-cols-[minmax(0,1fr)_560px] lg:items-center lg:py-12">
                <div class="pt-12 lg:pt-0" data-aos="fade-right" data-aos-duration="900">
                    <a href="{{ $mainUrl }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-full border border-blue-200 bg-white/80 px-4 text-xs font-bold uppercase tracking-[0.16em] text-blue-800 shadow-sm backdrop-blur transition hover:border-blue-300 hover:bg-white">
                        <i class="fa fa-arrow-left text-[11px]"></i>
                        Trang chương trình
                    </a>

                    <div class="mt-9 flex items-center gap-5" data-aos="fade-up" data-aos-delay="80">
                        <img src="{{ $logoImage }}" alt="{{ $event->school_name }}" class="h-24 w-24 rounded-full object-contain ring-8 ring-white/80 sm:h-32 sm:w-32">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-red-700">{{ $event->school_name }}</p>
                            <p class="mt-2 text-lg font-bold text-blue-900">{{ $event->course_name }}</p>
                        </div>
                    </div>

                    <h1 class="mt-8 font-serif text-4xl font-black leading-[1.05] text-blue-950 sm:text-6xl lg:text-7xl" data-aos="fade-up" data-aos-delay="140">
                        Ban liên lạc xin trân trọng thông báo
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-700 sm:text-lg" data-aos="fade-up" data-aos-delay="200">
                        Chương trình {{ $programName }} - {{ $programSlogan }} của {{ $event->course_name }} sẽ được tổ chức tại {{ $locationLabel ?: 'địa điểm chương trình' }}.
                    </p>

                    @if($countdownTarget)
                        <div class="mt-8 max-w-2xl rounded-lg border border-[#ead8b4] bg-white/82 p-4 shadow-[0_18px_45px_rgba(77,54,20,.1)] backdrop-blur" data-countdown-target="{{ $countdownTarget }}" data-aos="zoom-in" data-aos-delay="260">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-red-700">Chỉ còn</p>
                            <div class="mt-4 grid grid-cols-4 gap-2 sm:gap-3">
                                <div class="rounded-md bg-blue-950 px-2 py-3 text-center text-white">
                                    <strong class="block text-2xl font-black sm:text-3xl" data-countdown-days>00</strong>
                                    <span class="mt-1 block text-[11px] font-bold uppercase tracking-[0.12em] text-blue-100">Ngày</span>
                                </div>
                                <div class="rounded-md bg-red-700 px-2 py-3 text-center text-white">
                                    <strong class="block text-2xl font-black sm:text-3xl" data-countdown-hours>00</strong>
                                    <span class="mt-1 block text-[11px] font-bold uppercase tracking-[0.12em] text-red-100">Giờ</span>
                                </div>
                                <div class="rounded-md bg-amber-500 px-2 py-3 text-center text-blue-950">
                                    <strong class="block text-2xl font-black sm:text-3xl" data-countdown-minutes>00</strong>
                                    <span class="mt-1 block text-[11px] font-bold uppercase tracking-[0.12em] text-blue-950">Phút</span>
                                </div>
                                <div class="rounded-md bg-emerald-600 px-2 py-3 text-center text-white">
                                    <strong class="block text-2xl font-black sm:text-3xl" data-countdown-seconds>00</strong>
                                    <span class="mt-1 block text-[11px] font-bold uppercase tracking-[0.12em] text-emerald-100">Giây</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 grid max-w-2xl gap-3 sm:grid-cols-2" data-aos="fade-up" data-aos-delay="320">
                        <div class="rounded-lg border border-[#ead8b4] bg-white/82 p-4 shadow-sm backdrop-blur">
                            <div class="flex items-start gap-3">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-700 text-white">
                                    <i class="fa fa-calendar-days"></i>
                                </span>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Thời gian</p>
                                    <p class="mt-1 font-bold text-blue-950">{{ $event->time ?? 'Đang cập nhật' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-lg border border-[#ead8b4] bg-white/82 p-4 shadow-sm backdrop-blur">
                            <div class="flex items-start gap-3">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-700 text-white">
                                    <i class="fa fa-location-dot"></i>
                                </span>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Địa điểm</p>
                                    <p class="mt-1 font-bold text-blue-950">{{ $locationLabel ?: 'Đang cập nhật' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3" data-aos="fade-up" data-aos-delay="380">
                        <a href="#timeline" class="inline-flex h-12 items-center justify-center gap-2 rounded-full bg-blue-800 px-6 text-sm font-bold uppercase tracking-[0.13em] text-white shadow-lg shadow-blue-900/20 transition hover:bg-blue-700">
                            <i class="fa fa-list-check"></i>
                            Xem lịch trình
                        </a>
                        <button type="button" onclick="copyLink()" class="inline-flex h-12 items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-6 text-sm font-bold uppercase tracking-[0.13em] text-blue-900 shadow-sm transition hover:border-blue-300">
                            <i class="fa fa-link"></i>
                            Chia sẻ
                        </button>
                    </div>
                </div>

                <aside class="relative flex justify-center lg:justify-end" data-aos="fade-left" data-aos-duration="950" data-aos-delay="180">
                    <img src="{{ asset('images/decor/so-luu-but.png') }}" alt="" class="absolute -bottom-16 -right-10 hidden w-52 rotate-6 opacity-95 lg:block">
                    <img src="{{ asset('images/decor/7.png') }}" alt="" class="absolute -bottom-6 left-4 hidden w-36 rotate-[-18deg] opacity-95 sm:block">

                    <div class="memory-polaroid" data-aos="zoom-in" data-aos-delay="260">
                        <div class="memory-polaroid__photo">
                            <img src="{{ $polaroidImage }}" alt="{{ $event->school_name }}">
                        </div>

                        <img class="memory-polaroid__frame" src="{{ asset('images/decor/frame-polaroid-cutout.png') }}" alt="">
                    </div>

                    <div class="absolute bottom-0 left-1/2 z-10 w-[min(84vw,360px)] -translate-x-1/2 translate-y-6 rounded-lg border border-[#ead8b4] bg-white/90 p-4 shadow-xl backdrop-blur lg:left-auto lg:right-8 lg:translate-x-0" data-aos="fade-up" data-aos-delay="430">
                        <div class="flex items-center gap-3">
                            <img src="{{ $logoImage }}" alt="{{ $event->school_name }}" class="h-14 w-14 shrink-0 rounded-full object-contain ring-1 ring-[#ead8b4]">
                            <div>
                                <p class="font-accent text-3xl font-bold leading-none text-red-700">Trở về thanh xuân</p>
                                <p class="mt-1 text-xs font-bold uppercase tracking-[0.14em] text-blue-900">{{ $event->course_name }}</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section id="timeline" class="relative overflow-hidden px-5 py-16 sm:px-8 sm:py-20">
            <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-gradient-to-b from-white to-transparent"></div>
            <img src="{{ asset('images/decor/5.png') }}" alt="" class="decor-float -right-20 top-8 hidden w-72 rotate-[-4deg] opacity-80 lg:block">
            <img src="{{ asset('images/decor/6.png') }}" alt="" class="decor-float -left-16 top-28 hidden w-60 rotate-12 opacity-70 lg:block">
            <div class="mx-auto max-w-6xl">
                <div class="mx-auto mb-10 max-w-3xl text-center" data-aos="fade-up">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-red-700">Chương trình</p>
                    <h2 class="mt-3 font-serif text-3xl font-black text-blue-950 sm:text-5xl">Timeline ngày hội ngộ</h2>
                    <p class="mt-4 text-base leading-7 text-slate-600">Các mốc chính trong ngày để thầy cô và các bạn tiện theo dõi, check-in và cùng lưu lại trọn vẹn từng khoảnh khắc.</p>
                </div>

                @if($timelineItems->isNotEmpty())
                    <div class="notification-timeline relative space-y-4 rounded-lg border border-[#ead8b4] bg-[#fffdf7]/85 p-4 shadow-[0_28px_80px_rgba(101,71,25,.1)] backdrop-blur sm:p-6 md:p-8">
                        @foreach($timelineItems as $index => $item)
                            @php
                                $isHighlight = (bool) ($item->is_highlight ?? false);
                                $accentClasses = [
                                    ['bg' => 'bg-blue-700', 'soft' => 'bg-blue-50', 'text' => 'text-blue-800', 'border' => 'border-blue-200'],
                                    ['bg' => 'bg-red-700', 'soft' => 'bg-red-50', 'text' => 'text-red-800', 'border' => 'border-red-200'],
                                    ['bg' => 'bg-amber-500', 'soft' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-200'],
                                    ['bg' => 'bg-emerald-600', 'soft' => 'bg-emerald-50', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200'],
                                    ['bg' => 'bg-indigo-700', 'soft' => 'bg-indigo-50', 'text' => 'text-indigo-800', 'border' => 'border-indigo-200'],
                                    ['bg' => 'bg-fuchsia-700', 'soft' => 'bg-fuchsia-50', 'text' => 'text-fuchsia-800', 'border' => 'border-fuchsia-200'],
                                ][$index % 6];
                                $decorImages = [
                                    ['src' => 'images/decor/hoa-phuong-do.png', 'class' => '-right-10 -top-10 w-28 rotate-12 opacity-55'],
                                    ['src' => 'images/decor/hoa-bang-lang.png', 'class' => '-left-8 -bottom-12 w-28 rotate-[-14deg] opacity-50'],
                                    ['src' => 'images/decor/4.png', 'class' => '-right-14 bottom-1 w-24 rotate-[-8deg] opacity-45'],
                                    ['src' => 'images/decor/6.png', 'class' => '-left-10 -top-8 w-24 rotate-12 opacity-45'],
                                    ['src' => 'images/decor/7.png', 'class' => '-right-8 -bottom-10 w-20 rotate-[-22deg] opacity-45'],
                                    ['src' => 'images/decor/so-luu-but.png', 'class' => '-left-12 bottom-0 w-24 rotate-12 opacity-40'],
                                ];
                                $decor = $decorImages[$index % count($decorImages)];
                            @endphp
                            <article class="relative pl-14 md:pl-20" data-aos="fade-up" data-aos-delay="{{ min($index * 70, 420) }}">
                                <div class="absolute left-0 top-5 z-10 flex h-12 w-12 items-center justify-center rounded-full {{ $accentClasses['bg'] }} text-sm font-black text-white ring-8 ring-white md:left-0 md:h-[4.5rem] md:w-[4.5rem] md:text-lg">
                                    {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <div class="program-card relative overflow-hidden rounded-lg border {{ $isHighlight ? 'border-amber-200 bg-amber-50' : 'border-slate-100 bg-white' }} transition hover:-translate-y-0.5 hover:shadow-2xl">
                                    <img src="{{ asset($decor['src']) }}" alt="" class="pointer-events-none absolute hidden select-none sm:block {{ $decor['class'] }}">
                                    <div class="grid md:grid-cols-[190px_minmax(0,1fr)]">
                                        <div class="{{ $accentClasses['soft'] }} {{ $accentClasses['text'] }} flex items-center gap-3 border-b {{ $accentClasses['border'] }} p-5 md:flex-col md:items-start md:justify-center md:border-b-0 md:border-r">
                                            <i class="fa fa-clock text-lg"></i>
                                            <div>
                                                <p class="text-[11px] font-black uppercase tracking-[0.18em] opacity-70">Thời gian</p>
                                                <p class="mt-1 text-lg font-black leading-tight">{{ $item->time }}</p>
                                            </div>
                                        </div>

                                        <div class="p-5 sm:p-6">
                                            <div class="flex flex-wrap items-start justify-between gap-3">
                                                <h3 class="text-xl font-black leading-snug text-blue-950 sm:text-2xl">{{ $item->title }}</h3>
                                                @if($isHighlight)
                                                    <span class="inline-flex rounded-full bg-amber-400 px-3 py-1 text-[11px] font-black uppercase tracking-[0.12em] text-blue-950">Điểm nhấn</span>
                                                @endif
                                            </div>
                                            @if(!empty($item->description))
                                                <p class="mt-3 text-sm leading-7 text-slate-600 sm:text-base">{{ $item->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p class="rounded-lg border border-dashed border-blue-200 bg-white p-8 text-center text-slate-500">Timeline sẽ được cập nhật sau.</p>
                @endif
            </div>
        </section>

        @if($showVideo && $videoUrl)
            <section class="bg-white px-5 py-16 sm:px-8 sm:py-20">
                <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[360px_minmax(0,1fr)] lg:items-center">
                    <div data-aos="fade-right">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-red-700">Trailer</p>
                        <h2 class="mt-3 font-serif text-3xl font-black text-blue-950 sm:text-4xl">Video chương trình</h2>
                        <p class="mt-4 leading-7 text-slate-600">Một vài khoảnh khắc mở đầu cho ngày trở về thật nhiều cảm xúc.</p>
                    </div>
                    <a href="{{ $videoUrl }}" class="glightbox-video group relative block overflow-hidden rounded-lg bg-blue-950 shadow-2xl shadow-blue-900/18" data-aos="zoom-in" data-aos-delay="120">
                        <img src="{{ $videoCover }}" alt="Video trailer" class="aspect-video w-full object-cover opacity-90 transition duration-700 group-hover:scale-105 group-hover:opacity-75">
                        <span class="absolute inset-0 flex items-center justify-center">
                            <span class="flex h-20 w-20 items-center justify-center rounded-full bg-white text-2xl text-red-700 shadow-2xl">
                                <i class="fa fa-play ml-1"></i>
                            </span>
                        </span>
                    </a>
                </div>
            </section>
        @endif

        @if($showOrganizers)
            <section class="px-5 py-16 sm:px-8 sm:py-20">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between" data-aos="fade-up">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-red-700">Ban liên lạc</p>
                            <h2 class="mt-3 font-serif text-3xl font-black text-blue-950 sm:text-4xl">Đầu mối hỗ trợ</h2>
                        </div>
                        @if(!empty($eventInfo['map_url']))
                            <a href="{{ $eventInfo['map_url'] }}" target="_blank" class="inline-flex h-11 items-center justify-center gap-2 rounded-full border border-blue-200 bg-white px-5 text-sm font-bold text-blue-900 shadow-sm transition hover:border-blue-300">
                                <i class="fa fa-map-location-dot"></i>
                                Chỉ đường
                            </a>
                        @endif
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse($contacts as $contact)
                            <div class="rounded-lg border border-blue-100 bg-white p-5 shadow-sm" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 80, 320) }}">
                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">{{ $contact->role ?? 'Ban tổ chức' }}</p>
                                <p class="mt-2 text-lg font-black text-blue-950">{{ $contact->name ?: 'Ban tổ chức' }}</p>
                                @if(!empty($contact->phone))
                                    <a href="tel:{{ $contact->phone }}" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-red-700 hover:text-red-600">
                                        <i class="fa fa-phone text-xs"></i>
                                        {{ $contact->phone }}
                                    </a>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-lg border border-dashed border-blue-200 bg-white p-6 text-slate-500">
                                Thông tin ban liên lạc sẽ được cập nhật sau.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        @endif

        <footer class="bg-blue-950 px-5 py-10 text-white sm:px-8" data-aos="fade-up">
            <div class="mx-auto flex max-w-6xl flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-amber-200">{{ $event->course_name }}</p>
                    <p class="mt-2 font-serif text-2xl font-bold">{{ $event->school_name }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="https://zalo.me/share?u={{ urlencode($pageUrl) }}" target="_blank" class="inline-flex h-10 items-center justify-center rounded-full bg-blue-500 px-4 text-sm font-bold text-white transition hover:bg-blue-400">Zalo</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($pageUrl) }}" target="_blank" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-700 text-white transition hover:bg-blue-600">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <button type="button" onclick="copyLink()" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/15">
                        <i class="fa fa-link"></i>
                    </button>
                </div>
            </div>
        </footer>
    </main>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-countdown-target]').forEach((countdown) => {
            const target = new Date(countdown.dataset.countdownTarget).getTime();
            const daysEl = countdown.querySelector('[data-countdown-days]');
            const hoursEl = countdown.querySelector('[data-countdown-hours]');
            const minutesEl = countdown.querySelector('[data-countdown-minutes]');
            const secondsEl = countdown.querySelector('[data-countdown-seconds]');

            if (!target || !daysEl || !hoursEl || !minutesEl || !secondsEl) {
                return;
            }

            const pad = (value) => String(value).padStart(2, '0');
            const render = () => {
                const remaining = Math.max(0, target - Date.now());
                const totalSeconds = Math.floor(remaining / 1000);
                const days = Math.floor(totalSeconds / 86400);
                const hours = Math.floor((totalSeconds % 86400) / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                daysEl.textContent = pad(days);
                hoursEl.textContent = pad(hours);
                minutesEl.textContent = pad(minutes);
                secondsEl.textContent = pad(seconds);
            };

            render();
            setInterval(render, 1000);
        });
    </script>
@endpush
