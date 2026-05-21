{{-- Template Name: Thiệp thầy cô 001 --}}
{{-- Template Type: reunion_teacher --}}
@extends('layouts.reunion')

@section('title', $event->title)
@section('meta_title', $event->meta_title)
@section('meta_description', $event->meta_description)
@section('share_image', $event->share_image)
@section('canonical_url', url('/' . $event->slug))

@push('styles')
<style>
    :root {
        --navy: #062447;
        --navy-2: #03172f;
        --blue-soft: #0e3a63;
        --cream: #f7efe1;
        --paper: #fbf4e8;
        --paper-2: #f2e2c8;
        --gold: #b98843;
        --gold-2: #d7ad69;
        --ink: #162638;
        --muted: #6b6258;
        --white: #ffffff;
        --shadow: 0 18px 45px rgba(5, 26, 50, .18);
        --radius: 22px;
        --container: 1180px;
    }

    * { box-sizing: border-box; }

    html { scroll-behavior: smooth; }

    body {
        margin: 0;
        color: var(--ink);
        background: #f8f0e4;
        font-family: "Montserrat", Arial, sans-serif;
    }

    a { color: inherit; text-decoration: none; }
    img { max-width: 100%; display: block; }

    .container {
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
    }

    .section-title {
        margin: 0 0 28px;
        color: var(--navy);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(32px, 4vw, 48px);
        font-weight: 800;
        line-height: 1.05;
        text-align: center;
    }

    .section-subtitle {
        max-width: 680px;
        margin: -14px auto 36px;
        color: var(--muted);
        line-height: 1.7;
        text-align: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 48px;
        padding: 0 24px;
        border-radius: 999px;
        border: 1px solid transparent;
        cursor: pointer;
        font-weight: 800;
        letter-spacing: .02em;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .btn:hover { transform: translateY(-2px); }

    .btn-primary {
        color: #fff;
        background: linear-gradient(135deg, var(--navy), var(--blue-soft));
        box-shadow: 0 12px 25px rgba(6, 36, 71, .24);
    }

    .btn-gold {
        color: var(--navy-2);
        background: linear-gradient(135deg, #f4d28d, #b98843);
        box-shadow: 0 12px 25px rgba(185, 136, 67, .28);
    }

    .btn-outline {
        color: var(--navy);
        background: rgba(255,255,255,.58);
        border-color: rgba(6, 36, 71, .22);
    }

    /* HERO */
    #hero-section {
        position: relative;
        min-height: 760px;
        padding: 130px 0 70px;
        overflow: hidden;
        background:
        linear-gradient(90deg, rgba(248, 240, 228, .98) 0%, rgba(248, 240, 228, .84) 38%, rgba(248, 240, 228, .26) 66%, rgba(248, 240, 228, .05) 100%),
        var(--hero-bg, url('/images/demo/school.jpg')) center right / cover no-repeat;
    }

    #hero-section:before {
        content: "";
        position: absolute;
        inset: auto 0 0 0;
        height: 90px;
        background:
        radial-gradient(circle at 20% 0, rgba(255,255,255,.8), transparent 40%),
        linear-gradient(180deg, rgba(248,240,228,0), #f8f0e4 68%);
        pointer-events: none;
    }

    #hero-section:after {
        content: "";
        position: absolute;
        right: -140px;
        top: 130px;
        width: 520px;
        height: 520px;
        background: radial-gradient(circle, rgba(185,136,67,.18), transparent 68%);
        pointer-events: none;
    }

    .hero-inner {
        position: relative;
        z-index: 2;
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 470px;
        align-items: center;
        gap: 54px;
    }

    .hero-section_right { min-width: 0; }

    #slogan {
        margin-bottom: 22px;
        color: var(--navy);
        font-family: "Playfair Display", Georgia, serif;
    }

    #slogan .pretitle,
    #slogan em:first-child {
        display: block;
        color: var(--navy);
        font-family: "Dancing Script", cursive;
        font-size: clamp(42px, 5vw, 72px);
        line-height: .9;
        font-style: normal;
        font-weight: 700;
    }

    #slogan h3,
    #slogan strong {
        display: block;
        margin: 8px 0 0;
        color: var(--navy);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(78px, 9vw, 90px);
        line-height: 1.2;
        letter-spacing: -.04em;
        text-transform: uppercase;
        text-shadow: 0 3px 0 rgba(255,255,255,.55);
    }

    #info-event .course-name {
        display: inline-flex;
        margin: 0 0 18px;
        padding: 9px 18px;
        color: #fff;
        background: var(--navy);
        border-radius: 999px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    #info-event .event-description {
        max-width: 520px;
        color: #35475a;
        font-size: 18px;
        line-height: 1.75;
    }

    #event-date-time {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        max-width: 620px;
        margin: 26px 0;
    }

    #event-date-time p {
        margin: 0;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px 18px;
        background: rgba(255,255,255,.58);
        border: 1px solid rgba(185,136,67,.22);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(6,36,71,.08);
    }

    #event-date-time i {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--gold);
        background: rgba(185,136,67,.12);
        border-radius: 50%;
        flex: 0 0 auto;
    }

    #event-date-time span:first-of-type {
        display: block;
        color: var(--muted);
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
    }

    #event-date-time strong {
        display: block;
        color: var(--navy);
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
        min-height: 520px;
    }

    .hero-photo-stack {
        position: relative;
        height: 520px;
    }

    .hero-photo {
        position: absolute;
        overflow: hidden;
        background: #fff;
        border: 10px solid #fff;
        border-radius: 8px;
        box-shadow: var(--shadow);
        transform: rotate(-3deg);
    }

    .hero-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-photo.main {
        top: 0;
        right: 40px;
        width: 360px;
        height: 250px;
    }

    .hero-photo.second {
        top: 210px;
        left: 0;
        width: 300px;
        height: 210px;
        transform: rotate(4deg);
    }

    .hero-photo.third {
        right: 0;
        bottom: 18px;
        width: 260px;
        height: 176px;
        transform: rotate(-1deg);
    }

    .count-down {
        position: absolute;
        left: -26px;
        bottom: 0;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        width: min(420px, 100%);
    }

    .count-down p {
        margin: 0;
        min-height: 92px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--navy);
        background: rgba(255,255,255,.82);
        border: 1px solid rgba(185,136,67,.2);
        border-radius: 14px;
        box-shadow: 0 16px 35px rgba(6,36,71,.12);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 34px;
        font-weight: 900;
    }

    .count-down p span {
        margin-top: 4px;
        font-family: "Montserrat", Arial, sans-serif;
        color: var(--muted);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
    }

    /* LETTER + PROGRAM */
    .intro-program-wrap {
        position: relative;
    padding: 72px 0 76px;
    background:
        radial-gradient(circle at 10% 10%, rgba(255,255,255,.75), transparent 30%),
        linear-gradient(180deg, #f8f0e4 0%, #f2dfc4 100%);
    overflow: hidden;
    }
    .flower {
    position: absolute;
    z-index: 0;
    pointer-events: none;
    user-select: none;
}

.flower img {
    width: clamp(180px, 22vw, 360px);
    height: auto;
    opacity: .92;
    filter: drop-shadow(0 18px 28px rgba(6, 36, 71, .16));
    animation: flowerFloat 5.8s ease-in-out infinite;
}

.flower-bottom-right {
    right: -52px;
    bottom: -38px;
    transform: rotate(-8deg);
}

.flower-bottom-left {
    left: -60px;
    bottom: -36px;
    transform: rotate(10deg) scaleX(-1);
}

.intro-program-grid {
    position: relative;
    z-index: 2;
}

@keyframes flowerFloat {
    0%, 100% {
        translate: 0 0;
    }

    50% {
        translate: 0 -14px;
    }
}
.corner-flower {
    position: absolute;
    z-index: 0;
    pointer-events: none;
    user-select: none;
}

.corner-flower img {
    width: clamp(180px, 22vw, 360px);
    height: auto;
    opacity: .92;
    filter: drop-shadow(0 18px 28px rgba(6, 36, 71, .16));
    animation: cornerFlowerFloat 6s ease-in-out infinite;
    transform-origin: center;
}

/* Ảnh gốc hợp góc trên bên phải */
.corner-flower-top-right {
    top: -28px;
    right: -36px;
}

.corner-flower-top-right img {
    transform: rotate(0deg);
}

/* Lật ngang để hợp góc trên bên trái */
.corner-flower-top-left {
    top: -28px;
    left: -36px;
}

.corner-flower-top-left img {
    transform: scaleX(-1);
}

/* Lật dọc để hợp góc dưới bên phải */
.corner-flower-bottom-right {
    right: -36px;
    bottom: -28px;
}

.corner-flower-bottom-right img {
    transform: scaleY(-1);
}

/* Lật cả ngang + dọc để hợp góc dưới bên trái */
.corner-flower-bottom-left {
    left: -36px;
    bottom: -28px;
}

.corner-flower-bottom-left img {
    transform: scale(-1, -1);
}

@keyframes cornerFlowerFloat {
    0%, 100% {
        translate: 0 0;
    }

    50% {
        translate: 0 -12px;
    }
}

@media (max-width: 760px) {
    .corner-flower img {
        width: 210px;
        opacity: .55;
    }

    .corner-flower-top-right {
        top: -30px;
        right: -70px;
    }

    .corner-flower-top-left {
        top: -30px;
        left: -70px;
    }

    .corner-flower-bottom-right {
        right: -70px;
        bottom: -30px;
    }

    .corner-flower-bottom-left {
        left: -70px;
        bottom: -30px;
    }
}
@media (max-width: 760px) {
    .flower img {
        width: 210px;
        opacity: .55;
    }

    .flower-bottom-right {
        right: -72px;
        bottom: -24px;
    }

    .flower-bottom-left {
        left: -78px;
        bottom: -24px;
    }
}
    .intro-program-grid {
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.05fr .95fr;
        gap: 34px;
        align-items: stretch;
    }

    #open-letter,
    #timeline {
        position: relative;
        padding: 44px;
        background: rgba(255,255,255,.55);
        border: 1px solid rgba(185,136,67,.22);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    #open-letter:before,
    #timeline:before {
        content: "";
        position: absolute;
        inset: 0;
        background: url('/images/textures/paper.png') center / cover;
        opacity: .18;
        pointer-events: none;
    }

    #open-letter > *,
    #timeline > * { position: relative; z-index: 1; }

    #open-letter h3,
    #timeline h3 {
        margin: 0 0 24px;
        color: var(--navy);
        font-family: "Dancing Script", cursive;
        font-size: 54px;
        line-height: 1;
    }

    .event-thu-ngo {
        color: #2d3744;
        font-size: 16px;
        line-height: 1.9;
        white-space: pre-line;
    }

    .program-list {
        position: relative;
        margin: 0;
        padding: 0 0 0 30px;
        list-style: none;
    }

    .program-list:before {
        content: "";
        position: absolute;
        left: 7px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: linear-gradient(180deg, var(--gold), rgba(185,136,67,.15));
    }

    .program-list li {
        position: relative;
        display: grid;
        grid-template-columns: 110px 1fr;
        gap: 18px;
        padding: 0 0 22px;
    }

    .program-list li:last-child { padding-bottom: 0; }

    .program-list li:before {
        content: "";
        position: absolute;
        left: -29px;
        top: 7px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: var(--gold);
        border: 4px solid #f8f0e4;
        box-shadow: 0 0 0 1px rgba(185,136,67,.45);
    }

    .program-time {
        color: var(--gold);
        font-weight: 900;
        white-space: nowrap;
    }

    .program-content strong {
        display: block;
        margin-bottom: 4px;
        color: var(--navy);
        font-size: 16px;
    }

    .program-content span {
        color: var(--muted);
        font-size: 14px;
        line-height: 1.6;
    }

    /* CLASSES */
