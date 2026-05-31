{{-- Template Name: Họp lớp 003 --}}
{{-- Template Type: reunion --}}
@extends('layouts.reunion')

@section('title', $event->title)
@section('meta_title', $event->meta_title)
@section('meta_description', $event->meta_description)
@section('share_image', $event->share_image)
@section('canonical_url', $event->canonical_url ?? url('/' . $event->slug))

@push('styles')
<style>
    :root {
        --container: 1180px;
        --ink: #182126;
        --muted: #687277;
        --paper: #fbf7ee;
        --paper-2: #efe6d6;
        --cream: #fffdf8;
        --moss: #31584b;
        --moss-2: #1f3c35;
        --brick: #a84a36;
        --gold: #c69a48;
        --sky: #dbe8e7;
        --line: rgba(49, 88, 75, .18);
        --shadow: 0 18px 50px rgba(24, 33, 38, .13);
        --radius: 8px;
    }

    * {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        margin: 0;
        color: var(--ink);
        background: var(--paper);
        font-family: "Be Vietnam Pro", "Montserrat", Arial, sans-serif;
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    img {
        display: block;
        max-width: 100%;
    }

    [x-cloak] {
        display: none !important;
    }

    .template-003 {
        overflow: hidden;
        background:
            linear-gradient(90deg, rgba(49, 88, 75, .045) 1px, transparent 1px),
            linear-gradient(180deg, rgba(49, 88, 75, .045) 1px, transparent 1px),
            var(--paper);
        background-size: 52px 52px;
    }

    .container-003 {
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
    }

    .detail-img-003 {
        position: absolute;
        z-index: 0;
        pointer-events: none;
        user-select: none;
        height: auto;
        max-width: none;
    }

    .detail-hero-banglang-003 {
        top: 104px;
        right: -76px;
        width: clamp(190px, 24vw, 350px);
        opacity: .7;
        transform: rotate(8deg);
        filter: drop-shadow(0 18px 28px rgba(24, 33, 38, .16));
    }

    .detail-hero-hoa-003 {
        left: -108px;
        bottom: 38px;
        width: clamp(190px, 23vw, 340px);
        opacity: .5;
        transform: rotate(-14deg);
        filter: drop-shadow(0 16px 26px rgba(24, 33, 38, .14));
    }

    .detail-open-pen-003 {
        right: max(18px, calc(50% - 575px));
        bottom: 12px;
        width: clamp(180px, 22vw, 315px);
        opacity: .42;
        transform: rotate(-8deg);
        filter: drop-shadow(0 18px 24px rgba(24, 33, 38, .16));
    }

    .detail-open-banglang-003 {
        left: max(-86px, calc(50% - 705px));
        top: 30px;
        width: clamp(170px, 20vw, 280px);
        opacity: .42;
        transform: rotate(-14deg);
        filter: drop-shadow(0 15px 22px rgba(24, 33, 38, .12));
    }

    .detail-timeline-phuong-003 {
        left: -78px;
        top: 52px;
        width: clamp(190px, 24vw, 310px);
        opacity: .17;
        transform: rotate(-18deg);
    }

    .detail-timeline-hoa-003 {
        right: -98px;
        bottom: -72px;
        width: clamp(210px, 26vw, 360px);
        opacity: .24;
        transform: rotate(14deg);
        filter: drop-shadow(0 18px 26px rgba(0, 0, 0, .22));
    }

    .detail-memory-hoa-003 {
        right: -74px;
        top: -62px;
        width: clamp(190px, 22vw, 320px);
        opacity: .34;
        transform: rotate(8deg);
    }

    .detail-class-phuong-003 {
        right: -64px;
        top: 38px;
        width: clamp(180px, 22vw, 300px);
        opacity: .16;
        transform: rotate(18deg);
    }

    .detail-action-banglang-003 {
        right: -82px;
        bottom: -64px;
        width: clamp(210px, 26vw, 360px);
        opacity: .42;
        transform: rotate(8deg);
        filter: drop-shadow(0 18px 28px rgba(0, 0, 0, .2));
    }

    .section-head-003 {
        max-width: 760px;
        margin: 0 auto 38px;
        text-align: center;
    }

    .section-kicker-003 {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        color: var(--brick);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0;
    }

    .section-kicker-003:before,
    .section-kicker-003:after {
        content: "";
        width: 36px;
        height: 1px;
        background: var(--gold);
    }

    .section-title {
        margin: 0;
        color: var(--moss-2);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(34px, 4.5vw, 58px);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: 0;
    }

    .section-subtitle {
        max-width: 680px;
        margin: 14px auto 0;
        color: var(--muted);
        line-height: 1.8;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 48px;
        padding: 0 20px;
        border: 1px solid transparent;
        border-radius: var(--radius);
        cursor: pointer;
        font-family: inherit;
        font-weight: 800;
        letter-spacing: 0;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        color: #fff;
        background: var(--moss);
        box-shadow: 0 14px 28px rgba(49, 88, 75, .24);
    }

    .btn-brick {
        color: #fff;
        background: var(--brick);
        box-shadow: 0 14px 28px rgba(168, 74, 54, .23);
    }

    .btn-outline {
        color: var(--moss-2);
        background: rgba(255, 255, 255, .66);
        border-color: rgba(49, 88, 75, .2);
    }

    .reunion-site-header {
        background: rgba(251, 247, 238, .9);
        border-bottom: 1px solid rgba(49, 88, 75, .12);
        backdrop-filter: blur(16px);
    }

    .reunion-site-header:not(.is-scrolled) .reunion-menu a,
    .reunion-menu a {
        color: var(--moss-2);
        letter-spacing: 0;
        text-shadow: none;
    }

    .reunion-menu a:after {
        background: var(--brick);
    }

    .reunion-logo img {
        border-radius: var(--radius);
        background: #fff;
        box-shadow: 0 10px 24px rgba(24, 33, 38, .1);
    }

    #hero-section {
        position: relative;
        min-height: 820px;
        padding: 128px 0 82px;
        background:
            linear-gradient(115deg, rgba(251, 247, 238, .96) 0%, rgba(251, 247, 238, .88) 45%, rgba(219, 232, 231, .72) 100%),
            var(--hero-bg, url('/images/anh-bia.jpg')) center / cover no-repeat;
    }

    #hero-section:before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(24, 33, 38, .05) 1px, transparent 1px),
            linear-gradient(180deg, rgba(24, 33, 38, .05) 1px, transparent 1px);
        background-size: 42px 42px;
        mask-image: linear-gradient(180deg, rgba(0,0,0,.78), transparent 92%);
        pointer-events: none;
    }

    .hero-inner {
        position: relative;
        z-index: 2;
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1.02fr) minmax(360px, .98fr);
        gap: clamp(34px, 6vw, 76px);
        align-items: center;
    }

    .hero-copy-003 {
        min-width: 0;
    }

    .hero-badge-003 {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 24px;
        padding: 9px 12px;
        color: var(--moss-2);
        background: rgba(255, 255, 255, .74);
        border: 1px solid rgba(49, 88, 75, .18);
        border-radius: var(--radius);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0;
        box-shadow: 0 12px 26px rgba(24, 33, 38, .08);
    }

    .hero-badge-003 i {
        color: var(--brick);
    }

    #slogan {
        margin: 0 0 22px;
    }

    #slogan .pretitle,
    #slogan em:first-child {
        display: block;
        color: var(--brick);
        font-family: "Dancing Script", cursive;
        font-size: clamp(46px, 6vw, 78px);
        font-style: normal;
        font-weight: 700;
        line-height: .95;
        letter-spacing: 0;
    }

    #slogan h2,
    #slogan h3,
    #slogan strong {
        display: block;
        max-width: 760px;
        margin: 8px 0 0;
        color: var(--moss-2);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(62px, 8.5vw, 118px);
        font-weight: 900;
        line-height: .92;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    #info-event .course-name {
        display: inline-flex;
        margin: 0 0 16px;
        padding: 8px 12px;
        color: #fff;
        background: var(--brick);
        border-radius: var(--radius);
        font-weight: 800;
        letter-spacing: 0;
    }

    #info-event .event-description {
        max-width: 650px;
        color: #38464b;
        font-size: 17px;
        line-height: 1.85;
    }

    #event-date-time {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        max-width: 700px;
        margin: 28px 0;
    }

    .event-chip-003 {
        min-height: 92px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        background: rgba(255, 255, 255, .76);
        border: 1px solid rgba(49, 88, 75, .16);
        border-radius: var(--radius);
        box-shadow: 0 14px 30px rgba(24, 33, 38, .08);
    }

    .event-chip-003 i {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        color: #fff;
        background: var(--moss);
        border-radius: var(--radius);
    }

    .event-chip-003 span {
        display: block;
        color: var(--muted);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0;
    }

    .event-chip-003 strong {
        display: block;
        margin-top: 5px;
        color: var(--ink);
        font-size: 15px;
        line-height: 1.45;
    }

    #hero-rsvp {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .hero-video-card-003 {
        position: absolute;
        right: 34px;
        bottom: 76px;
        z-index: 4;
        width: min(320px, calc(100% - 68px));
        display: grid;
        grid-template-columns: 92px 1fr;
        gap: 12px;
        align-items: center;
        padding: 10px;
        color: #fff;
        background: rgba(24, 33, 38, .86);
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: var(--radius);
        box-shadow: 0 18px 42px rgba(24, 33, 38, .28);
        backdrop-filter: blur(10px);
    }

    .hero-video-card-003 img {
        width: 92px;
        height: 68px;
        object-fit: cover;
        border-radius: 6px;
    }

    .hero-video-card-003 span {
        display: block;
        color: rgba(255,255,255,.66);
        font-size: 12px;
        font-weight: 800;
    }

    .hero-video-card-003 strong {
        display: block;
        margin-top: 4px;
        color: #fff;
        line-height: 1.35;
    }

    .hero-video-card-003 i {
        margin-left: 8px;
        color: var(--gold);
    }

    .hero-visual-003 {
        position: relative;
        min-width: 0;
        padding: 16px;
        background: rgba(255, 255, 255, .58);
        border: 1px solid rgba(49, 88, 75, .18);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }

    .hero-board-003 {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 12px;
        min-height: 580px;
    }

    .hero-photo-003 {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius);
        background: #d6d0c6;
    }

    .hero-photo-003 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: saturate(1.03) contrast(1.02);
    }

    .hero-photo-main-003 {
        min-height: 580px;
    }

    .hero-photo-side-003 {
        display: grid;
        grid-template-rows: 1fr 1fr;
        gap: 12px;
    }

    .hero-caption-003 {
        position: absolute;
        left: 14px;
        right: 14px;
        bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        color: #fff;
        background: rgba(31, 60, 53, .86);
        border-radius: var(--radius);
        backdrop-filter: blur(10px);
    }

    .hero-caption-003 span {
        font-weight: 800;
        line-height: 1.35;
    }

    .hero-caption-003 i {
        color: var(--gold);
    }

    .count-down {
        position: absolute;
        left: 34px;
        right: 34px;
        bottom: -34px;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        padding: 10px;
        background: var(--moss-2);
        border: 1px solid rgba(198, 154, 72, .45);
        border-radius: var(--radius);
        box-shadow: 0 20px 42px rgba(24, 33, 38, .2);
    }

    .count-down p {
        margin: 0;
        min-height: 72px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: var(--radius);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 30px;
        font-weight: 900;
    }

    .count-down p span:last-child {
        margin-top: 2px;
        color: rgba(255, 255, 255, .66);
        font-family: "Be Vietnam Pro", Arial, sans-serif;
        font-size: 11px;
        font-weight: 800;
    }

    .open-letter-section-003 {
        position: relative;
        padding: 96px 0;
        background:
            linear-gradient(180deg, var(--paper) 0%, #fffdf8 100%);
    }

    .timeline-section-003 {
        position: relative;
        padding: 96px 0;
        color: #fff;
        background:
            linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px),
            linear-gradient(180deg, rgba(255,255,255,.06) 1px, transparent 1px),
            var(--moss-2);
        background-size: 48px 48px;
    }

    .timeline-section-003 .section-title {
        color: #fff;
    }

    .timeline-section-003 .section-subtitle {
        color: rgba(255,255,255,.72);
    }

    .timeline-section-003 .section-kicker-003 {
        color: var(--gold);
    }

    .timeline-section-003 .section-kicker-003:before,
    .timeline-section-003 .section-kicker-003:after {
        background: rgba(198, 154, 72, .76);
    }

    #open-letter,
    #timeline {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }

    #open-letter {
        max-width: 920px;
        margin: 0 auto;
        padding: clamp(30px, 4vw, 50px);
        background:
            linear-gradient(90deg, rgba(49, 88, 75, .08) 1px, transparent 1px),
            linear-gradient(180deg, rgba(49, 88, 75, .08) 1px, transparent 1px),
            #fffdf8;
        background-size: 30px 30px;
        border: 1px solid rgba(49, 88, 75, .16);
    }

    #open-letter:before {
        content: "";
        position: absolute;
        inset: 16px;
        border: 1px solid rgba(198, 154, 72, .28);
        border-radius: var(--radius);
        pointer-events: none;
    }

    #open-letter h3,
    #timeline h3 {
        position: relative;
        margin: 0 0 22px;
        color: var(--moss-2);
        font-family: "Dancing Script", cursive;
        font-size: clamp(48px, 6vw, 76px);
        line-height: 1;
        letter-spacing: 0;
    }

    .event-thu-ngo {
        position: relative;
        color: #303c41;
        font-size: 16px;
        line-height: 1.95;
        white-space: pre-line;
    }

    .letter-sign-003 {
        position: relative;
        margin-top: 28px;
        color: var(--brick);
        font-weight: 900;
    }

    #timeline {
        max-width: 960px;
        margin: 0 auto;
        padding: clamp(28px, 4vw, 44px);
        color: #fff;
        background:
            linear-gradient(135deg, rgba(31, 60, 53, .97), rgba(49, 88, 75, .96)),
            url('/images/back-ground-1.png') center / cover no-repeat;
        border: 1px solid rgba(198, 154, 72, .25);
    }

    #timeline h3 {
        color: #fff;
    }

    .program-list {
        position: relative;
        margin: 0;
        padding: 0;
        display: grid;
        gap: 12px;
        list-style: none;
    }

    .program-list li {
        display: grid;
        grid-template-columns: 120px 1fr;
        gap: 16px;
        padding: 16px;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: var(--radius);
    }

    .program-time {
        color: var(--gold);
        font-weight: 900;
        line-height: 1.45;
    }

    .program-content strong {
        display: block;
        margin-bottom: 4px;
        color: #fff;
        font-size: 16px;
        line-height: 1.45;
    }

    .program-content span {
        color: rgba(255, 255, 255, .74);
        font-size: 14px;
        line-height: 1.65;
    }

    .memory-strip-003 {
        position: relative;
        overflow: hidden;
        padding: 0 0 96px;
        background: #fffdf8;
    }

    .memory-strip-003 .container-003,
    #action .container-003 {
        position: relative;
        z-index: 1;
    }

    .memory-grid-003 {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .memory-card-003 {
        min-height: 154px;
        padding: 24px;
        background: #fff;
        border: 1px solid rgba(49, 88, 75, .14);
        border-radius: var(--radius);
        box-shadow: 0 14px 34px rgba(24, 33, 38, .08);
    }

    .memory-card-003 i {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: var(--brick);
        border-radius: var(--radius);
    }

    .memory-card-003 span {
        display: block;
        margin-top: 18px;
        color: var(--muted);
        font-size: 13px;
        font-weight: 800;
    }

    .memory-card-003 strong {
        display: block;
        margin-top: 6px;
        color: var(--moss-2);
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(24px, 3vw, 34px);
        line-height: 1.1;
    }

    #slide-class {
        position: relative;
        overflow: hidden;
        padding: 94px 0 104px;
        color: #fff;
        background:
            linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px),
            linear-gradient(180deg, rgba(255,255,255,.07) 1px, transparent 1px),
            var(--moss-2);
        background-size: 48px 48px;
    }

    .slide-class-inner {
        position: relative;
        z-index: 1;
    }

    .class-heading {
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto 34px;
        text-align: center;
    }

    .class-heading span {
        display: inline-flex;
        margin-bottom: 12px;
        padding: 8px 12px;
        color: var(--gold);
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(198, 154, 72, .32);
        border-radius: var(--radius);
        font-size: 13px;
        font-weight: 800;
    }

    .class-heading .section-title {
        color: #fff;
    }

    .class-heading p {
        max-width: 660px;
        margin: 14px auto 0;
        color: rgba(255, 255, 255, .72);
        line-height: 1.75;
    }

    .album-shell-003 {
        position: relative;
        z-index: 2;
        width: 100%;
    }

    .album-masonry-wrap-003 {
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
    }

    .album-masonry-meta-003 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
        color: rgba(255,255,255,.68);
        font-size: 13px;
        font-weight: 800;
    }

    .album-masonry-meta-003 strong {
        color: var(--gold);
    }

    .album-masonry-grid-003 {
        column-count: 4;
        column-gap: 14px;
    }

    .album-masonry-item-003 {
        position: relative;
        display: block;
        margin: 0 0 14px;
        overflow: hidden;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.14);
        border-radius: var(--radius);
        box-shadow: 0 18px 42px rgba(0,0,0,.22);
        break-inside: avoid;
        transform: translateZ(0);
    }

    .album-masonry-item-003 img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform .45s ease, filter .45s ease;
    }

    .album-masonry-item-003:hover img {
        transform: scale(1.04);
        filter: saturate(1.08);
    }

    .album-masonry-item-003 span {
        position: absolute;
        left: 10px;
        right: 10px;
        bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 9px 10px;
        color: #fff;
        background: rgba(31, 60, 53, .82);
        border-radius: 6px;
        opacity: 0;
        transform: translateY(8px);
        transition: opacity .2s ease, transform .2s ease;
        backdrop-filter: blur(8px);
        font-size: 12px;
        font-weight: 800;
    }

    .album-masonry-item-003:hover span {
        opacity: 1;
        transform: translateY(0);
    }

    .album-empty-003 {
        width: min(760px, calc(100% - 40px));
        margin: 0 auto;
        padding: 26px;
        color: rgba(255,255,255,.72);
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.14);
        border-radius: var(--radius);
        text-align: center;
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
        background: rgba(255,255,255,.09);
        border: 1px solid rgba(255,255,255,.16);
        border-radius: var(--radius);
        box-shadow: 0 22px 50px rgba(0,0,0,.26);
        transition: transform .25s ease, border-color .25s ease;
    }

    .class-card-slider:hover {
        transform: translateY(-7px);
        border-color: rgba(198, 154, 72, .8);
    }

    .class-card-image {
        position: relative;
        display: block;
        height: 250px;
        overflow: hidden;
        background: rgba(255,255,255,.08);
    }

    .class-card-image:after {
        content: "";
        position: absolute;
        inset: auto 0 0 0;
        height: 46%;
        background: linear-gradient(180deg, transparent, rgba(31, 60, 53, .84));
        pointer-events: none;
    }

    .class-card-slider img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .45s ease;
    }

    .class-card-slider:hover img {
        transform: scale(1.06);
    }

    .class-card-body {
        padding: 18px 20px 22px;
        text-align: center;
    }

    .class-card-body h4 {
        margin: 0 0 8px;
        color: var(--gold);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 32px;
        line-height: 1.1;
    }

    .class-card-body a,
    .class-card-body button,
    .class-card-body span {
        display: inline-flex;
        padding: 0;
        border: 0;
        color: rgba(255, 255, 255, .82);
        background: transparent;
        font-family: inherit;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
    }

    .class-swiper-controls {
        width: min(var(--container), calc(100% - 40px));
        margin: 24px auto 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
    }

    .class-swiper-prev,
    .class-swiper-next {
        width: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--moss-2);
        background: var(--gold);
        border: 0;
        border-radius: var(--radius);
        cursor: pointer;
        box-shadow: 0 14px 28px rgba(0,0,0,.18);
        transition: transform .2s ease;
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
        background: rgba(255,255,255,.38);
        opacity: 1;
    }

    .class-swiper-pagination .swiper-pagination-bullet-active {
        width: 24px;
        border-radius: var(--radius);
        background: var(--gold);
    }

    #action {
        position: relative;
        overflow: hidden;
        padding: 98px 0;
        color: #fff;
        background:
            linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px),
            linear-gradient(180deg, rgba(255,255,255,.06) 1px, transparent 1px),
            linear-gradient(135deg, var(--moss-2), #17302c 68%, #4b251e);
        background-size: 48px 48px, 48px 48px, auto;
    }

    .action-head-003 {
        max-width: 720px;
        margin-bottom: 34px;
    }

    .action-head-003 span {
        color: var(--gold);
        font-weight: 900;
    }

    .action-head-003 h2 {
        margin: 10px 0 12px;
        font-family: "Playfair Display", Georgia, serif;
        font-size: clamp(34px, 4.4vw, 56px);
        line-height: 1.05;
    }

    .action-head-003 p {
        margin: 0;
        color: rgba(255,255,255,.72);
        line-height: 1.75;
    }

    .action-grid-003 {
        display: grid;
        grid-template-columns: minmax(0, .98fr) minmax(320px, .72fr);
        gap: 18px;
        align-items: start;
    }

    .rsvp-panel-003,
    .map-panel-003,
    .contact-panel-003 {
        padding: 24px;
        background: rgba(255, 255, 255, .09);
        border: 1px solid rgba(255,255,255,.16);
        border-radius: var(--radius);
        box-shadow: 0 22px 55px rgba(0,0,0,.22);
        backdrop-filter: blur(12px);
    }

    .rsvp-panel-003 h3,
    .map-panel-003 h3,
    .contact-panel-003 h3 {
        margin: 0 0 10px;
        color: #fff;
        font-family: "Playfair Display", Georgia, serif;
        font-size: 31px;
        line-height: 1.1;
    }

    .action-card-desc {
        margin: 0 0 20px;
        color: rgba(255,255,255,.7);
        line-height: 1.7;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .field-003 {
        display: grid;
        gap: 7px;
    }

    .field-003.full,
    .form-grid .full {
        grid-column: 1 / -1;
    }

    .field-003 label {
        color: rgba(255,255,255,.74);
        font-size: 13px;
        font-weight: 800;
    }

    input,
    select,
    textarea {
        width: 100%;
        border: 1px solid rgba(49, 88, 75, .18);
        border-radius: var(--radius);
        background: rgba(255,255,255,.96);
        color: var(--ink);
        font: inherit;
        outline: none;
    }

    input,
    select {
        height: 48px;
        padding: 0 14px;
    }

    textarea {
        min-height: 118px;
        padding: 13px 14px;
        resize: vertical;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(198, 154, 72, .18);
    }

    .action-side-003 {
        display: grid;
        gap: 18px;
    }

    .map-content-003 p {
        margin: 0 0 16px;
        color: rgba(255,255,255,.72);
        line-height: 1.65;
    }

    .map-box {
        min-height: 284px;
        overflow: hidden;
        background: #d6d0c6;
        border-radius: var(--radius);
    }

    .map-box iframe {
        width: 100%;
        height: 100%;
        min-height: 284px;
        border: 0;
    }

    .contact-list {
        margin: 0;
        padding: 0;
        display: grid;
        gap: 10px;
        list-style: none;
    }

    .contact-list li {
        display: grid;
        gap: 5px;
        padding: 14px;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.12);
        border-radius: var(--radius);
    }

    .contact-list span {
        color: var(--gold);
        font-size: 12px;
        font-weight: 900;
    }

    .contact-list strong {
        color: #fff;
        line-height: 1.45;
    }

    footer {
        padding: 28px 0;
        color: rgba(255,255,255,.74);
        background: #132623;
    }

    .footer-inner {
        width: min(var(--container), calc(100% - 40px));
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        line-height: 1.6;
    }

    .footer-inner strong {
        display: block;
        color: #fff;
    }

    .footer-inner p {
        margin: 0;
        white-space: nowrap;
    }

    @media (max-width: 1080px) {
        .hero-inner,
        .action-grid-003 {
            grid-template-columns: 1fr;
        }

        .hero-visual-003 {
            max-width: 760px;
        }
    }

    @media (max-width: 820px) {
        .detail-hero-banglang-003,
        .detail-hero-hoa-003,
        .detail-open-banglang-003,
        .detail-timeline-hoa-003,
        .detail-action-banglang-003 {
            opacity: .18;
        }

        .detail-open-pen-003,
        .detail-memory-hoa-003,
        .detail-class-phuong-003 {
            display: none;
        }

        #hero-section {
            min-height: auto;
            padding: 104px 0 84px;
        }

        #event-date-time,
        .memory-grid-003,
        .form-grid {
            grid-template-columns: 1fr;
        }

        .hero-board-003 {
            min-height: auto;
            grid-template-columns: 1fr;
        }

        .hero-photo-main-003 {
            min-height: 420px;
        }

        .hero-photo-side-003 {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto;
        }

        .hero-photo-side-003 .hero-photo-003 {
            min-height: 190px;
        }

        .count-down {
            position: relative;
            left: auto;
            right: auto;
            bottom: auto;
            margin-top: 12px;
        }

        .hero-video-card-003 {
            position: relative;
            right: auto;
            bottom: auto;
            width: 100%;
            margin-top: 12px;
        }

        .program-list li {
            grid-template-columns: 1fr;
        }

        .album-masonry-grid-003 {
            column-count: 2;
        }

    }

    @media (max-width: 640px) {
        .container-003,
        .hero-inner,
        .class-heading,
        .class-swiper-controls,
        .album-masonry-wrap-003,
        .footer-inner {
            width: min(var(--container), calc(100% - 24px));
        }

        #slogan h2,
        #slogan h3,
        #slogan strong {
            font-size: clamp(48px, 16vw, 72px);
        }

        .hero-photo-main-003 {
            min-height: 330px;
        }

        .hero-photo-side-003 {
            grid-template-columns: 1fr;
        }

        .count-down {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .open-letter-section-003,
        .timeline-section-003,
        #action,
        #slide-class {
            padding: 76px 0;
        }

        .memory-strip-003 {
            padding-bottom: 76px;
        }

        .footer-inner {
            display: grid;
        }

        .footer-inner p {
            white-space: normal;
        }

        .album-masonry-grid-003 {
            column-count: 1;
        }
    }
