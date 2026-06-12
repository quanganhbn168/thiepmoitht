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
            background: #f7fbff;
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
            left: 1.15rem;
            top: 1rem;
            bottom: 1rem;
            width: 3px;
            border-radius: 999px;
            background: linear-gradient(180deg, #dc2626, #f59e0b, #16a34a, #2563eb, #7c3aed);
        }

        @media (min-width: 768px) {
            .notification-timeline:before {
                left: 50%;
                transform: translateX(-50%);
            }
        }
    </style>
@endpush

@section('body_class', 'bg-sky-50 text-slate-950 antialiased overflow-x-hidden')

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
        $videoUrl = $event->video_url ?? null;
        $videoCover = $event->video_cover ?? $event->cover ?? $heroImage;
        $showVideo = (bool) ($notification->show_video ?? true);
        $showOrganizers = (bool) ($notification->show_organizers ?? true);
        $contacts = collect($event->contacts ?? [])->filter(fn ($item) => !empty($item->name) || !empty($item->phone));
        $programName = $schoolInfo['anniversary'] ?? 'Ngày hội ngộ';
        $programSlogan = $schoolInfo['slogan'] ?? 'Trở về thanh xuân';
        $countdownTarget = $event->countdown_time ?? $event->time_countdown ?? null;
    @endphp

    <main class="min-h-screen bg-[#f7fbff]">
        <section class="relative isolate overflow-hidden bg-[#e7f6ff]">
            @if($heroImage)
                <img src="{{ $heroImage }}" alt="{{ $event->school_name }}" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-25">
            @endif
            <div class="absolute inset-0 -z-10 bg-[linear-gradient(135deg,rgba(255,255,255,.96),rgba(231,246,255,.9)_42%,rgba(255,241,226,.9))]"></div>
            <div class="absolute inset-x-0 bottom-0 -z-10 h-32 bg-gradient-to-t from-[#f7fbff] to-transparent"></div>

            <div class="mx-auto grid min-h-[92vh] max-w-7xl gap-9 px-5 py-8 sm:px-8 lg:grid-cols-[minmax(0,1fr)_460px] lg:items-center lg:py-12">
                <div class="pt-12 lg:pt-0">
                    <a href="{{ $mainUrl }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-full border border-blue-200 bg-white/80 px-4 text-xs font-bold uppercase tracking-[0.16em] text-blue-800 shadow-sm backdrop-blur transition hover:border-blue-300 hover:bg-white">
                        <i class="fa fa-arrow-left text-[11px]"></i>
                        Trang chương trình
                    </a>

                    <div class="mt-9 flex items-center gap-5">
                        <img src="{{ $logoImage }}" alt="{{ $event->school_name }}" class="h-24 w-24 rounded-full object-contain ring-8 ring-white/80 sm:h-32 sm:w-32">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-red-700">{{ $event->school_name }}</p>
                            <p class="mt-2 text-lg font-bold text-blue-900">{{ $event->course_name }}</p>
                        </div>
                    </div>

                    <h1 class="mt-8 font-serif text-4xl font-black leading-[1.05] text-blue-950 sm:text-6xl lg:text-7xl">
                        Ban liên lạc xin trân trọng thông báo
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-700 sm:text-lg">
                        Chương trình {{ $programName }} - {{ $programSlogan }} của {{ $event->course_name }} sẽ được tổ chức tại {{ $eventInfo['location_name'] ?? 'địa điểm chương trình' }}.
                    </p>

                    @if($countdownTarget)
                        <div class="mt-8 max-w-2xl rounded-lg border border-blue-100 bg-white/85 p-4 shadow-sm backdrop-blur" data-countdown-target="{{ $countdownTarget }}">
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

                    <div class="mt-8 grid max-w-2xl gap-3 sm:grid-cols-2">
                        <div class="rounded-lg border border-blue-100 bg-white/85 p-4 shadow-sm backdrop-blur">
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
                        <div class="rounded-lg border border-red-100 bg-white/85 p-4 shadow-sm backdrop-blur">
                            <div class="flex items-start gap-3">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-700 text-white">
                                    <i class="fa fa-location-dot"></i>
                                </span>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Địa điểm</p>
                                    <p class="mt-1 font-bold text-blue-950">{{ $eventInfo['location_name'] ?? 'Đang cập nhật' }}</p>
                                    <p class="mt-1 text-sm leading-5 text-slate-600">{{ $event->address ?? ($eventInfo['location_address'] ?? '') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3">
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

                <aside class="relative">
                    <div class="overflow-hidden rounded-lg border border-white bg-white shadow-2xl shadow-blue-900/12">
                        @if($heroImage)
                            <img src="{{ $heroImage }}" alt="{{ $event->school_name }}" class="h-80 w-full object-cover sm:h-[440px]">
                        @else
                            <div class="flex h-80 items-center justify-center bg-blue-100 sm:h-[440px]">
                                <img src="{{ $logoImage }}" alt="{{ $event->school_name }}" class="h-44 w-44 object-contain">
                            </div>
                        @endif
                        <div class="bg-white p-5">
                            <p class="font-accent text-4xl font-bold text-red-700">Trở về thanh xuân</p>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Cảm ơn thầy cô và các bạn đã là một phần thanh xuân không thể nào quên.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section id="timeline" class="px-5 py-16 sm:px-8 sm:py-20">
            <div class="mx-auto max-w-6xl">
                <div class="mx-auto mb-12 max-w-3xl text-center">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-red-700">Chương trình</p>
                    <h2 class="mt-3 font-serif text-3xl font-black text-blue-950 sm:text-5xl">Timeline ngày hội ngộ</h2>
                    <p class="mt-4 text-base leading-7 text-slate-600">Lịch trình có thể được ban tổ chức cập nhật để phù hợp với thực tế chương trình.</p>
                </div>

                @if($timelineItems->isNotEmpty())
                    <div class="notification-timeline relative space-y-5 md:space-y-0">
                        @foreach($timelineItems as $index => $item)
                            @php
                                $isHighlight = (bool) ($item->is_highlight ?? false);
                                $isEven = $index % 2 === 0;
                                $colors = ['bg-blue-700', 'bg-red-700', 'bg-amber-500', 'bg-emerald-600', 'bg-indigo-700', 'bg-fuchsia-700'];
                                $dotColor = $colors[$index % count($colors)];
                            @endphp
                            <article class="relative grid gap-4 pb-7 md:grid-cols-[1fr_72px_1fr] md:items-start md:pb-9">
                                <div class="{{ $isEven ? 'md:col-start-1 md:text-right' : 'md:col-start-3' }} ml-12 md:ml-0">
                                    <div class="rounded-lg border {{ $isHighlight ? 'border-amber-200 bg-amber-50 shadow-lg shadow-amber-100/60' : 'border-blue-100 bg-white shadow-sm' }} p-5 transition hover:-translate-y-0.5 hover:shadow-xl">
                                        <div class="flex items-start justify-between gap-4 {{ $isEven ? 'md:flex-row-reverse' : '' }}">
                                            <span class="inline-flex rounded-full bg-blue-950 px-3 py-1 text-xs font-bold uppercase tracking-[0.12em] text-white">{{ $item->time }}</span>
                                            <span class="text-2xl font-black {{ $isHighlight ? 'text-amber-500' : 'text-slate-200' }}">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                        <h3 class="mt-4 text-xl font-black text-blue-950">{{ $item->title }}</h3>
                                        @if(!empty($item->description))
                                            <p class="mt-2 text-sm leading-7 text-slate-600">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="absolute left-0 top-1 flex h-10 w-10 items-center justify-center rounded-full {{ $dotColor }} text-sm font-black text-white ring-8 ring-[#f7fbff] md:static md:col-start-2 md:mx-auto">
                                    {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
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
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-red-700">Trailer</p>
                        <h2 class="mt-3 font-serif text-3xl font-black text-blue-950 sm:text-4xl">Video chương trình</h2>
                        <p class="mt-4 leading-7 text-slate-600">Một vài khoảnh khắc mở đầu cho ngày trở về thật nhiều cảm xúc.</p>
                    </div>
                    <a href="{{ $videoUrl }}" class="glightbox-video group relative block overflow-hidden rounded-lg bg-blue-950 shadow-2xl shadow-blue-900/18">
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
                    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
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
                            <div class="rounded-lg border border-blue-100 bg-white p-5 shadow-sm">
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

        <footer class="bg-blue-950 px-5 py-10 text-white sm:px-8">
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
