{{-- Template Name: Thư cảm ơn riêng cho tập thể lớp --}}
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
            background: #efe5d3;
            color: #382719;
        }

        .thank-class-page {
            background:
                radial-gradient(circle at 15% 10%, rgba(181, 52, 39, .09), transparent 28rem),
                radial-gradient(circle at 90% 85%, rgba(120, 91, 57, .12), transparent 30rem),
                linear-gradient(135deg, #f4ecdf 0%, #e9dbc5 100%);
        }

        .thank-class-paper {
            background-color: #fffdf8;
            background-image:
                linear-gradient(rgba(122, 83, 43, .035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(122, 83, 43, .025) 1px, transparent 1px);
            background-size: 28px 28px;
            box-shadow: 0 30px 90px rgba(74, 47, 25, .2);
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-handwriting {
            font-family: 'Great Vibes', 'Dancing Script', cursive;
            font-weight: 400;
        }
        .font-class-name {
            font-family: 'Dancing Script', cursive;
            font-weight: 700;
        }
    </style>
@endpush

@section('body_class', 'bg-[#efe5d3] text-stone-900 antialiased overflow-x-hidden')

@section('content')
    @php
        $classGroup = $event->thank_you_class ?? null;
        $className = $classGroup['name'] ?? 'Tập thể lớp';
        $classImage = $classGroup['image'] ?? ($event->hero_image ?? $event->share_image);
        $recognition = trim((string) ($classGroup['note'] ?? ''));
        $mainUrl = $event->main_url ?? url('/' . $reunion->slug);
        $thankUrl = $event->url ?? url('/' . $event->slug);
    @endphp

    <main class="thank-class-page relative min-h-screen overflow-hidden px-4 py-8 sm:px-6 sm:py-12 lg:py-16">
        <img src="{{ asset('images/decor/hoa-phuong-do.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -right-16 -top-16 z-0 w-64 rotate-[-8deg] opacity-80 sm:w-80 lg:w-[27rem]">
        <img src="{{ asset('images/decor/so-luu-but.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -bottom-12 -left-14 z-0 w-56 rotate-[-8deg] opacity-45 sm:w-72">

        <div class="relative z-10 mx-auto max-w-4xl">
            <div class="mb-5 flex items-center justify-between gap-3 print:hidden">
                <a href="{{ $mainUrl }}" class="inline-flex items-center gap-2 rounded-full border border-[#8e6b48]/25 bg-white/70 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-[#6f4b2d] shadow-sm backdrop-blur transition hover:bg-white">
                    <i class="fa fa-arrow-left text-[10px]"></i>
                    Trang họp khóa
                </a>
                <button type="button" onclick="copyLink()" class="inline-flex items-center gap-2 rounded-full border border-[#8e6b48]/25 bg-white/70 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-[#6f4b2d] shadow-sm backdrop-blur transition hover:bg-white">
                    <i class="fa fa-link text-[10px]"></i>
                    Chia sẻ
                </button>
            </div>

            <article class="thank-class-paper relative overflow-hidden rounded-[2rem] border border-[#cdb99a] px-5 py-9 sm:px-10 sm:py-12 lg:px-16 lg:py-14">
                <div class="pointer-events-none absolute inset-3 rounded-[1.45rem] border border-[#b99a70]/35"></div>
                <img src="{{ asset('images/phuong-1.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -left-7 top-24 w-28 opacity-30 sm:w-36">
                <img src="{{ asset('images/phuong-2.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -right-6 bottom-32 w-24 rotate-12 opacity-25 sm:w-32">

                <div class="relative z-10">
                    <header class="text-center">
                        <a href="{{ $mainUrl }}" class="inline-block">
                            <img src="{{ $event->logo }}" alt="Logo {{ $event->course_name }}" class="mx-auto h-20 w-20 rounded-full object-cover shadow-md ring-4 ring-white sm:h-24 sm:w-24">
                        </a>
                        <p class="mt-4 text-[11px] font-bold uppercase tracking-[0.28em] text-[#99734c] sm:text-xs">
                            {{ $event->course_name }} · {{ $event->school_name }}
                        </p>
                        <div class="mx-auto mt-5 h-px w-24 bg-gradient-to-r from-transparent via-[#b53427] to-transparent"></div>
                        <h1 class="mt-6 font-serif text-4xl font-bold uppercase tracking-[0.08em] text-[#8f2d25] sm:text-5xl lg:text-6xl">
                            Thư cảm ơn
                        </h1>
                        <p class="font-class-name mt-3 text-4xl leading-tight text-[#624126] sm:text-5xl">
                            {{ $className }}
                        </p>
                    </header>

                    <figure class="relative mx-auto mt-9 max-w-3xl">
                        <div class="absolute -inset-2 rotate-[-1deg] rounded-lg bg-[#dfc7a3]/65"></div>
                        <div class="relative rotate-[.35deg] overflow-hidden rounded-lg border-[7px] border-white bg-stone-100 shadow-xl sm:border-[10px]">
                            <img src="{{ $classImage }}" alt="Ảnh tập thể {{ $className }}" class="aspect-[16/10] w-full object-cover">
                        </div>
                        <img src="{{ asset('images/decor/frame-polaroid-cutout.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -bottom-7 -right-5 w-24 rotate-6 opacity-80 sm:w-32">
                    </figure>

                    <section class="mx-auto mt-12 max-w-2xl text-center">
                        <p class="font-serif text-lg italic text-[#765538] sm:text-xl">Kính gửi</p>
                        <h2 class="mt-2 font-serif text-2xl font-bold text-[#8f2d25] sm:text-3xl">
                            {{ $className }}
                        </h2>

                        <div class="mx-auto my-7 flex items-center justify-center gap-3 text-[#b53427]">
                            <span class="h-px w-16 bg-[#c9ab84]"></span>
                            <i class="fa fa-heart text-sm"></i>
                            <span class="h-px w-16 bg-[#c9ab84]"></span>
                        </div>

                        <div class="text-left text-[17px] leading-8 text-[#4d3827] sm:text-center sm:text-lg sm:leading-9">
                            @if($recognition !== '')
                                {!! nl2br(e($recognition)) !!}
                            @else
                                <p>Ban tổ chức trân trọng cảm ơn sự đồng hành, sẻ chia và tinh thần gắn kết của {{ $className }} trong hành trình trở về thanh xuân.</p>
                            @endif
                        </div>
                    </section>

                    <footer class="relative mt-12 border-t border-[#ccb592] pt-8 text-right">
                        <img src="{{ asset('images/pen.png') }}" alt="" aria-hidden="true" class="pointer-events-none absolute -bottom-5 left-0 w-24 -rotate-12 opacity-45 sm:w-32">
                        <p class="font-handwriting text-3xl font-bold text-[#8f2d25] sm:text-4xl">Trân trọng</p>
                        <p class="mt-2 text-sm font-bold uppercase tracking-[0.2em] text-[#68492f]">Ban tổ chức</p>
                        <p class="mt-1 text-xs font-semibold text-[#9a7959]">{{ $event->course_name }}</p>
                    </footer>
                </div>
            </article>

            <div class="mt-6 flex justify-center gap-3 print:hidden">
                <a href="https://zalo.me/share?u={{ urlencode($thankUrl) }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-full bg-blue-500 px-5 text-sm font-bold text-white shadow transition hover:bg-blue-400">Chia sẻ Zalo</a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($thankUrl) }}" target="_blank" rel="noopener" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-blue-700 text-white shadow transition hover:bg-blue-600"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </main>
@endsection