</style>
@endpush

@section('content')
@php
    $heroImage = $event->hero_image ?? $event->background ?? asset('images/anh-bia.jpg');
    $heroPhotoOne = $event->hero_photo_1 ?? $heroImage;
    $heroPhotoTwo = $event->hero_photo_2 ?? asset('images/20-nam-tro-ve-thanh-xuan.png');
    $heroPhotoThree = $event->hero_photo_3 ?? asset('images/save-the-date.png');
    $videoUrl = $event->video_url ?? null;
    $videoCover = !empty($event->video_cover) ? $event->video_cover : $heroPhotoThree;
    $albumPhotos = collect($event->album_photos ?? [])->filter(fn ($photo) => !empty($photo->url))->take(100);
    $hasMasonryPhotos = $albumPhotos->isNotEmpty();
    $useMasonryAlbum = (bool) ($event->album_masonry_enabled ?? true);
@endphp

<div class="template-003">
    <header id="site-header" class="reunion-site-header">
        <div id="header" class="reunion-header-inner">
            <a id="logo" class="reunion-logo" href="#hero-section" aria-label="Trang chủ">
                <img src="{{ $event->logo ?: asset('images/favicon.png') }}" alt="{{ $event->title }}">
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
                    <li><a href="#slide-class">Album</a></li>
                    <li><a href="#action">Xác nhận</a></li>
                    <li><a href="#contact">Liên hệ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section id="hero-section" style="--hero-bg: url('{{ $heroImage }}')">
            <img class="detail-img-003 detail-hero-banglang-003" src="{{ asset('images/bang-lang-color.png') }}" alt="" aria-hidden="true">
            <img class="detail-img-003 detail-hero-hoa-003" src="{{ asset('images/hoa-1.png') }}" alt="" aria-hidden="true">

            <div class="hero-inner">
                <div class="hero-copy-003">
                    <div class="hero-badge-003">
                        <i class="fa fa-school"></i>
                        Ngày trở về dưới mái trường xưa
                    </div>

                    <div id="slogan">
                        {!! $event->slogan ?? '<span class="pretitle">Hẹn ngày</span><h2>Trở về</h2>' !!}
                    </div>

                    <div id="info-event">
                        <p class="course-name">{{ $event->course_name }} - {{ $event->school_name }}</p>

                        <div class="event-description">
                            {!! $event->description !!}
                        </div>

                        <div id="event-date-time">
                            <div class="event-chip-003">
                                <i class="fa fa-calendar-days"></i>
                                <div>
                                    <span>Ngày hội ngộ</span>
                                    <strong>{{ $event->time ?? 'Đang cập nhật' }}</strong>
                                </div>
                            </div>

                            <div class="event-chip-003">
                                <i class="fa fa-location-dot"></i>
                                <div>
                                    <span>Địa điểm</span>
                                    <strong>{{ $event->address ?? 'Đang cập nhật' }}</strong>
                                </div>
                            </div>
                        </div>

                        <div id="hero-rsvp">
                            <a class="btn btn-primary" href="#action">
                                <i class="fa fa-paper-plane"></i>
                                Xác nhận tham dự
                            </a>
                            <a class="btn btn-outline" href="#timeline">
                                <i class="fa fa-list-check"></i>
                                Xem chương trình
                            </a>
                            @if($videoUrl)
                                <a class="btn btn-brick glightbox-video" href="{{ $videoUrl }}">
                                    <i class="fa fa-circle-play"></i>
                                    Xem video
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="hero-visual-003">
                    <div class="hero-board-003">
                        <figure class="hero-photo-003 hero-photo-main-003">
                            <img src="{{ $heroImage }}" alt="{{ $event->title }}">
                            <figcaption class="hero-caption-003">
                                <span>{{ $event->course_name }}</span>
                                <i class="fa fa-camera-retro"></i>
                            </figcaption>
                        </figure>

                        <div class="hero-photo-side-003">
                            <figure class="hero-photo-003">
                                <img src="{{ $heroPhotoOne }}" alt="Ảnh kỷ niệm {{ $event->title }}">
                            </figure>
                            <figure class="hero-photo-003">
                                <img src="{{ $heroPhotoTwo }}" alt="Kỷ niệm ngày trở về">
                            </figure>
                        </div>
                    </div>

                    @if($videoUrl)
                        <a class="hero-video-card-003 glightbox-video" href="{{ $videoUrl }}">
                            <img src="{{ $videoCover }}" alt="Video kỷ niệm {{ $event->title }}">
                            <span>
                                Video kỷ niệm
                                <strong>Xem khoảnh khắc ngày trở về <i class="fa fa-circle-play"></i></strong>
                            </span>
                        </a>
                    @endif

                    <div class="count-down">
                        <p><span id="day">00</span><span>Ngày</span></p>
                        <p><span id="hours">00</span><span>Giờ</span></p>
                        <p><span id="min">00</span><span>Phút</span></p>
                        <p><span id="second">00</span><span>Giây</span></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="open-letter-section-003">
            <img class="detail-img-003 detail-open-banglang-003" src="{{ asset('images/bang-lang-color.png') }}" alt="" aria-hidden="true">
            <img class="detail-img-003 detail-open-pen-003" src="{{ asset('images/pen.png') }}" alt="" aria-hidden="true">

            <div class="container-003">
                <article id="open-letter">
                    <h3>Thư ngỏ</h3>
                    @if(!empty($event->greeting))
                        <div class="letter-sign-003">{{ $event->greeting }}</div>
                    @endif
                    <div class="event-thu-ngo">{!! nl2br(e($event->thungo)) !!}</div>
                    <div class="letter-sign-003">Ban tổ chức trân trọng kính mời</div>
                </article>
            </div>
        </section>

        <section class="timeline-section-003">
            <img class="detail-img-003 detail-timeline-phuong-003" src="{{ asset('images/phuong-1.png') }}" alt="" aria-hidden="true">
            <img class="detail-img-003 detail-timeline-hoa-003" src="{{ asset('images/hoa-1.png') }}" alt="" aria-hidden="true">

            <div class="container-003">
                <div class="section-head-003">
                    <div class="section-kicker-003">Lịch trình</div>
                    <h2 class="section-title">Chương trình hội ngộ</h2>
                    <p class="section-subtitle">Các mốc chính trong ngày trở về để mọi người cùng sắp xếp thời gian tham dự trọn vẹn.</p>
                </div>

                <article id="timeline">
                    <h3>Chương trình</h3>
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
        </section>

        <section class="memory-strip-003">
            <img class="detail-img-003 detail-memory-hoa-003" src="{{ asset('images/hoa-1.png') }}" alt="" aria-hidden="true">

            <div class="container-003">
                <div class="memory-grid-003">
                    <div class="memory-card-003">
                        <i class="fa fa-clock"></i>
                        <span>Thời gian</span>
                        <strong>{{ $event->time ?? 'Đang cập nhật' }}</strong>
                    </div>

                    <div class="memory-card-003">
                        <i class="fa fa-location-dot"></i>
                        <span>Địa điểm</span>
                        <strong>{{ $event->school_name }}</strong>
                    </div>

                    <div class="memory-card-003">
                        <i class="fa fa-users"></i>
                        <span>Niên khóa</span>
                        <strong>{{ $event->course_name }}</strong>
                    </div>
                </div>
            </div>
        </section>

        <section id="slide-class" class="relative overflow-hidden">
            <img class="detail-img-003 detail-class-phuong-003" src="{{ asset('images/phuong-1.png') }}" alt="" aria-hidden="true">

            <div class="slide-class-inner">
                <div class="class-heading">
                    <span>Album kỷ niệm</span>
                    <h2 class="section-title">Album ảnh</h2>
                    <p>{{ $useMasonryAlbum ? 'Album ảnh chung hiển thị dạng masonry, tối đa 100 ảnh.' : 'Cùng nhìn lại những gương mặt thân quen theo từng album lớp.' }}</p>
                </div>

                <div class="album-shell-003">
                    @if($useMasonryAlbum)
                        @if($hasMasonryPhotos)
                            <div class="album-masonry-wrap-003">
                                <div class="album-masonry-meta-003">
                                    <span>Album ảnh chung</span>
                                    <strong>{{ $albumPhotos->count() }} / 100 ảnh</strong>
                                </div>

                                <div class="album-masonry-grid-003">
                                    @foreach($albumPhotos as $photo)
                                        <a
                                            href="{{ $photo->url }}"
                                            class="album-masonry-item-003 glightbox-gallery"
                                            data-gallery="template-003-masonry"
                                            data-glightbox="title: {{ $photo->title ?? 'Ảnh kỷ niệm' }}"
                                        >
                                            <img src="{{ $photo->thumb ?? $photo->url }}" alt="{{ $photo->title ?? 'Ảnh kỷ niệm' }}" loading="lazy">
                                            <span>
                                                {{ $photo->title ?? 'Ảnh kỷ niệm' }}
                                                <i class="fa fa-up-right-and-down-left-from-center"></i>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="album-empty-003">
                                Album masonry sẽ hiển thị khi có ảnh trong gallery hoặc album ảnh.
                            </div>
                        @endif
                    @else
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
                                                        <img src="{{ asset('images/anh-bia.jpg') }}" alt="Lớp {{ $className }}">
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
                    @endif
                </div>
            </div>
        </section>

        <section id="action">
            <img class="detail-img-003 detail-action-banglang-003" src="{{ asset('images/bang-lang-color.png') }}" alt="" aria-hidden="true">

            <div class="container-003">
                <div class="action-head-003">
                    <span>Tham dự ngày hội ngộ</span>
                    <h2>Xác nhận & thông tin sự kiện</h2>
                    <p>Gửi xác nhận tham dự, lưu lại địa điểm và liên hệ ban tổ chức khi cần hỗ trợ.</p>
                </div>

                <div class="action-grid-003">
                    <div id="rsvp" class="rsvp-panel-003">
                        <h3>Xác nhận tham dự</h3>
                        <p class="action-card-desc">Gửi thông tin tham dự để ban tổ chức chuẩn bị chỗ ngồi, tiệc và liên hệ khi cần.</p>

                        <form
                            action="{{ $rsvpUrl ?? route('reunion.rsvp.store', ['reunion' => $reunion->slug]) }}"
                            method="POST"
                            onsubmit="handleTemplate003Rsvp(event)"
                        >
                            @csrf

                            <div class="form-grid">
                                <div class="field-003">
                                    <label>Họ và tên</label>
                                    <input name="name" type="text" placeholder="Nhập họ và tên *" required>
                                </div>

                                <div class="field-003">
                                    <label>Lớp</label>
                                    <select name="class" required>
                                        <option value="">Chọn lớp *</option>
                                        @forelse(($event->classes ?? []) as $class)
                                            <option value="{{ $class->name }}">{{ $class->name }}</option>
                                        @empty
                                            <option>12A</option>
                                            <option>12B</option>
                                            <option>12C</option>
                                            <option>12D</option>
                                            <option>12E</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="field-003">
                                    <label>Số điện thoại</label>
                                    <input name="phone" type="tel" placeholder="Số điện thoại *" required>
                                </div>

                                <div class="field-003">
                                    <label>Số người tham dự</label>
                                    <input name="guest_count" type="number" min="1" placeholder="VD: 1">
                                </div>

                                <div class="field-003 full">
                                    <label>Lời nhắn</label>
                                    <textarea name="note" placeholder="Lời nhắn nếu có"></textarea>
                                </div>

                                <button class="btn btn-brick full" type="submit">
                                    <i class="fa fa-paper-plane"></i>
                                    Gửi xác nhận tham dự
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="action-side-003">
                        <div id="event-map" class="map-panel-003">
                            <div class="map-content-003">
                                <h3>{{ $event->school_name }}</h3>
                                <p>{{ $event->address }}</p>
                            </div>

                            <div class="map-box">
                                {!! $event->map_embed ?? '<iframe loading="lazy" src="https://www.google.com/maps?q=Tr%C6%B0%E1%BB%9Dng%20THPT%20Qu%E1%BA%BF%20V%C3%B5%201&output=embed"></iframe>' !!}
                            </div>
                        </div>

                        <div id="contact" class="contact-panel-003">
                            <h3>Ban tổ chức</h3>
                            <p class="action-card-desc">Cần hỗ trợ về lịch trình, địa điểm hoặc thông tin lớp, anh chị có thể liên hệ trực tiếp.</p>

                            <ul class="contact-list">
                                @forelse(($event->contacts ?? []) as $contact)
                                    <li>
                                        <span>{{ $contact->role }}</span>
                                        <strong>{{ $contact->name }} - {{ $contact->phone }}</strong>
                                    </li>
                                @empty
                                    <li>
                                        <span>Trưởng ban</span>
                                        <strong>Nguyễn Văn Hòa - 0986 123 456</strong>
                                    </li>
                                    <li>
                                        <span>Phó ban</span>
                                        <strong>Phạm Thị Lan - 0912 345 678</strong>
                                    </li>
                                    <li>
                                        <span>Thư ký</span>
                                        <strong>Trần Quang Minh - 0978 765 432</strong>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
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
</div>
@endsection

