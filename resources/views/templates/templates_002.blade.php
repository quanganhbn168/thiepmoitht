{{-- Template Name: Họp lớp 002 --}}
{{-- Template Type: reunion --}}
@extends('layouts.reunion')

@section('title', $event->title)
@section('meta_title', $event->meta_title)
@section('meta_description', $event->meta_description)
@section('share_image', $event->share_image)
@section('canonical_url', url('/' . $event->slug))

@push('styles')
<style>
    :root {
        --navy: #061b36;
        --navy-2: #031126;
        --navy-3: #0a2a52;
        --red: #b3132b;
        --red-2: #e02a3f;
        --red-deep: #7d0d20;
        --gold: #d7a84f;
        --gold-2: #f2cf7a;
        --champagne: #fff2cf;
        --cream: #fff8ec;
        --paper: #fffaf1;
        --ink: #101827;
        --muted: #697386;
        --white: #ffffff;
        --line: rgba(215, 168, 79, .26);
        --shadow: 0 24px 70px rgba(3, 17, 38, .18);
        --shadow-red: 0 20px 48px rgba(179, 19, 43, .22);
        --radius: 28px;
        --container: 1180px;
    }

    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }

    body {
        margin: 0;
        color: var(--ink);
        background: #fff6e7;
        font-family: "Montserrat", Arial, sans-serif;
    }

    a { color: inherit; text-decoration: none; }
    img { max-width: 100%; display: block; }

    .container-002 {
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
    }

    .section-kicker-002 {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
        color: var(--red);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .18em;
        text-transform: uppercase;
    }

    .section-kicker-002:before,
    .section-kicker-002:after {
        content: "";
        width: 34px;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }

    .section-title {
        margin: 0;
        color: var(--navy);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(34px, 4vw, 54px);
        font-weight: 900;
        line-height: 1.04;
        letter-spacing: -.035em;
        text-align: center;
    }

    .section-subtitle {
        max-width: 680px;
        margin: 16px auto 0;
        color: var(--muted);
        line-height: 1.75;
        text-align: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 50px;
        padding: 0 24px;
        border: 1px solid transparent;
        border-radius: 16px;
        cursor: pointer;
        font-family: inherit;
        font-weight: 900;
        letter-spacing: .01em;
        transition: transform .22s ease, box-shadow .22s ease, background .22s ease, border-color .22s ease;
    }

    .btn:hover { transform: translateY(-3px); }

    .btn-primary {
        color: #fff;
        background: linear-gradient(135deg, var(--red), var(--red-2));
        box-shadow: var(--shadow-red);
    }

    .btn-gold {
        color: var(--navy-2);
        background: linear-gradient(135deg, var(--gold-2), var(--gold));
        box-shadow: 0 16px 34px rgba(215, 168, 79, .3);
    }

    .btn-outline {
        color: var(--champagne);
        background: rgba(255, 255, 255, .08);
        border-color: rgba(242, 207, 122, .42);
        backdrop-filter: blur(10px);
    }

    /* HEADER */
    #site-header.reunion-site-header {
        position: fixed;
        inset: 0 0 auto 0;
        z-index: 80;
        background: rgba(3, 17, 38, .82);
        border-bottom: 1px solid rgba(242, 207, 122, .18);
        backdrop-filter: blur(16px);
    }

    #header.reunion-header-inner {
        width: min(var(--container), calc(100% - 40px));
        min-height: 78px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
    }

    .reunion-logo {
        display: inline-flex;
        align-items: center;
        min-width: 0;
    }

    .reunion-logo img {
        max-height: 52px;
        object-fit: contain;
        filter: drop-shadow(0 10px 20px rgba(0,0,0,.2));
    }

    .reunion-menu ul {
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
    }

    .reunion-menu a {
        display: inline-flex;
        padding: 10px 13px;
        color: rgba(255,255,255,.78);
        border-radius: 999px;
        font-size: 13px;
        font-weight: 800;
        transition: background .22s ease, color .22s ease;
    }

    .reunion-menu a:hover {
        color: var(--gold-2);
        background: rgba(255,255,255,.08);
    }

    .reunion-menu-toggle {
        display: none;
        width: 44px;
        height: 44px;
        border: 1px solid rgba(242, 207, 122, .32);
        border-radius: 14px;
        background: rgba(255,255,255,.08);
    }

    .reunion-menu-toggle span {
        display: block;
        width: 18px;
        height: 2px;
        margin: 4px auto;
        background: var(--gold-2);
    }

    /* HERO */
    #hero-section {
        position: relative;
        min-height: 820px;
        padding: 118px 0 78px;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(circle at 20% 20%, rgba(224, 42, 63, .28), transparent 34%),
            radial-gradient(circle at 85% 8%, rgba(242, 207, 122, .18), transparent 30%),
            linear-gradient(135deg, var(--navy-2) 0%, var(--navy) 48%, #091022 100%);
    }

    #hero-section:before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(242,207,122,.08) 1px, transparent 1px),
            linear-gradient(180deg, rgba(242,207,122,.06) 1px, transparent 1px);
        background-size: 58px 58px;
        mask-image: linear-gradient(180deg, rgba(0,0,0,.9), transparent 86%);
        pointer-events: none;
    }

    #hero-section:after {
        content: "";
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 1px;
        background: linear-gradient(180deg, transparent, rgba(242,207,122,.4), transparent);
        opacity: .72;
    }

    .hero-inner {
        position: relative;
        z-index: 2;
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(360px, 520px);
        gap: clamp(34px, 6vw, 72px);
        align-items: center;
    }

    .hero-section_right {
        position: relative;
        min-width: 0;
        padding: 48px 0;
    }

    .hero-badge-002 {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        padding: 9px 15px;
        color: var(--gold-2);
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(242,207,122,.24);
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .16em;
        text-transform: uppercase;
        backdrop-filter: blur(12px);
    }

    .hero-badge-002 i { color: var(--red-2); }

    #slogan {
        margin-bottom: 24px;
        color: #fff;
    }

    #slogan .pretitle,
    #slogan em:first-child {
        display: block;
        color: var(--gold-2);
        font-family: "Dancing Script", cursive;
        font-size: clamp(42px, 5vw, 74px);
        font-style: normal;
        font-weight: 700;
        line-height: .9;
        text-shadow: 0 18px 44px rgba(242,207,122,.24);
    }

    #slogan h2,
    #slogan h3,
    #slogan strong {
        display: block;
        margin: 8px 0 0;
        color: #fff;
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(64px, 8.2vw, 112px);
        font-weight: 900;
        line-height: .93;
        letter-spacing: -.065em;
        text-transform: uppercase;
        text-shadow: 0 4px 0 rgba(179,19,43,.34), 0 24px 70px rgba(0,0,0,.36);
    }

    #info-event .course-name {
        display: inline-flex;
        margin: 0 0 18px;
        padding: 9px 16px;
        color: #fff;
        background: linear-gradient(135deg, var(--red-deep), var(--red));
        border: 1px solid rgba(242,207,122,.22);
        border-radius: 12px;
        box-shadow: 0 16px 38px rgba(179,19,43,.26);
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    #info-event .event-description {
        max-width: 620px;
        color: rgba(255,255,255,.78);
        font-size: 17px;
        line-height: 1.85;
    }

    #event-date-time {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        max-width: 690px;
        margin: 30px 0;
    }

    #event-date-time > div,
    #event-date-time p {
        margin: 0;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        min-height: 92px;
        padding: 18px;
        color: #fff;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(242,207,122,.22);
        border-radius: 20px;
        box-shadow: 0 20px 45px rgba(0,0,0,.18);
        backdrop-filter: blur(12px);
    }

    #event-date-time i {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--navy-2);
        background: linear-gradient(135deg, var(--gold-2), var(--gold));
        border-radius: 14px;
        flex: 0 0 auto;
    }

    #event-date-time span:first-of-type {
        display: block;
        color: rgba(255,255,255,.55);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    #event-date-time strong {
        display: block;
        margin-top: 4px;
        color: #fff;
        font-size: 15px;
        line-height: 1.45;
    }

    #hero-rsvp {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    #hero-section_left {
        position: relative;
        min-width: 0;
    }

    .hero-visual-002 {
        position: relative;
        min-height: 610px;
        display: grid;
        place-items: center;
    }

    .hero-orbit-002 {
        position: absolute;
        inset: 36px 8px 24px 8px;
        border: 1px solid rgba(242,207,122,.22);
        border-radius: 999px 999px 80px 80px;
        transform: rotate(3deg);
    }

    .hero-orbit-002:before,
    .hero-orbit-002:after {
        content: "";
        position: absolute;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: var(--gold-2);
        box-shadow: 0 0 0 8px rgba(242,207,122,.12), 0 0 42px rgba(242,207,122,.62);
    }

    .hero-orbit-002:before { left: 10%; top: 16%; }
    .hero-orbit-002:after { right: 6%; bottom: 20%; }

    .hero-main-frame-002 {
        position: relative;
        width: min(440px, 100%);
        height: 560px;
        padding: 12px;
        border-radius: 240px 240px 34px 34px;
        background: linear-gradient(145deg, rgba(242,207,122,.98), rgba(179,19,43,.92) 44%, rgba(255,255,255,.12));
        box-shadow: 0 34px 90px rgba(0,0,0,.36);
        overflow: hidden;
    }

    .hero-main-frame-002:before {
        content: "";
        position: absolute;
        inset: 12px;
        z-index: 2;
        border: 1px solid rgba(255,255,255,.42);
        border-radius: 228px 228px 26px 26px;
        pointer-events: none;
    }

    .hero-main-frame-002 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 228px 228px 26px 26px;
        filter: saturate(1.06) contrast(1.02);
    }

    .hero-floating-card-002 {
        position: absolute;
        left: -18px;
        bottom: 64px;
        width: min(280px, 64%);
        overflow: hidden;
        background: rgba(255,255,255,.96);
        border: 1px solid rgba(242,207,122,.5);
        border-radius: 22px;
        box-shadow: var(--shadow);
    }

    .hero-floating-card-002 img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .hero-floating-card-002 span {
        display: block;
        padding: 13px 16px;
        color: var(--navy);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .count-down {
        position: absolute;
        right: -8px;
        top: 58px;
        z-index: 4;
        display: grid;
        gap: 10px;
        width: 118px;
    }

    .count-down p {
        margin: 0;
        min-height: 82px;
        display: flex;
        flex-direction: column-reverse;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: linear-gradient(145deg, rgba(179,19,43,.95), rgba(6,27,54,.92));
        border: 1px solid rgba(242,207,122,.34);
        border-radius: 18px;
        box-shadow: 0 18px 44px rgba(0,0,0,.3);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 31px;
        font-weight: 900;
    }

    .count-down p span:first-child {
        font-family: "Montserrat", Arial, sans-serif;
        color: var(--gold-2);
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .count-down p span:last-child { line-height: 1; }

    /* LETTER + PROGRAM */
    .intro-program-wrap {
        position: relative;
        padding: 92px 0;
        overflow: hidden;
        background:
            radial-gradient(circle at 8% 6%, rgba(179,19,43,.09), transparent 26%),
            radial-gradient(circle at 88% 18%, rgba(215,168,79,.17), transparent 32%),
            linear-gradient(180deg, #fff6e7 0%, #fffaf1 100%);
    }

    .intro-program-wrap:before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(6,27,54,.045) 1px, transparent 1px), linear-gradient(180deg, rgba(6,27,54,.035) 1px, transparent 1px);
        background-size: 54px 54px;
        pointer-events: none;
    }

    .intro-program-grid {
        position: relative;
        z-index: 2;
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
        display: grid;
        grid-template-columns: .92fr 1.08fr;
        gap: 24px;
        align-items: stretch;
    }

    #open-letter,
    #timeline {
        position: relative;
        overflow: hidden;
        padding: 42px;
        background: rgba(255,255,255,.74);
        border: 1px solid rgba(215,168,79,.26);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }

    #open-letter:before,
    #timeline:before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 0 0, rgba(179,19,43,.12), transparent 34%),
            url('/images/textures/paper.png') center / cover;
        opacity: .2;
        pointer-events: none;
    }

    #open-letter > *,
    #timeline > * { position: relative; z-index: 1; }

    #open-letter h3,
    #timeline h3 {
        margin: 0 0 22px;
        color: var(--red);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(32px, 3vw, 44px);
        font-weight: 900;
        line-height: 1.04;
    }

    .event-thu-ngo {
        color: #2f3948;
        font-size: 16px;
        line-height: 1.92;
        white-space: pre-line;
    }

    .program-list {
        position: relative;
        margin: 0;
        padding: 0;
        list-style: none;
        display: grid;
        gap: 14px;
    }

    .program-list li {
        position: relative;
        display: grid;
        grid-template-columns: 122px 1fr;
        gap: 18px;
        padding: 18px;
        background: linear-gradient(135deg, rgba(6,27,54,.05), rgba(179,19,43,.035));
        border: 1px solid rgba(6,27,54,.08);
        border-radius: 20px;
    }

    .program-time {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        color: var(--navy);
        background: linear-gradient(135deg, var(--gold-2), #fff5d7);
        border-radius: 14px;
        font-size: 13px;
        font-weight: 900;
        white-space: nowrap;
    }

    .program-content strong {
        display: block;
        margin-bottom: 5px;
        color: var(--red-deep);
        font-size: 16px;
        font-weight: 900;
    }

    .program-content span {
        color: var(--muted);
        font-size: 14px;
        line-height: 1.65;
    }

    .corner-flower,
    .flower {
        position: absolute;
        z-index: 1;
        pointer-events: none;
        user-select: none;
    }

    .corner-flower img,
    .flower img {
        width: clamp(170px, 20vw, 320px);
        height: auto;
        opacity: .82;
        filter: drop-shadow(0 22px 28px rgba(6,27,54,.14));
        animation: float002 6s ease-in-out infinite;
    }

    .corner-flower-top-right { top: -42px; right: -44px; }
    .corner-flower-top-left { top: -44px; left: -52px; }
    .corner-flower-bottom-right { right: -48px; bottom: -40px; }
    .corner-flower-bottom-left { left: -54px; bottom: -42px; }

    .corner-flower-top-left img { transform: scaleX(-1); }
    .corner-flower-bottom-right img { transform: scaleY(-1); }
    .corner-flower-bottom-left img { transform: scale(-1, -1); }

    @keyframes float002 {
        0%, 100% { translate: 0 0; }
        50% { translate: 0 -13px; }
    }

    /* CLASSES */
    #slide-class {
        position: relative;
        overflow: hidden;
        padding: 96px 0 104px;
        color: #fff;
        background:
            radial-gradient(circle at 16% 12%, rgba(224,42,63,.24), transparent 28%),
            radial-gradient(circle at 82% 0, rgba(242,207,122,.16), transparent 32%),
            linear-gradient(135deg, var(--navy-2), var(--navy) 58%, #17040a);
    }

    #slide-class:before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, transparent 0 42%, rgba(255,255,255,.055) 42% 43%, transparent 43% 100%);
        pointer-events: none;
    }

    .slide-class-inner {
        position: relative;
        z-index: 2;
        width: 100%;
    }

    .class-heading {
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto 36px;
        text-align: center;
    }

    .class-heading span {
        display: inline-flex;
        margin-bottom: 12px;
        padding: 8px 16px;
        color: var(--gold-2);
        border: 1px solid rgba(242,207,122,.35);
        border-radius: 999px;
        background: rgba(255,255,255,.07);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .class-heading .section-title { color: #fff; }
    .class-heading p {
        max-width: 640px;
        margin: 14px auto 0;
        color: rgba(255,255,255,.68);
        line-height: 1.7;
    }

    .class-swiper-wrap { width: 100%; padding: 8px 0 4px; }
    .class-swiper .swiper-wrapper { align-items: stretch; }
    .class-swiper .swiper-slide { height: auto; }

    .class-card-slider {
        position: relative;
        height: 100%;
        overflow: hidden;
        border: 1px solid rgba(242,207,122,.34);
        border-radius: 30px;
        background: rgba(255,255,255,.08);
        box-shadow: 0 26px 70px rgba(0,0,0,.3);
        transform: translateZ(0);
        transition: transform .25s ease, border-color .25s ease, background .25s ease;
    }

    .class-card-slider:hover {
        transform: translateY(-9px);
        border-color: var(--gold-2);
        background: rgba(255,255,255,.12);
    }

    .class-card-image {
        position: relative;
        display: block;
        height: 270px;
        overflow: hidden;
    }

    .class-card-image:after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 42%, rgba(3,17,38,.86));
        pointer-events: none;
    }

    .class-card-slider img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .45s ease;
    }

    .class-card-slider:hover img { transform: scale(1.07); }

    .class-card-slider .class-card-body {
        position: relative;
        padding: 22px 24px 26px;
        text-align: center;
    }

    .class-card-slider .class-card-body:before {
        content: "";
        position: absolute;
        top: 0;
        left: 24px;
        right: 24px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(242,207,122,.52), transparent);
    }

    .class-card-slider h4 {
        margin: 0 0 10px;
        color: var(--gold-2);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 36px;
        font-weight: 900;
    }

    .class-card-slider .class-card-body a,
    .class-card-slider .class-card-body button,
    .class-card-slider .class-card-body span {
        display: inline-flex;
        padding: 0;
        border: 0;
        color: rgba(255,255,255,.84);
        background: transparent;
        font-family: inherit;
        font-size: 13px;
        font-weight: 900;
        cursor: pointer;
    }

    .class-swiper-controls {
        width: min(var(--container), calc(100% - 40px));
        margin: 26px auto 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
    }

    .class-swiper-prev,
    .class-swiper-next {
        width: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--navy-2);
        background: linear-gradient(135deg, var(--gold-2), var(--gold));
        border: 0;
        border-radius: 16px;
        cursor: pointer;
        box-shadow: 0 16px 34px rgba(0,0,0,.22);
        transition: transform .2s ease;
    }

    .class-swiper-prev:hover,
    .class-swiper-next:hover { transform: translateY(-2px); }

    .class-swiper-pagination {
        width: auto !important;
        min-width: 90px;
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .class-swiper-pagination .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        margin: 0 !important;
        background: rgba(255,255,255,.42);
        opacity: 1;
    }

    .class-swiper-pagination .swiper-pagination-bullet-active {
        width: 26px;
        border-radius: 999px;
        background: var(--red-2);
        box-shadow: 0 0 0 4px rgba(224,42,63,.14);
    }

    /* GUESTBOOK */
    #soluubut {
        position: relative;
        overflow: hidden;
        padding: 98px 0 92px;
        background:
            radial-gradient(circle at 90% 10%, rgba(179,19,43,.1), transparent 30%),
            linear-gradient(180deg, #fffaf1 0%, #fff4e0 100%);
    }

    #soluubut:before {
        content: "";
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(135deg, rgba(215,168,79,.08) 0 1px, transparent 1px 18px);
        pointer-events: none;
    }

    .guestbook-wrap {
        position: relative;
        z-index: 2;
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
    }

    .guestbook-head {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: end;
        gap: 28px;
        margin-bottom: 34px;
        padding-bottom: 26px;
        border-bottom: 1px solid rgba(179,19,43,.14);
    }

    .guestbook-head .section-title { text-align: left; }
    .guestbook-head .section-subtitle {
        max-width: 570px;
        margin: 12px 0 0;
        text-align: left;
    }

    .guestbook-head .btn-outline {
        color: var(--navy);
        background: rgba(255,255,255,.78);
        border-color: rgba(179,19,43,.18);
    }

    .guestbook-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .guest-card {
        position: relative;
        min-height: 220px;
        padding: 30px;
        overflow: hidden;
        color: var(--ink);
        background: rgba(255,255,255,.82);
        border: 1px solid rgba(255,255,255,.9);
        border-radius: 28px;
        box-shadow: 0 22px 58px rgba(6,27,54,.1);
    }

    .guest-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 5px;
        background: linear-gradient(90deg, var(--red), var(--gold), var(--navy));
    }

    .guest-card .quote {
        color: rgba(179,19,43,.22);
        font-family: Georgia, serif;
        font-size: 62px;
        line-height: .58;
    }

    .guest-card p {
        margin: 14px 0 24px;
        color: #293244;
        line-height: 1.8;
    }

    .guest-card strong {
        display: inline-flex;
        color: var(--red-deep);
        font-size: 14px;
        line-height: 1.5;
    }

    [x-cloak] { display: none !important; }

    .guestbook-modal {
        position: fixed;
        inset: 0;
        z-index: 999;
        display: grid;
        place-items: center;
        padding: 24px;
    }

    .guestbook-modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(3, 17, 38, .72);
        backdrop-filter: blur(10px);
    }

    .guestbook-modal-card {
        position: relative;
        z-index: 1;
        width: min(530px, 100%);
        padding: 34px;
        background: #fff8ec;
        border: 1px solid rgba(215, 168, 79, .34);
        border-radius: 28px;
        box-shadow: 0 34px 90px rgba(0,0,0,.32);
    }

    .guestbook-modal-card h3 {
        margin: 0 0 10px;
        color: var(--red);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 36px;
    }

    .guestbook-modal-desc {
        margin: 0 0 22px;
        color: var(--muted);
        line-height: 1.6;
    }

    .guestbook-modal-close {
        position: absolute;
        top: 14px;
        right: 16px;
        width: 38px;
        height: 38px;
        border: 0;
        border-radius: 14px;
        cursor: pointer;
        color: var(--navy);
        background: rgba(255,255,255,.84);
        font-size: 28px;
        line-height: 1;
    }

    .guestbook-form { display: grid; gap: 14px; }
    .guestbook-form textarea { min-height: 132px; }
    .guestbook-form .full { width: 100%; }

    /* ACTION */
    #action {
        position: relative;
        overflow: hidden;
        padding: 98px 0 104px;
        background:
            radial-gradient(circle at 6% 16%, rgba(242,207,122,.15), transparent 28%),
            linear-gradient(180deg, #fff4e0 0%, #fffaf1 100%);
    }

    #action:before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(179,19,43,.045) 1px, transparent 1px), linear-gradient(180deg, rgba(6,27,54,.035) 1px, transparent 1px);
        background-size: 56px 56px;
        pointer-events: none;
    }

    .action-grid {
        position: relative;
        z-index: 2;
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.08fr .96fr .88fr;
        gap: 22px;
        align-items: stretch;
    }

    .action-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 100%;
        padding: 32px;
        overflow: hidden;
        background: rgba(255,255,255,.86);
        border: 1px solid rgba(255,255,255,.9);
        border-radius: 30px;
        box-shadow: 0 24px 64px rgba(6,27,54,.1);
    }

    .action-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 5px;
        background: linear-gradient(90deg, var(--red), var(--gold), var(--navy));
    }

    .action-card h3 {
        margin: 0 0 10px;
        color: var(--navy);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 30px;
        font-weight: 900;
        line-height: 1.12;
    }

    .action-card-desc {
        margin: 0 0 22px;
        color: var(--muted);
        font-size: 14px;
        line-height: 1.72;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .form-grid .full { grid-column: 1 / -1; }

    input, select, textarea {
        width: 100%;
        min-height: 46px;
        padding: 0 14px;
        color: var(--ink);
        background: rgba(255,255,255,.92);
        border: 1px solid rgba(6,27,54,.14);
        border-radius: 16px;
        outline: none;
        font: inherit;
    }

    textarea {
        min-height: 94px;
        padding-top: 12px;
        resize: vertical;
    }

    input:focus, select:focus, textarea:focus {
        border-color: var(--red);
        box-shadow: 0 0 0 4px rgba(179,19,43,.1);
    }

    .map-box {
        height: 232px;
        overflow: hidden;
        border-radius: 22px;
        border: 1px solid rgba(6,27,54,.12);
        background: #e9e2d8;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,.45);
    }

    .map-box iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }

    .contact-list {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .contact-list li {
        display: grid;
        grid-template-columns: .72fr 1fr;
        align-items: start;
        gap: 16px;
        padding: 15px 0;
        border-bottom: 1px dashed rgba(179,19,43,.16);
        color: var(--muted);
    }

    .contact-list span { font-size: 13px; }
    .contact-list strong {
        color: var(--navy);
        line-height: 1.5;
    }

    footer {
        position: relative;
        color: rgba(255,255,255,.82);
        background: linear-gradient(180deg, var(--navy-2) 0%, #020812 100%);
        border-top: 1px solid rgba(242,207,122,.22);
    }

    footer:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(242,207,122,.72), transparent);
    }

    footer .footer-inner {
        position: relative;
        width: min(var(--container), calc(100% - 40px));
        min-height: 136px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    footer strong {
        color: var(--gold-2);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 25px;
    }

    footer .footer-inner div div {
        margin-top: 8px;
        color: rgba(255,255,255,.6);
        line-height: 1.6;
    }

    footer p {
        margin: 0;
        color: rgba(255,255,255,.44);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    @media (max-width: 1080px) {
        #hero-section:after { display: none; }
        .hero-inner,
        .intro-program-grid,
        .action-grid { grid-template-columns: 1fr; }
        .hero-section_right { padding-bottom: 0; }
        .hero-visual-002 { min-height: 560px; }
        .guestbook-grid { grid-template-columns: repeat(2, 1fr); }
        .reunion-menu-toggle { display: inline-block; }
        .reunion-menu {
            position: absolute;
            top: 78px;
            left: 20px;
            right: 20px;
            display: none;
            padding: 14px;
            background: rgba(3,17,38,.96);
            border: 1px solid rgba(242,207,122,.22);
            border-radius: 20px;
            box-shadow: 0 24px 60px rgba(0,0,0,.26);
        }
        .reunion-menu.is-open,
        .reunion-menu[data-open="true"] { display: block; }
        .reunion-menu ul { display: grid; gap: 4px; }
        .reunion-menu a { width: 100%; justify-content: center; }
    }

    @media (max-width: 760px) {
        #hero-section {
            min-height: auto;
            padding: 104px 0 60px;
        }

        .hero-inner { gap: 28px; }
        #event-date-time { grid-template-columns: 1fr; }
        #hero-rsvp { flex-direction: column; }
        .hero-visual-002 { min-height: 500px; }
        .hero-main-frame-002 { height: 470px; }
        .hero-floating-card-002 { left: 0; bottom: 34px; width: 58%; }
        .hero-floating-card-002 img { height: 116px; }
        .count-down {
            right: 0;
            top: auto;
            bottom: 0;
            width: 100%;
            grid-template-columns: repeat(4, 1fr);
        }
        .count-down p {
            min-height: 74px;
            font-size: 24px;
            border-radius: 14px;
        }
        #open-letter,
        #timeline,
        .action-card,
        .guest-card { padding: 26px; }
        .program-list li { grid-template-columns: 1fr; }
        .guestbook-grid { grid-template-columns: 1fr; }
        .guestbook-head {
            align-items: flex-start;
            grid-template-columns: 1fr;
        }
        .form-grid { grid-template-columns: 1fr; }
        .contact-list li {
            grid-template-columns: 1fr;
            gap: 4px;
        }
        .class-card-image { height: 230px; }
        .corner-flower img,
        .flower img { width: 210px; opacity: .5; }
        footer .footer-inner {
            flex-direction: column;
            justify-content: center;
            text-align: center;
            padding: 30px 0;
        }
    }
</style>
@endpush

@section('content')
<header id="site-header" class="reunion-site-header">
    <div id="header" class="reunion-header-inner">
        <a id="logo" class="reunion-logo" href="#hero-section" aria-label="Trang chủ">
            <img src="{{ $event->logo }}" alt="{{ $event->title }}">
        </a>

        <button class="reunion-menu-toggle" type="button" data-reunion-menu-toggle aria-controls="menu"
            aria-expanded="false" aria-label="Mở menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav id="menu" class="reunion-menu" data-reunion-menu aria-label="Menu chính">
            <ul>
                <li><a href="#open-letter">Thư ngỏ</a></li>
                <li><a href="#timeline">Chương trình</a></li>
                <li><a href="#slide-class">Các lớp</a></li>
                <li><a href="#soluubut">Sổ lưu bút</a></li>
                <li><a href="#action">Xác nhận tham dự</a></li>
                <li><a href="#contact">Liên hệ</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    {{-- HERO --}}
    <section id="hero-section" style="--hero-bg: url('{{ $event->hero_image ?? $event->background ?? asset('images/demo/qv1-school.jpg') }}')">
        <div class="hero-inner">
            <div class="hero-section_right">
                <div class="hero-badge-002">
                    <i class="fa fa-star"></i>
                    Ngày trở về đáng nhớ
                </div>

                <div id="slogan">
                    {!! $event->slogan ?? '<span class="pretitle">Hẹn ngày</span><h2>Trở về</h2>' !!}
                </div>

                <div id="info-event">
                    <p class="course-name">{{ $event->course_name }} - {{ $event->school_name }}</p>

                    <div class="event-description">
                        {!! $event->description !!}
                    </div>

                    <div id="event-date-time" class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl my-6">
                        <div class="flex items-start gap-3 rounded-2xl border border-amber-700/20 bg-white/60 px-4 py-3 shadow-sm">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-700/10 text-amber-700">
                                <i class="fa fa-calendar text-base"></i>
                            </div>

                            <div class="min-w-0">
                                <span class="block text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Ngày hội ngộ
                                </span>
                                <strong class="mt-1 block text-sm font-extrabold leading-snug text-slate-900">
                                    {{ $event->time ?? 'Đang cập nhật' }}
                                </strong>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 rounded-2xl border border-amber-700/20 bg-white/60 px-4 py-3 shadow-sm">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-700/10 text-amber-700">
                                <i class="fa fa-map-marker-alt text-base"></i>
                            </div>

                            <div class="min-w-0">
                                <span class="block text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Địa điểm
                                </span>
                                <strong class="mt-1 block text-sm font-extrabold leading-snug text-slate-900">
                                    {{ $event->address ?? 'Đang cập nhật' }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div id="hero-rsvp">
                        <a class="btn btn-primary" href="#action">
                            <i class="fa fa-paper-plane"></i>
                            Xác nhận tham dự ngay
                        </a>
                        <a class="btn btn-outline" href="#timeline">Xem chương trình</a>
                    </div>
                </div>
            </div>

            <div id="hero-section_left">
                <div class="hero-visual-002">
                    <div class="hero-orbit-002"></div>

                    <div class="hero-main-frame-002">
                        <img src="{{ $event->hero_image ?? $event->background ?? asset('images/demo/qv1-school.jpg') }}" alt="{{ $event->title }}">
                    </div>

                    <div class="hero-floating-card-002">
                        <img src="{{ $event->hero_photo_1 ?? asset('images/demo/class-1.jpg') }}" alt="Ảnh kỷ niệm {{ $event->title }}">
                        <span>{{ $event->course_name }}</span>
                    </div>

                    <div class="count-down">
                        <p><span id="day">26</span><span>Ngày</span></p>
                        <p><span id="hours">14</span><span>Giờ</span></p>
                        <p><span id="min">35</span><span>Phút</span></p>
                        <p><span id="second">48</span><span>Giây</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- THƯ NGỎ + CHƯƠNG TRÌNH --}}
    <section class="intro-program-wrap">
        <div class="corner-flower corner-flower-top-right">
            <img src="{{ asset('images/bang-lang-color.png') }}" alt="Hoa bằng lăng">
        </div>

        <div class="intro-program-grid">
            <article id="open-letter">
                <h3>Thư ngỏ</h3>
                <div class="event-thu-ngo">{!! nl2br(e($event->thungo)) !!}</div>
            </article>

            <article id="timeline">
                <h3>Chương trình hội ngộ</h3>
                <ul class="program-list">
                    @forelse(($event->programs ?? []) as $program)
                    <li>
                        <div class="program-time">{{ $program->time }}</div>
                        <div class="program-content">
                            <strong>{{ $program->title }}</strong>
                            @if(!empty($program->description))
                            <span>{{ $program->description }}</span>
                            @endif
                        </div>
                    </li>
                    @empty
                    <li>
                        <div class="program-time">07:30 - 08:30</div>
                        <div class="program-content"><strong>Đón tiếp đại biểu & đăng ký</strong><span>Đón tiếp các bạn, thầy cô và lưu giữ khoảnh khắc đầu tiên.</span></div>
                    </li>
                    <li>
                        <div class="program-time">08:30 - 09:30</div>
                        <div class="program-content"><strong>Lễ kỷ niệm & chụp ảnh tập thể</strong><span>Ổn định chương trình, gặp lại thầy cô và bạn bè.</span></div>
                    </li>
                    <li>
                        <div class="program-time">09:30 - 11:00</div>
                        <div class="program-content"><strong>Giao lưu - Chia sẻ - Kỷ niệm</strong><span>Cùng ôn lại những câu chuyện đẹp của một thời áo trắng.</span></div>
                    </li>
                    <li>
                        <div class="program-time">11:00 - 13:30</div>
                        <div class="program-content"><strong>Tiệc trưa thân mật</strong><span>Bữa cơm họp mặt, kết nối và sẻ chia.</span></div>
                    </li>
                    <li>
                        <div class="program-time">13:30 - 15:00</div>
                        <div class="program-content"><strong>Giao lưu văn nghệ - Gameshow</strong><span>Những tiết mục vui vẻ dành cho các lớp.</span></div>
                    </li>
                    <li>
                        <div class="program-time">15:00 - 16:00</div>
                        <div class="program-content"><strong>Chụp ảnh tự do - Kết thúc</strong><span>Lưu lại những khoảnh khắc cuối ngày hội ngộ.</span></div>
                    </li>
                    @endforelse
                </ul>
            </article>
        </div>

        <div class="corner-flower corner-flower-bottom-left">
            <img src="{{ asset('images/pen.png') }}" alt="Bút kỷ niệm">
        </div>
    </section>

    {{-- CÁC LỚP --}}
    <section id="slide-class" class="relative overflow-hidden">
        <div class="slide-class-inner">
            <div class="class-heading">
                <span>Album kỷ niệm</span>
                <h2 class="section-title">Các lớp</h2>
                <p>Cùng nhìn lại những gương mặt thân quen của một thời áo trắng.</p>
            </div>

            <div class="class-swiper-wrap">
                <div class="swiper class-swiper">
                    <div class="swiper-wrapper">
                        @forelse(($event->classes ?? []) as $class)
                            @php
                                $classPhotos = collect($class->photos ?? [])->filter()->values();
                                $firstClassPhoto = $classPhotos->first();
                                $classGalleryId = 'class-gallery-' . \Illuminate\Support\Str::slug($class->name);
                            @endphp
                            <div class="swiper-slide">
                                <article class="class-card class-card-slider">
                                    <a href="{{ $firstClassPhoto ?: '#' }}"
                                        class="class-card-image {{ $firstClassPhoto ? 'js-class-gallery' : '' }}"
                                        @if($firstClassPhoto)
                                            data-gallery="{{ $classGalleryId }}"
                                            data-title="{{ $class->name }} - Ảnh 1"
                                        @endif>
                                        <img src="{{ $class->thumbnail }}" alt="{{ $class->name }}">
                                    </a>

                                    @foreach($classPhotos->slice(1)->values() as $photoIndex => $photo)
                                        <a href="{{ $photo }}"
                                            class="js-class-gallery"
                                            data-gallery="{{ $classGalleryId }}"
                                            data-title="{{ $class->name }} - Ảnh {{ $photoIndex + 2 }}"
                                            style="display: none;"></a>
                                    @endforeach

                                    <div class="class-card-body">
                                        <h4>{{ $class->name }}</h4>
                                        @if($firstClassPhoto)
                                            <button type="button" data-class-gallery-trigger>Xem ảnh lớp →</button>
                                        @else
                                            <span>Đang cập nhật ảnh</span>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        @empty
                            @foreach(['12A','12B','12C','12D','12E','12G','12H'] as $className)
                                <div class="swiper-slide">
                                    <article class="class-card class-card-slider">
                                        <a href="#" class="class-card-image">
                                            <img src="{{ asset('images/demo/class-card.jpg') }}" alt="Lớp {{ $className }}">
                                        </a>

                                        <div class="class-card-body">
                                            <h4>{{ $className }}</h4>
                                            <a href="#">Xem ảnh lớp →</a>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        @endforelse
                    </div>

                    <div class="class-swiper-controls">
                        <button class="class-swiper-prev" type="button" aria-label="Lớp trước">
                            <i class="fa fa-chevron-left"></i>
                        </button>

                        <div class="class-swiper-pagination"></div>

                        <button class="class-swiper-next" type="button" aria-label="Lớp tiếp theo">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="corner-flower corner-flower-top-left">
            <img src="{{ asset('images/phuong-1.png') }}" alt="hoa-phuong-1">
        </div>
        <div class="corner-flower corner-flower-bottom-right">
            <img src="{{ asset('images/phuong-2.png') }}" alt="hoa-phuong-2">
        </div>
    </section>

    {{-- SỔ LƯU BÚT --}}
    <section id="soluubut" x-data="{ guestbookOpen: false }">
        <div class="guestbook-wrap">
            <div class="guestbook-head">
                <div>
                    <h2 class="section-title">Sổ lưu bút</h2>
                    <p class="section-subtitle">Những dòng nhắn gửi trước ngày trở về, để câu chuyện thanh xuân được nối tiếp bằng chính giọng nói của bạn bè.</p>
                </div>

                <button class="btn btn-outline" type="button" @click="guestbookOpen = true">
                    <i class="fa fa-pen-nib"></i>
                    Viết lưu bút
                </button>
            </div>

            <div class="guestbook-grid">
                @forelse(($event->guestbooks ?? []) as $note)
                    <article class="guest-card">
                        <div class="quote">“</div>
                        <p>{{ $note->content }}</p>
                        <strong>
                            — {{ $note->name }}{{ !empty($note->class_name) ? ' - '.$note->class_name : '' }}
                        </strong>
                    </article>
                @empty
                    <article class="guest-card">
                        <div class="quote">“</div>
                        <p>Thật háo hức được gặp lại các bạn, mong ngày hội ngộ sẽ thật nhiều kỷ niệm đẹp!</p>
                        <strong>— Nguyễn Văn Nam - 12A</strong>
                    </article>

                    <article class="guest-card">
                        <div class="quote">“</div>
                        <p>30 năm rồi mới có dịp quay lại mái trường xưa, cảm xúc thật khó tả.</p>
                        <strong>— Phạm Thị Hương - 12B</strong>
                    </article>

                    <article class="guest-card">
                        <div class="quote">“</div>
                        <p>Hẹn gặp tất cả anh chị em khóa 88 trong ngày trở về đầy ý nghĩa này.</p>
                        <strong>— Trần Quang Minh - 12C</strong>
                    </article>
                @endforelse
            </div>
        </div>

        {{-- Modal viết lưu bút --}}
        <div
            x-cloak
            x-show="guestbookOpen"
            x-transition.opacity
            class="guestbook-modal"
            @keydown.escape.window="guestbookOpen = false"
        >
            <div class="guestbook-modal-backdrop" @click="guestbookOpen = false"></div>

            <div
                class="guestbook-modal-card"
                x-show="guestbookOpen"
                x-transition.scale.origin.center
                @click.stop
            >
                <button
                    type="button"
                    class="guestbook-modal-close"
                    @click="guestbookOpen = false"
                    aria-label="Đóng"
                >
                    ×
                </button>

                <h3>Viết lưu bút</h3>
                <p class="guestbook-modal-desc">
                    Gửi một lời nhắn yêu thương trước ngày trở về.
                </p>

                <form
                    action="{{ route('reunion.message.store', ['reunion' => $reunion->slug]) }}"
                    method="POST"
                    onsubmit="handleTemplate002Guestbook(event)"
                >
                    @csrf

                    <div class="guestbook-form">
                        <input
                            name="name"
                            type="text"
                            placeholder="Họ và tên *"
                            required
                        >

                        <textarea
                            name="content"
                            placeholder="Lời nhắn của bạn *"
                            required
                        ></textarea>

                        <button class="btn btn-primary full" type="submit">
                            <i class="fa fa-paper-plane"></i>
                            Gửi lưu bút
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- RSVP + MAP + CONTACT --}}
    <section id="action" class="overflow-hidden relative">
        <div class="action-grid">
            <div id="rsvp" class="action-card">
                <h3>Xác nhận tham dự</h3>
                <p class="action-card-desc">Gửi thông tin tham dự để ban tổ chức chuẩn bị chỗ ngồi, tiệc và liên hệ khi cần.</p>
                <form action="{{ $rsvpUrl ?? route('reunion.rsvp.store', ['reunion' => $reunion->slug]) }}" method="POST" onsubmit="handleTemplate002Rsvp(event)">
                    @csrf
                    <div class="form-grid">
                        <input name="name" type="text" placeholder="Họ và tên *" required>
                        <select name="class" required>
                            <option value="">Chọn lớp *</option>
                            @forelse(($event->classes ?? []) as $class)
                            <option value="{{ $class->name }}">{{ $class->name }}</option>
                            @empty
                            <option>12A</option><option>12B</option><option>12C</option><option>12D</option><option>12E</option>
                            @endforelse
                        </select>
                        <input name="phone" type="tel" placeholder="Số điện thoại *" required>
                        <input name="guest_count" type="number" min="1" placeholder="Số người tham dự">
                        <textarea class="full" name="note" placeholder="Lời nhắn nếu có"></textarea>
                        <button class="btn btn-primary full" type="submit"><i class="fa fa-paper-plane"></i> Gửi xác nhận</button>
                    </div>
                </form>
            </div>

            <div id="event-map" class="action-card">
                <h3>Địa điểm tổ chức</h3>
                <p class="action-card-desc">Lưu lại địa chỉ và mở bản đồ trước khi di chuyển để tới điểm hẹn đúng giờ.</p>
                <p><strong>{{ $event->school_name }}</strong><br>{{ $event->address }}</p>
                <div class="map-box">
                    {!! $event->map_embed ?? '<iframe loading="lazy" src="https://www.google.com/maps?q=Tr%C6%B0%E1%BB%9Dng%20THPT%20Qu%E1%BA%BF%20V%C3%B5%201&output=embed"></iframe>' !!}
                </div>
            </div>

            <div id="contact" class="action-card">
                <h3>Liên hệ ban tổ chức</h3>
                <p class="action-card-desc">Cần hỗ trợ về lịch trình, địa điểm hoặc thông tin lớp, anh chị có thể liên hệ trực tiếp.</p>
                <ul class="contact-list">
                    @forelse(($event->contacts ?? []) as $contact)
                    <li><span>{{ $contact->role }}</span><strong>{{ $contact->name }} - {{ $contact->phone }}</strong></li>
                    @empty
                    <li><span>Trưởng ban</span><strong>Nguyễn Văn Hòa - 0986 123 456</strong></li>
                    <li><span>Phó ban</span><strong>Phạm Thị Lan - 0912 345 678</strong></li>
                    <li><span>Thư ký</span><strong>Trần Quang Minh - 0978 765 432</strong></li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="corner-flower corner-flower-bottom-right">
            <img src="{{ asset('images/phuong-3.png') }}" alt="hoa-phuong-3">
        </div>
    </section>