#slide-class {
    position: relative;
    overflow: hidden;
    padding: 86px 0 96px;
    color: #fff;
    background:
        radial-gradient(circle at 15% 0, rgba(215,173,105,.18), transparent 30%),
        radial-gradient(circle at 88% 18%, rgba(255,255,255,.08), transparent 28%),
        linear-gradient(135deg, var(--navy-2), var(--navy));
}

.slide-class-inner {
    position: relative;
    z-index: 2;
    width: 100%;
}

.class-heading {
    width: min(var(--container), calc(100% - 40px));
    margin: 0 auto 34px;
    text-align: center;
}

.class-heading span {
    display: inline-flex;
    margin-bottom: 10px;
    padding: 7px 16px;
    color: var(--gold-2);
    border: 1px solid rgba(215, 173, 105, .35);
    border-radius: 999px;
    background: rgba(255,255,255,.06);
    font-size: 12px;
    font-weight: 900;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.class-heading .section-title {
    margin-bottom: 12px;
    color: #fff;
}

.class-heading p {
    max-width: 620px;
    margin: 0 auto;
    color: rgba(255,255,255,.72);
    line-height: 1.7;
}

.class-swiper-wrap {
    width: 100%;
    padding: 8px 0 4px;
}


.class-swiper .swiper-wrapper {
    align-items: stretch;
}

.class-swiper .swiper-slide {
    height: auto;
}

.class-card-slider {
    height: 100%;
    overflow: hidden;
    border: 1px solid rgba(215,173,105,.42);
    border-radius: 24px;
    background: rgba(255,255,255,.07);
    box-shadow: 0 24px 55px rgba(0,0,0,.28);
    transform: translateZ(0);
    transition: transform .25s ease, border-color .25s ease, background .25s ease;
}

.class-card-slider:hover {
    transform: translateY(-8px);
    border-color: var(--gold-2);
    background: rgba(255,255,255,.11);
}

.class-card-image {
    position: relative;
    display: block;
    height: 250px;
    overflow: hidden;
}

.class-card-image:after {
    content: "";
    position: absolute;
    inset: auto 0 0 0;
    height: 48%;
    background: linear-gradient(180deg, transparent, rgba(3,23,47,.74));
    pointer-events: none;
}

.class-card-slider img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
}

