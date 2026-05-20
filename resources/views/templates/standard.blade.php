{{-- Template Name: Họp lớp chuẩn --}}
{{-- Template Type: reunion --}}
@extends('layouts.reunion')

@section('title', 'Thư Mời Họp Lớp | ' . $schoolInfo['name'])

@section('meta')
    <meta name="description" content="Thư mời họp lớp {{ $schoolInfo['course'] }} - {{ $schoolInfo['name'] }}. {{ $eventInfo['time'] }} {{ $eventInfo['day'] }} {{ $eventInfo['date'] }}.">
    <meta property="og:title" content="Thư Mời Họp Lớp - {{ $schoolInfo['name'] }}">
    <meta property="og:description" content="{{ $schoolInfo['anniversary'] }} ngày ra trường - {{ $schoolInfo['course'] }}">
    <meta property="og:image" content="{{ $reunion->getCoverUrl() }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/' . $reunion->slug) }}">
    <meta property="og:locale" content="vi_VN">
@endsection

@push('styles')
    <style>
        body { font-family: 'Be Vietnam Pro', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-accent { font-family: 'Dancing Script', cursive; }
    </style>
@endpush

@section('body_class', 'bg-slate-50 text-slate-900 antialiased overflow-x-hidden')

@section('content')
    <section class="relative min-h-screen overflow-hidden bg-slate-950 text-white">
        <img src="{{ $reunion->getHeroUrl() }}" alt="{{ $schoolInfo['name'] }}"
            class="absolute inset-0 h-full w-full object-cover opacity-35">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-950/55 to-slate-950"></div>

        <div class="relative mx-auto flex min-h-screen max-w-5xl flex-col items-center justify-center px-5 py-20 text-center">
            <p class="mb-4 text-xs font-semibold uppercase tracking-[0.28em] text-amber-300">
                {{ $schoolInfo['course'] }}
            </p>
            <h1 class="font-serif text-4xl font-bold leading-tight sm:text-6xl">
                Thư Mời Họp Lớp
            </h1>
            <p class="mt-5 max-w-2xl text-lg text-slate-200 sm:text-xl">
                {{ $schoolInfo['anniversary'] }} ngày ra trường - {{ $schoolInfo['slogan'] }}
            </p>

            <div class="mt-10 grid w-full max-w-3xl gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                    <p class="text-xs uppercase tracking-widest text-slate-300">Thời gian</p>
                    <p class="mt-2 font-semibold">{{ $eventInfo['time_short'] }} {{ $eventInfo['day'] }}</p>
                    <p class="text-amber-200">{{ $eventInfo['date'] }}</p>
                </div>
                <div class="rounded-xl border border-white/10 bg-white/10 p-5 backdrop-blur sm:col-span-2">
                    <p class="text-xs uppercase tracking-widest text-slate-300">Địa điểm</p>
                    <p class="mt-2 font-semibold">{{ $eventInfo['location_name'] }}</p>
                    <p class="text-sm text-slate-300">{{ $eventInfo['location_address'] }}</p>
                </div>
            </div>

            <a href="#rsvp"
                class="mt-10 inline-flex items-center justify-center rounded-full bg-amber-400 px-7 py-3 text-sm font-bold uppercase tracking-widest text-slate-950 transition hover:bg-amber-300">
                Xác nhận tham dự
            </a>
        </div>
    </section>

    <section class="px-5 py-16 sm:py-20">
        <div class="mx-auto max-w-4xl">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-amber-600">Trân trọng kính mời</p>
                <h2 class="mt-3 font-serif text-3xl font-bold sm:text-4xl">{{ $greeting }}</h2>
            </div>

            <div class="prose prose-slate mx-auto mt-8 max-w-none rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                {!! $openLetter !!}
            </div>
        </div>
    </section>

    <section class="bg-white px-5 py-16 sm:py-20">
        <div class="mx-auto max-w-4xl">
            <div class="mb-10 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-amber-600">Chương trình</p>
                <h2 class="mt-3 font-serif text-3xl font-bold sm:text-4xl">Lịch trình hội khóa</h2>
            </div>

            @if(!empty($timeline))
                <div class="space-y-4">
                    @foreach($timeline as $item)
                        <div class="grid gap-4 rounded-2xl border {{ !empty($item['is_highlight']) ? 'border-amber-200 bg-amber-50' : 'border-slate-200 bg-white' }} p-5 shadow-sm sm:grid-cols-[140px_1fr]">
                            <div class="font-mono text-sm font-bold text-amber-700">{{ $item['time'] }}</div>
                            <div>
                                <h3 class="font-bold text-slate-950">{{ $item['title'] }}</h3>
                                @if(!empty($item['description']))
                                    <p class="mt-1 text-sm leading-6 text-slate-600">{{ $item['description'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-slate-500">
                    Lịch trình sẽ được cập nhật sau.
                </p>
            @endif
        </div>
    </section>

    @if(!empty($classDirs))
        <section class="px-5 py-16 sm:py-20">
            <div class="mx-auto max-w-6xl">
                <div class="mb-10 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-amber-600">Album</p>
                    <h2 class="mt-3 font-serif text-3xl font-bold sm:text-4xl">Ảnh kỷ niệm</h2>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
                    @foreach($classDirs as $className => $photos)
                        @foreach(array_slice($photos, 0, 10) as $photo)
                            <a href="{{ $photo }}" class="glightbox-gallery group relative aspect-square overflow-hidden rounded-xl bg-slate-200"
                                data-gallery="standard-gallery-{{ \Illuminate\Support\Str::slug($className) }}" data-glightbox="title: {{ $className }}">
                                <img src="{{ $photo }}" alt="Ảnh {{ $className }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                            </a>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-reunions.rsvp :classDirs="$classDirs" :reunion="$reunion" />

    <section id="map" class="bg-white px-5 py-16 sm:py-20">
        <div class="mx-auto max-w-4xl">
            <div class="mb-8 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-amber-600">Bản đồ</p>
                <h2 class="mt-3 font-serif text-3xl font-bold sm:text-4xl">Địa điểm họp mặt</h2>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                <iframe src="{{ $eventInfo['map_iframe'] }}" width="100%" height="320" style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ $eventInfo['map_url'] }}" target="_blank"
                    class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-amber-400 hover:text-amber-700">
                    Xem chỉ đường
                </a>
            </div>
        </div>
    </section>

    <x-reunions.guestbook :messages="$messages" :reunion="$reunion" />

    <footer class="relative overflow-hidden bg-slate-950 px-5 py-12 text-white sm:py-16">
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-amber-300/70 to-transparent"></div>

        <div class="mx-auto grid max-w-5xl gap-8 lg:grid-cols-[minmax(0,1.2fr)_minmax(280px,.8fr)] lg:items-end">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-amber-300">Hẹn ngày hội ngộ</p>
                <h3 class="mt-3 font-serif text-2xl font-bold leading-tight sm:text-3xl">{{ $schoolInfo['name'] }}</h3>
                <p class="mt-2 text-lg font-semibold text-amber-200">{{ $schoolInfo['course'] }}</p>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    @foreach($organizers as $org)
                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                            <p class="text-xs uppercase tracking-[0.16em] text-slate-500">{{ $org['role'] }}</p>
                            <p class="mt-1 font-semibold text-white">{{ $org['name'] ?: 'Ban tổ chức' }}</p>
                            @if(!empty($org['phone']))
                                <a href="tel:{{ $org['phone'] }}"
                                    class="mt-2 inline-flex items-center gap-2 text-sm font-semibold text-emerald-300 transition hover:text-emerald-200">
                                    <i class="fas fa-phone text-xs"></i>
                                    <span>{{ $org['phone'] }}</span>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:text-right">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Chia sẻ thiệp mời</p>
                <div class="mt-4 flex flex-wrap gap-3 lg:justify-end">
                    <a href="https://zalo.me/share?u={{ urlencode(url('/' . $reunion->slug)) }}" target="_blank"
                        class="inline-flex h-11 items-center justify-center rounded-full bg-blue-500 px-5 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-400">
                        Zalo
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/' . $reunion->slug)) }}"
                        target="_blank"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-blue-700 text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-600">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <button onclick="copyLink()"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-white/15">
                        <i class="fas fa-link"></i>
                    </button>
                </div>

                <p class="mt-8 border-t border-white/10 pt-5 text-xs leading-6 text-slate-500">
                    Thiết kế bởi <a href="/" class="font-semibold text-amber-300 transition hover:text-amber-200">THT Media</a>
                    - Nền tảng Thiệp Mời Online
                </p>
            </div>
        </div>
    </footer>
@endsection