@push('scripts')
<script>
    function submitTemplate003Form(form, successTitle, successText, defaultError, reloadOnSuccess) {
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
                    throw new Error(payload.message || defaultError);
                }

                return response.json();
            })
            .then(() => {
                form.reset();

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: successTitle,
                        text: successText,
                        icon: 'success',
                        confirmButtonText: 'Đóng'
                    }).then(() => {
                        if (reloadOnSuccess) {
                            window.location.reload();
                        }
                    });
                } else {
                    alert(successTitle);

                    if (reloadOnSuccess) {
                        window.location.reload();
                    }
                }
            })
            .catch(error => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Chưa gửi được',
                        text: error.message,
                        icon: 'error',
                        confirmButtonText: 'Đóng'
                    });
                } else {
                    alert(error.message);
                }
            })
            .finally(() => {
                if (button) {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            });
    }

    function handleTemplate003Rsvp(e) {
        e.preventDefault();

        submitTemplate003Form(
            e.target,
            'Đã nhận xác nhận!',
            'Cảm ơn bạn đã gửi thông tin tham dự.',
            'Không gửi được xác nhận.',
            false
        );
    }

    (function () {
        const eventDate = new Date("{{ $event->countdown_time }}").getTime();
        const dayEl = document.getElementById('day');
        const hoursEl = document.getElementById('hours');
        const minEl = document.getElementById('min');
        const secondEl = document.getElementById('second');

        if (!Number.isFinite(eventDate)) {
            return;
        }

        function pad(num) {
            return String(num).padStart(2, '0');
        }

        function updateCountdown() {
            const distance = Math.max(eventDate - Date.now(), 0);
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((distance / (1000 * 60)) % 60);
            const seconds = Math.floor((distance / 1000) % 60);

            if (dayEl) dayEl.textContent = pad(days);
            if (hoursEl) hoursEl.textContent = pad(hours);
            if (minEl) minEl.textContent = pad(minutes);
            if (secondEl) secondEl.textContent = pad(seconds);
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
</script>
@endpush