.class-card-slider:hover img {
    transform: scale(1.07);
}

.class-card-slider .class-card-body {
    padding: 20px 22px 24px;
    text-align: center;
}

.class-card-slider h4 {
    margin: 0 0 8px;
    color: var(--gold-2);
    font-family: "Playfair Display", Georgia, serif;
    font-size: 34px;
}

.class-card-slider .class-card-body a,
.class-card-slider .class-card-body button,
.class-card-slider .class-card-body span {
    display: inline-flex;
    padding: 0;
    border: 0;
    color: rgba(255,255,255,.86);
    background: transparent;
    font-size: 13px;
    font-weight: 800;
    cursor: pointer;
    font-family: inherit;
}

.class-swiper-controls {
    width: min(var(--container), calc(100% - 40px));
    margin: 24px auto 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 18px;
}

.class-swiper-prev,
.class-swiper-next {
    width: 44px;
    height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--navy);
    background: linear-gradient(135deg, #f4d28d, #b98843);
    border: 0;
    border-radius: 999px;
    cursor: pointer;
    box-shadow: 0 14px 28px rgba(0,0,0,.18);
    transition: transform .2s ease, opacity .2s ease;
}

.class-swiper-prev:hover,
.class-swiper-next:hover {
    transform: translateY(-2px);
}

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
    width: 24px;
    border-radius: 999px;
    background: var(--gold-2);
}

