{{-- Template Name: Trang thư cảm ơn tập thể theo lớp --}}
{{-- Template Type: reunion_thank_you_class --}}
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
            background: #f6f1e8;
            color: #20201d;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-accent {
            font-family: 'Dancing Script', cursive;
        }

        .thank-paper p {
            margin: 0 0 1rem;
            line-height: 1.9;
        }

        .thank-paper p:last-child {
            margin-bottom: 0;
        }
    </style>
@endpush

@section('body_class', 'bg-stone-50 text-stone-950 antialiased overflow-x-hidden')

@section('content')
    @php
        $defaultHeroImage = $event->hero_image ?? $event->background ?? $event->share_image;
        $mainUrl = $event->main_url ?? url('/' . $reunion->slug);
        $thankUrl = $event->url ?? url('/' . $event->slug);
        $contacts = collect($organizers ?? [])->filter(fn ($item) => !empty($item['name']) || !empty($item['phone']));
        $classGroup = $event->thank_you_class ?? null;
        $classes = collect($event->thank_you_classes ?? []);
        $className = $classGroup['name'] ?? 'Tập thể các lớp';
        $heroImage = $classGroup['image'] ?? $defaultHeroImage;
    @endphp

    <main class="min-h-screen bg-[#f6f1e8]">
        <section class="relative isolate overflow-hidden bg-[#1f332d] text-white">
            @if($heroImage)
                <img src="{{ $heroImage }}" alt="{{ $event->school_name }}" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-35">
            @endif
            <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#17251f]/95 via-[#26433a]/78 to-[#8b5d2c]/72"></div>
            <div class="absolute inset-x-0 bottom-0 -z-10 h-32 bg-gradient-to-t from-[#f6f1e8] to-transparent"></div>

            <div class="mx-auto grid min-h-[86vh] max-w-6xl gap-10 px-5 py-10 sm:px-8 lg:grid-cols-[minmax(0,1fr)_390px] lg:items-center lg:py-16">
                <div class="pt-14 lg:pt-0">
                    <a href="{{ $mainUrl }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-amber-100 backdrop-blur transition hover:bg-white/15">
                        <i class="fa fa-arrow-left text-[11px]"></i>
                        Trang chương trình
                    </a>

                    <p class="mt-10 text-xs font-bold uppercase tracking-[0.28em] text-amber-200">
                        {{ $event->course_name }} - {{ $event->school_name }}
                    </p>
                    <h1 class="mt-5 font-serif text-5xl font-bold leading-[1.05] sm:text-7xl">
                        Thư cảm ơn
                    </h1>
                    <p class="mt-6 max-w-2xl text-lg leading-8 text-stone-100 sm:text-xl">
                        Ban tổ chức trân trọng cảm ơn {{ $className }} đã đoàn kết, nhiệt tình hưởng ứng và chung tay để ngày hội ngộ thêm trọn vẹn.
                    </p>

                    <div class="mt-9 flex flex-wrap gap-3">
                        <a href="#thu-cam-on" class="inline-flex h-12 items-center justify-center gap-2 rounded-full bg-amber-300 px-6 text-sm font-bold uppercase tracking-[0.14em] text-[#1f332d] shadow-lg shadow-black/20 transition hover:bg-amber-200">
                            <i class="fa fa-envelope-open-text"></i>
                            Đọc thư
                        </a>
                        <button type="button" onclick="copyLink()" class="inline-flex h-12 items-center justify-center gap-2 rounded-full border border-white/20 bg-white/10 px-6 text-sm font-bold uppercase tracking-[0.14em] text-white backdrop-blur transition hover:bg-white/15">
                            <i class="fa fa-link"></i>
                            Chia sẻ
                        </button>
                    </div>
                </div>

                <aside class="rounded-lg border border-white/15 bg-white/12 p-5 shadow-2xl backdrop-blur-md sm:p-6">
                    <div class="overflow-hidden rounded-md bg-[#fffaf0] text-stone-900 shadow-xl">
                        @if(!empty($classGroup['image']))
                            <div class="aspect-[4/3] overflow-hidden bg-stone-200">
                                <img src="{{ $classGroup['image'] }}" alt="Ảnh {{ $className }}" class="h-full w-full object-cover">
                            </div>
                        @endif
                        <div class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#1f332d] text-amber-200">
                                    <i class="fa fa-heart text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-stone-500">Tri ân tập thể</p>
                                    <h2 class="mt-1 font-serif text-2xl font-bold">{{ $className }}</h2>
                                    @if(!empty($classGroup['representative']))
                                        <p class="mt-1 text-sm text-stone-600">{{ $classGroup['representative'] }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-6 space-y-4 border-t border-stone-200 pt-5">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-stone-500">Thời gian</p>
                                    <p class="mt-1 font-semibold">{{ $event->time ?? 'Đang cập nhật' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-stone-500">Địa điểm</p>
                                    <p class="mt-1 text-sm font-semibold text-stone-600">{{ $event->address ?? ($eventInfo['location_address'] ?? '') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section id="thu-cam-on" class="px-5 py-16 sm:px-8 sm:py-20">
            <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[300px_minmax(0,1fr)]">
                <aside class="lg:pt-10">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#8b5d2c]">Lời tri ân</p>
                    <h2 class="mt-3 font-serif text-3xl font-bold leading-tight sm:text-4xl">
                        Sự chung tay của từng lớp làm nên một ngày trở về trọn vẹn.
                    </h2>
                    @if(!empty($event->greeting))
                        <p class="mt-6 rounded-md border border-[#d6c2a3] bg-white/60 px-4 py-3 text-sm font-semibold text-[#31584b]">
                            {{ $classGroup ? 'Thân gửi ' . $className : $event->greeting }}
                        </p>
                    @endif
                </aside>

                <article class="thank-paper rounded-lg border border-[#dfd0b8] bg-[#fffaf0] p-6 shadow-[0_24px_80px_rgba(75,54,33,.12)] sm:p-10">
                    <div class="mb-8 flex items-center justify-between gap-4 border-b border-[#dfd0b8] pb-6">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-[#8b5d2c]">{{ $event->course_name }}</p>
                            <h3 class="mt-2 font-serif text-3xl font-bold">{{ $className }}</h3>
                            @if(!empty($classGroup['representative']))
                                <p class="mt-1 text-sm font-semibold text-[#31584b]">{{ $classGroup['representative'] }}</p>
                            @endif
                        </div>
                        <img src="{{ $event->logo }}" alt="{{ $event->school_name }}" class="h-14 w-14 rounded-full object-cover ring-1 ring-[#dfd0b8]">
                    </div>

                    <div class="text-[17px] leading-8 text-stone-800">
                        {!! $openLetter !!}
                    </div>

                    @if(!empty($classGroup['note']))
                        <div class="mt-8 rounded-md border border-[#d6c2a3] bg-[#f8efdf] p-5">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#8b5d2c]">Lời ghi nhận riêng</p>
                            <p class="mt-2 leading-7 text-stone-700">{{ $classGroup['note'] }}</p>
                        </div>
                    @endif

                    <div class="mt-10 grid gap-4 border-t border-[#dfd0b8] pt-6 sm:grid-cols-3">
                        <div class="rounded-md bg-[#f4ead9] p-4">
                            <i class="fa fa-hand-holding-heart text-[#8b5d2c]"></i>
                            <p class="mt-3 text-sm font-bold">Đồng hành</p>
                            <p class="mt-1 text-sm leading-6 text-stone-600">Cùng góp sức để chương trình được chuẩn bị chu đáo hơn.</p>
                        </div>
                        <div class="rounded-md bg-[#eef3ef] p-4">
                            <i class="fa fa-seedling text-[#31584b]"></i>
                            <p class="mt-3 text-sm font-bold">Lan tỏa</p>
                            <p class="mt-1 text-sm leading-6 text-stone-600">Gửi thêm niềm vui, sự gắn kết và tinh thần sẻ chia.</p>
                        </div>
                        <div class="rounded-md bg-[#f7efe7] p-4">
                            <i class="fa fa-award text-[#a84a36]"></i>
                            <p class="mt-3 text-sm font-bold">Ghi nhận</p>
                            <p class="mt-1 text-sm leading-6 text-stone-600">Ban tổ chức trân trọng ghi nhận tinh thần của từng tập thể lớp.</p>
                        </div>
                    </div>

                    <div class="mt-10 text-right">
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-stone-500">Thay mặt ban tổ chức</p>
                        <p class="font-accent text-4xl font-bold text-[#8b5d2c]">Trân trọng cảm ơn</p>
                    </div>
                </article>
            </div>
        </section>

        @if($classes->isNotEmpty())
            <section class="px-5 pb-16 sm:px-8 sm:pb-20">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-7">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-[#8b5d2c]">Các tập thể được tri ân</p>
                        <h2 class="mt-2 font-serif text-3xl font-bold">Trân trọng cảm ơn</h2>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($classes as $item)
                            @php
                                $itemUrl = url('/' . $reunion->slug . '/thu-cam-on-lop/' . $item['code']);
                                $isActive = !empty($classGroup['code']) && $classGroup['code'] === $item['code'];
                            @endphp
                            <a href="{{ $itemUrl }}" class="group block overflow-hidden rounded-lg border {{ $isActive ? 'border-[#31584b] bg-[#eef3ef]' : 'border-[#dfd0b8] bg-[#fffaf0]' }} shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                <div class="relative aspect-[16/9] overflow-hidden bg-stone-200">
                                    <img src="{{ $item['image'] ?? $defaultHeroImage }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-transparent to-transparent"></div>
                                    <p class="absolute bottom-3 left-4 right-4 font-serif text-xl font-bold text-white">{{ $item['name'] }}</p>
                                </div>
                                <div class="p-5">
                                @if(!empty($item['representative']))
                                    <p class="mt-1 text-sm font-semibold text-[#8b5d2c]">{{ $item['representative'] }}</p>
                                @endif
                                @if(!empty($item['note']))
                                    <p class="mt-3 line-clamp-2 text-sm leading-6 text-stone-600">{{ $item['note'] }}</p>
                                @endif
                                    <p class="mt-4 text-xs font-bold uppercase tracking-[0.16em] text-[#31584b]">Xem thư của lớp</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="bg-[#20342d] px-5 py-14 text-white sm:px-8">
            <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(280px,420px)] lg:items-start">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-amber-200">Thông tin chương trình</p>
                    <h2 class="mt-3 font-serif text-3xl font-bold sm:text-4xl">{{ $event->school_name }}</h2>
                    <p class="mt-2 text-lg font-semibold text-amber-100">{{ $event->course_name }}</p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-lg border border-white/10 bg-white/[0.06] p-5">
                            <i class="fa fa-calendar-days text-amber-200"></i>
                            <p class="mt-3 text-xs font-bold uppercase tracking-[0.18em] text-stone-300">Thời gian</p>
                            <p class="mt-1 font-semibold">{{ $event->time ?? 'Đang cập nhật' }}</p>
                        </div>
                        <div class="rounded-lg border border-white/10 bg-white/[0.06] p-5">
                            <i class="fa fa-location-dot text-amber-200"></i>
                            <p class="mt-3 text-xs font-bold uppercase tracking-[0.18em] text-stone-300">Địa điểm</p>
                            <p class="mt-1 font-semibold">{{ $eventInfo['location_name'] ?? 'Đang cập nhật' }}</p>
                            <p class="mt-1 text-sm leading-6 text-stone-300">{{ $eventInfo['location_address'] ?? '' }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-white/10 bg-white/[0.06] p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-amber-200">Đầu mối liên hệ</p>
                    <div class="mt-5 space-y-3">
                        @forelse($contacts as $org)
                            <div class="rounded-md bg-white/[0.07] p-4">
                                <p class="text-xs uppercase tracking-[0.16em] text-stone-400">{{ $org['role'] ?? 'Ban tổ chức' }}</p>
                                <p class="mt-1 font-semibold">{{ $org['name'] ?: 'Ban tổ chức' }}</p>
                                @if(!empty($org['phone']))
                                    <a href="tel:{{ $org['phone'] }}" class="mt-2 inline-flex items-center gap-2 text-sm font-semibold text-amber-200 hover:text-amber-100">
                                        <i class="fa fa-phone text-xs"></i>
                                        {{ $org['phone'] }}
                                    </a>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm leading-6 text-stone-300">Thông tin liên hệ sẽ được ban tổ chức cập nhật.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-[#17251f] px-5 py-8 text-white sm:px-8">
            <div class="mx-auto flex max-w-6xl flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-stone-400">
                    {{ $event->school_name }} - {{ $event->course_name }}
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="https://zalo.me/share?u={{ urlencode($thankUrl) }}" target="_blank" class="inline-flex h-10 items-center justify-center rounded-full bg-blue-500 px-4 text-sm font-bold text-white transition hover:bg-blue-400">
                        Zalo
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($thankUrl) }}" target="_blank" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-700 text-white transition hover:bg-blue-600">
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