</main>

<footer>
    <div class="footer-inner">
        <div>
            <strong>{{ $event->course_name }} - {{ $event->school_name }}</strong>
            <div>Thanh xuân có thể đi qua, nhưng ký ức dưới mái trường {{ $event->school_name }} thì còn mãi.</div>
        </div>
        <p>Copyright THT MEDIA</p>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    function handleTemplate002Rsvp(e) {
        e.preventDefault();

        const form = e.target;
        const button = form.querySelector('button[type="submit"]');
        const originalText = button ? button.innerHTML : '';
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        const token = tokenMeta ? tokenMeta.getAttribute('content') : '';
        const data = Object.fromEntries(new FormData(form).entries());

        if (button) {
            button.disabled = true;
            button.innerHTML = 'Đang gửi...';
        }

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
            .then(async response => {
                if (!response.ok) {
                    const payload = await response.json().catch(() => ({}));
                    throw new Error(payload.message || 'Không gửi được xác nhận.');
                }
                return response.json();
            })
            .then(() => {
                form.reset();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ title: 'Đã nhận xác nhận!', text: 'Cảm ơn bạn đã gửi thông tin tham dự.', icon: 'success', confirmButtonText: 'Đóng' });
                } else {
                    alert('Đã gửi xác nhận tham dự!');
                }
            })
            .catch(error => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ title: 'Chưa gửi được', text: error.message, icon: 'error', confirmButtonText: 'Đóng' });
                } else {
                    alert(error.message);
                }
            })
            .finally(() => {
                if (button) { button.disabled = false; button.innerHTML = originalText; }
            });
    }

    (function () {
        const eventDate = new Date("{{ $event->countdown_time }}").getTime();
        const dayEl = document.getElementById('day');
        const hoursEl = document.getElementById('hours');
        const minEl = document.getElementById('min');
        const secondEl = document.getElementById('second');

        if (!Number.isFinite(eventDate)) return;

        function pad(num) { return String(num).padStart(2, '0'); }

        function updateCountdown() {
            const now = Date.now();
            const distance = Math.max(eventDate - now, 0);
            const days    = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours   = Math.floor((distance / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((distance / (1000 * 60)) % 60);
            const seconds = Math.floor((distance / 1000) % 60);

            if (dayEl)    dayEl.textContent   = pad(days);
            if (hoursEl)  hoursEl.textContent  = pad(hours);
            if (minEl)    minEl.textContent    = pad(minutes);
            if (secondEl) secondEl.textContent = pad(seconds);
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
</script>
<script>
    function handleTemplate002Guestbook(e) {
        e.preventDefault();

        const form = e.target;
        const button = form.querySelector('button[type="submit"]');
        const originalText = button ? button.innerHTML : '';
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        const token = tokenMeta ? tokenMeta.getAttribute('content') : '';
        const data = Object.fromEntries(new FormData(form).entries());

        if (button) {
            button.disabled = true;
            button.innerHTML = 'Đang gửi...';
        }

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
            .then(async response => {
                if (!response.ok) {
                    const payload = await response.json().catch(() => ({}));
                    throw new Error(payload.message || 'Không gửi được lưu bút.');
                }
                return response.json();
            })
            .then(() => {
                form.reset();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ title: 'Đã gửi lưu bút!', text: 'Cảm ơn bạn đã gửi lời nhắn. Lưu bút sẽ hiển thị sau khi được duyệt.', icon: 'success', confirmButtonText: 'Đóng' }).then(() => { window.location.reload(); });
                } else {
                    alert('Đã gửi lưu bút!');
                    window.location.reload();
                }
            })
            .catch(error => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ title: 'Chưa gửi được', text: error.message, icon: 'error', confirmButtonText: 'Đóng' });
                } else {
                    alert(error.message);
                }
            })
            .finally(() => {
                if (button) { button.disabled = false; button.innerHTML = originalText; }
            });
    }
</script>
@endpush