#slide-class .corner-flower {
    z-index: 1;
    opacity: .9;
}

@media (max-width: 1040px) {
    .class-swiper {
        padding-inline: 20px;
    }

    .class-card-image {
        height: 230px;
    }
}

@media (max-width: 760px) {
    #slide-class {
        padding: 70px 0 78px;
    }

    .class-heading {
        margin-bottom: 22px;
    }

    .class-card-image {
        height: 220px;
    }

    .class-swiper-controls {
        margin-top: 18px;
    }
}

    /* GUESTBOOK */
    #soluubut {
        position: relative;
        padding: 92px 0 86px;
        background: linear-gradient(180deg, #fbf7ef 0%, #f6ead8 100%);
        overflow: hidden;
    }

    #soluubut:before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(6,36,71,.045) 1px, transparent 1px),
            linear-gradient(180deg, rgba(6,36,71,.045) 1px, transparent 1px);
        background-size: 46px 46px;
        pointer-events: none;
    }

    .guestbook-wrap {
        position: relative;
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
    }

    .guestbook-head {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: end;
        gap: 28px;
        margin-bottom: 34px;
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(185,136,67,.18);
    }

    .guestbook-head .section-title {
        margin: 0;
        text-align: left;
    }

    .guestbook-head .section-subtitle {
        max-width: 560px;
        margin: 12px 0 0;
        text-align: left;
    }

    .guestbook-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .guest-card {
        position: relative;
        min-height: 210px;
        padding: 28px;
        overflow: hidden;
        background: rgba(255,255,255,.86);
        border: 1px solid rgba(255,255,255,.86);
        border-radius: 24px;
        box-shadow: 0 20px 45px rgba(6,36,71,.09);
    }

    .guest-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, var(--navy), var(--gold), var(--navy));
        opacity: .8;
    }

    .guest-card .quote {
        color: rgba(185,136,67,.42);
        font-family: Georgia, serif;
        font-size: 54px;
        line-height: .58;
    }

    .guest-card p {
        margin: 12px 0 24px;
        color: #29384a;
        line-height: 1.78;
    }

    .guest-card strong {
        display: inline-flex;
        color: var(--navy);
        font-size: 14px;
        line-height: 1.5;
    }
    [x-cloak] {
    display: none !important;
}

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
    background: rgba(3, 23, 47, .62);
    backdrop-filter: blur(8px);
}

.guestbook-modal-card {
    position: relative;
    z-index: 1;
    width: min(520px, 100%);
    padding: 34px;
    background: #fbf4e8;
    border: 1px solid rgba(185, 136, 67, .26);
    border-radius: 24px;
    box-shadow: 0 28px 80px rgba(0, 0, 0, .28);
}

.guestbook-modal-card h3 {
    margin: 0 0 10px;
    color: var(--navy);
    font-family: "Playfair Display", Georgia, serif;
    font-size: 34px;
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
    border-radius: 50%;
    cursor: pointer;
    color: var(--navy);
    background: rgba(255, 255, 255, .72);
    font-size: 28px;
    line-height: 1;
}

.guestbook-form {
    display: grid;
    gap: 14px;
}

.guestbook-form textarea {
    min-height: 130px;
}

.guestbook-form .full {
    width: 100%;
}
    /* ACTION */
    #action {
        padding: 88px 0 96px;
        background: linear-gradient(180deg, #f6ead8 0%, #fbf7ef 100%);
    }

    #action:before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(185,136,67,.055) 1px, transparent 1px),
            linear-gradient(180deg, rgba(185,136,67,.055) 1px, transparent 1px);
        background-size: 54px 54px;
        pointer-events: none;
    }

    .action-grid {
        position: relative;
        z-index: 1;
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
        padding: 30px;
        overflow: hidden;
        background: rgba(255,252,246,.9);
        border: 1px solid rgba(255,255,255,.86);
        border-radius: 26px;
        box-shadow: 0 22px 55px rgba(6,36,71,.1);
    }

    .action-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, var(--gold), var(--navy));
        opacity: .85;
    }

    .action-card h3 {
        margin: 0 0 10px;
        color: var(--navy);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 28px;
        line-height: 1.15;
    }

    .action-card-desc {
        margin: 0 0 22px;
        color: var(--muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .form-grid .full { grid-column: 1 / -1; }

    input, select, textarea {
        width: 100%;
        min-height: 44px;
        padding: 0 14px;
        color: var(--ink);
        background: rgba(255,255,255,.86);
        border: 1px solid rgba(6,36,71,.16);
        border-radius: 14px;
        outline: none;
        font: inherit;
    }

    textarea {
        min-height: 92px;
        padding-top: 12px;
        resize: vertical;
    }

    input:focus, select:focus, textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 4px rgba(185,136,67,.12);
    }

    .map-box {
        height: 230px;
        overflow: hidden;
        border-radius: 18px;
        border: 1px solid rgba(6,36,71,.12);
        background: #e9e2d8;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,.35);
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
        padding: 14px 0;
        border-bottom: 1px dashed rgba(6,36,71,.18);
        color: var(--muted);
    }

    .contact-list span {
        font-size: 13px;
    }

    .contact-list strong {
        color: var(--navy);
        line-height: 1.5;
    }

    footer {
        position: relative;
        color: rgba(255,255,255,.84);
        background: linear-gradient(180deg, #03172f 0%, #020d1b 100%);
        border-top: 1px solid rgba(215,173,105,.24);
    }

    footer:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(215,173,105,.72), transparent);
    }

    footer .footer-inner {
        position: relative;
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
        min-height: 124px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    footer strong {
        color: var(--gold-2);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 24px;
    }

    footer .footer-inner div div {
        margin-top: 8px;
        color: rgba(255,255,255,.62);
        line-height: 1.6;
    }

    footer p {
        margin: 0;
        color: rgba(255,255,255,.46);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .16em;
        text-transform: uppercase;
    }

    @media (max-width: 1040px) {
        .hero-inner,
        .intro-program-grid,
        .action-grid { grid-template-columns: 1fr; }
        #hero-section_left { min-height: 440px; }
        .class-grid { grid-template-columns: repeat(3, 1fr); }
        .guestbook-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 760px) {
    #hero-section {
        padding-top: 110px;
        min-height: auto;
    }

    .hero-inner {
        gap: 32px;
    }

    #event-date-time {
        grid-template-columns: 1fr;
    }

    #hero-rsvp {
        flex-direction: column;
    }

    .hero-photo.main {
        right: 0;
        width: 82%;
    }

    .hero-photo.second {
        width: 64%;
    }

    .hero-photo.third {
        width: 58%;
    }

    .count-down {
        left: 0;
        grid-template-columns: repeat(4, 1fr);
    }

    .count-down p {
        min-height: 76px;
        font-size: 26px;
    }

    #open-letter,
    #timeline,
    .action-card {
        padding: 26px;
    }

    .program-list li {
        grid-template-columns: 1fr;
        gap: 4px;
    }

    .class-grid,
    .guestbook-grid {
        grid-template-columns: 1fr;
    }

    .guestbook-head {
        align-items: flex-start;
        grid-template-columns: 1fr;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .contact-list li {
        grid-template-columns: 1fr;
        gap: 4px;
    }

    footer .footer-inner {
        flex-direction: column;
        justify-content: center;
        text-align: center;
        padding: 28px 0;
    }
}

    #hero-section {
        min-height: 720px;
        padding: 150px 0 88px;
        background:
            linear-gradient(90deg, rgba(3, 23, 47, .92) 0%, rgba(6, 36, 71, .78) 48%, rgba(6, 36, 71, .34) 100%),
            var(--hero-bg, url('/images/demo/school.jpg')) center / cover no-repeat;
    }

    #hero-section:before {
        inset: 0;
        height: auto;
        background:
            linear-gradient(180deg, rgba(3, 23, 47, .38), rgba(3, 23, 47, 0) 32%),
            linear-gradient(0deg, rgba(3, 23, 47, .64), rgba(3, 23, 47, 0) 48%);
    }

    #hero-section:after {
        left: max(20px, calc((100vw - var(--container)) / 2));
        right: auto;
        top: 118px;
        width: 90px;
        height: 3px;
        background: linear-gradient(90deg, var(--gold-2), rgba(255,255,255,.35));
        border-radius: 999px;
    }

    .hero-inner {
        min-height: 500px;
        grid-template-columns: minmax(0, 760px);
        align-items: center;
        justify-content: start;
    }

    #slogan {
        margin-bottom: 18px;
        color: var(--white);
    }

    #slogan .pretitle {
        color: #f0c879;
        font-size: clamp(34px, 5vw, 62px);
        line-height: 1.05;
        text-shadow: 0 10px 30px rgba(0,0,0,.18);
    }

    #slogan h3 {
        margin-top: 8px;
        color: var(--white);
        font-size: clamp(54px, 8vw, 96px);
        line-height: 1;
        letter-spacing: 0;
        text-transform: none;
        text-shadow: 0 16px 42px rgba(0,0,0,.28);
    }

    #info-event .course-name {
        color: var(--navy-2);
        background: linear-gradient(135deg, #f6d88d, #d7ad69);
        box-shadow: 0 12px 28px rgba(0,0,0,.16);
    }

    #info-event .event-description {
        max-width: 680px;
        color: rgba(255,255,255,.88);
        font-size: 18px;
    }

    #info-event .event-description p {
        margin: 0;
    }

    #event-date-time {
        max-width: 760px;
    }

    #event-date-time p {
        background: rgba(255,255,255,.12);
        border-color: rgba(255,255,255,.2);
        box-shadow: 0 18px 45px rgba(0,0,0,.16);
        backdrop-filter: blur(8px);
    }

    #event-date-time span:first-of-type {
        color: rgba(255,255,255,.68);
    }

    #event-date-time strong {
        color: var(--white);
    }

    #event-date-time i {
        color: var(--navy-2);
        background: #f0c879;
    }

    #hero-rsvp .btn-primary {
        color: var(--navy-2);
        background: linear-gradient(135deg, #f6d88d, #d7ad69);
        box-shadow: 0 16px 36px rgba(0,0,0,.18);
    }

    #hero-rsvp .btn-outline {
        color: var(--white);
        background: rgba(255,255,255,.1);
        border-color: rgba(255,255,255,.26);
    }

    .intro-program-wrap {
        padding-top: 84px;
    }

    .guestbook-head .section-subtitle {
        max-width: 760px;
    }

    @media (max-width: 900px) {
        #hero-section {
            min-height: 680px;
            padding: 126px 0 72px;
        }

        .hero-inner {
            min-height: auto;
        }
    }
    .open-letter-grid,
.timeline-grid {
    grid-template-columns: 1fr;
    max-width: 920px;
}

.open-letter-section {
    padding-bottom: 44px;
}

.timeline-section {
    padding-top: 44px;
}
.event-greeting {
    margin-bottom: 18px;
    color: var(--navy);
    font-size: 17px;
    line-height: 1.7;
}

.event-greeting strong {
    font-weight: 900;
}
.event-greeting {
    margin-bottom: 18px;
    color: var(--navy);
    font-size: 17px;
    line-height: 1.7;
}

.event-greeting strong {
    font-weight: 900;
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
                <div id="slogan">
                    <span class="pretitle">Kính mời</span>
                    <h3>Quý thầy cô</h3>
                </div>

                <div id="info-event">
                    <p class="course-name">{{ $event->course_name }} - {{ $event->school_name }}</p>

                    <div class="event-description">
                        <p>Ban liên lạc trân trọng kính mời quý thầy cô về tham dự ngày hội ngộ, cùng gặp lại học trò cũ và ôn lại những kỷ niệm dưới mái trường thân thương.</p>
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
                            Xác nhận tham dự
                        </a>
                        <a class="btn btn-outline" href="#timeline">Xem chương trình</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- THƯ NGỎ --}}
<section class="intro-program-wrap open-letter-section">
    <div class="corner-flower corner-flower-top-right">
        <img src="{{ asset('images/bang-lang-color.png') }}" alt="Hoa bằng lăng">
    </div>

    <div class="intro-program-grid open-letter-grid">
        <article id="open-letter">
            <h3>Thư ngỏ</h3>
            @if(!empty($event->greeting))
        <div class="event-greeting">
            <strong>{{ $event->greeting }}</strong>
        </div>
    @endif
            <div class="event-thu-ngo">{!! $event->thungo !!}</div>
        </article>
    </div>
</section>

{{-- CHƯƠNG TRÌNH HỘI NGỘ --}}
<section class="intro-program-wrap timeline-section">
    <div class="intro-program-grid timeline-grid">
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
                        <div class="program-content">
                            <strong>Đón tiếp đại biểu & đăng ký</strong>
                            <span>Đón tiếp các bạn, thầy cô và lưu giữ khoảnh khắc đầu tiên.</span>
                        </div>
                    </li>
                    <li>
                        <div class="program-time">08:30 - 09:30</div>
                        <div class="program-content">
                            <strong>Lễ kỷ niệm & chụp ảnh tập thể</strong>
                            <span>Ổn định chương trình, gặp lại thầy cô và bạn bè.</span>
                        </div>
                    </li>
                    <li>
                        <div class="program-time">09:30 - 11:00</div>
                        <div class="program-content">
                            <strong>Giao lưu - Chia sẻ - Kỷ niệm</strong>
                            <span>Cùng ôn lại những câu chuyện đẹp của một thời áo trắng.</span>
                        </div>
                    </li>
                    <li>
                        <div class="program-time">11:00 - 13:30</div>
                        <div class="program-content">
                            <strong>Tiệc trưa thân mật</strong>
                            <span>Bữa cơm họp mặt, kết nối và sẻ chia.</span>
                        </div>
                    </li>
                    <li>
                        <div class="program-time">13:30 - 15:00</div>
                        <div class="program-content">
                            <strong>Giao lưu văn nghệ - Gameshow</strong>
                            <span>Những tiết mục vui vẻ dành cho các lớp.</span>
                        </div>
                    </li>
                    <li>
                        <div class="program-time">15:00 - 16:00</div>
                        <div class="program-content">
                            <strong>Chụp ảnh tự do - Kết thúc</strong>
                            <span>Lưu lại những khoảnh khắc cuối ngày hội ngộ.</span>
                        </div>
                    </li>
                @endforelse
            </ul>
        </article>
    </div>

    <div class="corner-flower corner-flower-bottom-left">
        <img src="{{ asset('images/pen.png') }}" alt="Hoa bằng lăng">
    </div>
</section>

    {{-- SỔ LƯU BÚT --}}
<section id="soluubut" x-data="{ guestbookOpen: false }">
    <div class="guestbook-wrap">
        <div class="guestbook-head">
            <div>
                <h2 class="section-title">Sổ lưu bút</h2>
                <p class="section-subtitle">Những lời nhắn gửi trước ngày gặp lại, để thầy cô và học trò cũ cùng lưu lại một kỷ niệm thật đẹp.</p>
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
                onsubmit="handleTemplate001Guestbook(event)"
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
                <p class="action-card-desc">Kính mong thầy cô gửi thông tin tham dự để ban tổ chức chuẩn bị tiếp đón chu đáo.</p>
                <form action="{{ $rsvpUrl ?? route('reunion.rsvp.store', ['reunion' => $reunion->slug]) }}" method="POST" onsubmit="handleTemplate001Rsvp(event)">
                    @csrf
                    <div class="form-grid">
                        <input name="name" type="text" placeholder="Họ và tên *" required>
                        <input name="class" type="text" placeholder="Lớp từng phụ trách / tổ bộ môn">
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
    function handleTemplate001Rsvp(e) {
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
    function handleTemplate001Guestbook(e) {
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
