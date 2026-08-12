{{-- Template Name: Hội ngộ - Ký ức dựng xây --}}
{{-- Type: gathering --}}
@php
    $milestoneImage = $event->gallery->get(0);
    $teamImage = $event->gallery->get(1);
    $additionalMemories = $event->gallery->slice(2);
@endphp
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $event->meta_description }}">
    <meta property="og:title" content="{{ $event->meta_title }}">
    <meta property="og:description" content="{{ $event->meta_description }}">
    <meta property="og:url" content="{{ $event->url }}">
    @if($event->share_image)<meta property="og:image" content="{{ $event->share_image }}">@endif
    <title>{{ $event->meta_title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
    <style>
        :root { --navy:#061d3d; --blue:#0d65b6; --sky:#78b9e5; --ink:#112235; --muted:#607080; --paper:#f6f8fa; --line:#dce4ea; --white:#fff; }
        * { box-sizing:border-box; }
        html { scroll-behavior:smooth; }
        body { margin:0; color:var(--ink); background:var(--paper); font-family:"Be Vietnam Pro",sans-serif; }
        a { color:inherit; }
        .container { width:min(1120px,calc(100% - 32px)); margin:0 auto; }
        .hero { position:relative; isolation:isolate; overflow:hidden; color:#fff; background:var(--navy); }
        .hero-grid { display:grid; grid-template-columns:minmax(0,1fr) minmax(420px,.9fr); min-height:610px; }
        .hero-copy { display:flex; position:relative; z-index:1; flex-direction:column; justify-content:center; padding:76px max(24px,calc((100vw - 1120px) / 2)) 76px max(24px,calc((100vw - 1120px) / 2)); }
        .hero-photo { position:relative; overflow:hidden; min-height:420px; background:#0b2d55; }
        .hero-cover { width:100%; height:100%; object-fit:cover; object-position:center; }
        .hero-photo:after { position:absolute; inset:0; content:""; background:linear-gradient(90deg,rgba(6,29,61,.45),transparent 38%),linear-gradient(0deg,rgba(4,23,48,.48),transparent 48%); }
        .hero-photo-label { position:absolute; z-index:1; right:32px; bottom:29px; max-width:290px; padding-left:18px; border-left:2px solid #8ed1f5; color:#e9f7ff; font-size:.83rem; line-height:1.65; }
        .hero-photo-label b { display:block; margin-bottom:3px; color:#9bd5f6; font-size:.68rem; letter-spacing:.14em; text-transform:uppercase; }
        .orbit { position:absolute; z-index:-1; border:1px solid rgba(144,202,243,.24); border-radius:50%; pointer-events:none; }
        .orbit.one { top:-190px; left:-220px; width:570px; height:570px; }
        .orbit.two { bottom:-180px; left:120px; width:410px; height:410px; border-color:rgba(144,202,243,.13); }
        .kicker { display:flex; align-items:center; gap:12px; margin:0 0 24px; color:#a9d6f5; font-size:.75rem; font-weight:800; letter-spacing:.17em; text-transform:uppercase; }
        .kicker:before { width:42px; height:2px; content:""; background:#51a9df; }
        h1,h2 { font-family:"Playfair Display",serif; }
        h1 { max-width:560px; margin:0; font-size:clamp(2.05rem,4vw,3.65rem); font-weight:600; line-height:1.04; letter-spacing:-.04em; }
        .hero-title { display:block; margin-top:14px; color:#bce7ff; font-family:"Be Vietnam Pro",sans-serif; font-size:clamp(.85rem,1.25vw,1rem); font-weight:700; letter-spacing:.02em; line-height:1.55; }
        .hero-bottom { display:flex; align-items:end; justify-content:space-between; gap:24px; margin-top:36px; }
        .hero-note { max-width:570px; margin:0; color:rgba(235,247,255,.84); font-size:.92rem; line-height:1.75; }
        .guest-chip { display:inline-flex; align-items:center; min-height:42px; padding:0 17px; border:1px solid rgba(187,231,255,.42); border-radius:999px; color:#e6f5ff; background:rgba(5,34,69,.5); font-size:.92rem; font-weight:700; backdrop-filter:blur(10px); white-space:nowrap; }
        .timeline { display:grid; grid-template-columns:1fr 1fr; border:1px solid var(--line); border-top:0; background:#fff; }
        .timeline-item { position:relative; min-height:170px; padding:31px clamp(24px,5vw,62px); }
        .timeline-item + .timeline-item { border-left:1px solid var(--line); }
        .timeline-item:before { position:absolute; top:0; left:0; width:100%; height:4px; content:""; background:var(--blue); }
        .timeline-item:last-child:before { background:#89c8ee; }
        .timeline-year { display:block; color:var(--blue); font-size:.78rem; font-weight:800; letter-spacing:.16em; }
        .timeline-item h2 { margin:9px 0 0; font-size:clamp(1.55rem,3vw,2.25rem); line-height:1.1; }
        .timeline-item p { max-width:440px; margin:12px 0 0; color:var(--muted); font-size:.93rem; line-height:1.7; }
        .appointment { display:grid; grid-template-columns:.74fr 1.26fr; margin-top:44px; overflow:hidden; background:#fff; box-shadow:0 18px 44px rgba(14,35,57,.08); }
        .appointment-title { display:flex; flex-direction:column; justify-content:space-between; min-height:255px; padding:34px; color:#eff9ff; background:linear-gradient(145deg,#062349,#0b5a9f); }
        .appointment-title p { margin:0; color:#9bd5f6; font-size:.72rem; font-weight:800; letter-spacing:.16em; text-transform:uppercase; }
        .appointment-title h2 { margin:13px 0 0; color:#fff; font-size:clamp(1.5rem,2.5vw,2.2rem); line-height:1.12; letter-spacing:-.035em; }
        .appointment-title span { color:rgba(239,249,255,.76); font-size:.9rem; line-height:1.65; }
        .appointment-details { display:grid; grid-template-columns:repeat(3,1fr); }
        .appointment-item { display:flex; flex-direction:column; justify-content:center; min-height:255px; padding:32px; border-left:1px solid var(--line); }
        .appointment-item small { margin-bottom:13px; color:var(--blue); font-size:.7rem; font-weight:800; letter-spacing:.13em; text-transform:uppercase; }
        .appointment-item strong { font-size:1.08rem; line-height:1.6; }
        .appointment-item span { margin-top:8px; color:var(--muted); font-size:.9rem; line-height:1.65; }
        .invite-letter { display:grid; grid-template-columns:minmax(0,1fr) minmax(270px,.72fr); gap:44px; margin-top:76px; padding:clamp(34px,6vw,75px); color:#17314d; border:1px solid #c9d9e5; background:linear-gradient(150deg,#fafdff,#e9f5fc); }
        .invite-letter h2 { margin:0; font-size:clamp(1.6rem,2.9vw,2.4rem); line-height:1.12; letter-spacing:-.035em; }
        .invite-letter .formal-greeting { margin:0 0 18px; color:var(--blue); font-size:.73rem; font-weight:800; letter-spacing:.18em; text-transform:uppercase; }
        .invite-copy { max-width:650px; color:#536879; line-height:1.9; }
        .invite-copy p:first-child { margin-top:0; }
        .invite-aside { align-self:center; padding:26px; border-left:2px solid #4a9ed3; color:#466277; font-size:.95rem; font-style:italic; line-height:1.8; }
        main { padding:62px 0 76px; }
        .section-label { margin:0 0 13px; color:var(--blue); font-size:.73rem; font-weight:800; letter-spacing:.18em; text-transform:uppercase; }
        .section-heading { max-width:650px; margin:0; font-size:clamp(1.5rem,2.6vw,2.25rem); font-weight:600; line-height:1.15; letter-spacing:-.035em; }
        .section-intro { max-width:650px; margin:18px 0 0; color:var(--muted); font-size:.94rem; line-height:1.8; }
        .milestone { display:grid; grid-template-columns:minmax(0,1.08fr) minmax(310px,.92fr); gap:0; margin-top:34px; overflow:hidden; border:1px solid var(--line); background:#fff; box-shadow:0 22px 55px rgba(14,35,57,.09); }
        .milestone-photo { min-height:390px; background:#dae3e8; }
        .milestone-photo img { display:block; width:100%; height:100%; object-fit:cover; }
        .milestone-copy { display:flex; flex-direction:column; justify-content:center; padding:clamp(30px,5vw,65px); background:linear-gradient(150deg,#fafdff,#eaf5fc); }
        .memory-number { margin:0; color:var(--blue); font-size:.78rem; font-weight:800; letter-spacing:.14em; }
        .milestone-copy h2 { margin:16px 0 0; font-size:clamp(1.45rem,2.5vw,2.15rem); line-height:1.15; letter-spacing:-.035em; }
        .milestone-copy p { margin:20px 0 0; color:#4e6070; line-height:1.85; }
        .rule { width:70px; height:3px; margin:27px 0 0; background:var(--blue); }
        .team-section { margin-top:98px; }
        .team-photo-wrap { position:relative; margin-top:34px; overflow:hidden; background:#162c46; }
        .team-photo { display:block; width:100%; min-height:400px; max-height:660px; object-fit:cover; object-position:center; }
        .photo-credit { position:absolute; right:0; bottom:0; max-width:min(100%,520px); padding:23px 30px; color:#eff8ff; background:rgba(4,25,54,.92); font-size:.95rem; line-height:1.65; }
        .photo-credit b { display:block; margin-bottom:4px; color:#98d4f6; font-size:.73rem; letter-spacing:.13em; text-transform:uppercase; }
        .meeting { display:grid; grid-template-columns:1fr 1fr 1.12fr; gap:0; margin-top:76px; border:1px solid var(--line); background:#fff; }
        .meeting-item { min-height:175px; padding:30px; }
        .meeting-item + .meeting-item { border-left:1px solid var(--line); }
        .meeting-item small { display:block; margin-bottom:11px; color:var(--blue); font-size:.71rem; font-weight:800; letter-spacing:.13em; text-transform:uppercase; }
        .meeting-item strong { display:block; font-size:1.04rem; line-height:1.6; }
        .meeting-item p { margin:8px 0 0; color:var(--muted); font-size:.9rem; line-height:1.65; }
        .map-link { display:inline-flex; align-items:center; margin-top:16px; color:var(--blue); font-size:.88rem; font-weight:800; text-decoration:none; }
        .map-link:after { margin-left:8px; content:"→"; }
        .host-note { color:#fff; background:var(--navy); }
        .host-note small { color:#93d1f4; }
        .host-note p { color:rgba(238,248,255,.8); }
        .contribute { display:grid; grid-template-columns:minmax(0,1fr) 230px; gap:42px; align-items:center; margin-top:30px; padding:clamp(32px,5vw,58px); color:#eaf7ff; background:linear-gradient(125deg,#06244c,#0c508d); }
        .contribute h2 { margin:0; color:#fff; font-size:clamp(1.45rem,2.4vw,2.1rem); line-height:1.18; }
        .contribute-copy { margin:15px 0 0; color:rgba(234,247,255,.8); font-size:.94rem; line-height:1.75; }
        .payment-meta { display:grid; gap:10px; margin-top:25px; }
        .payment-meta div { display:grid; grid-template-columns:125px minmax(0,1fr); gap:12px; padding-bottom:10px; border-bottom:1px solid rgba(169,214,245,.2); }
        .payment-meta b { color:#9bd5f6; font-size:.71rem; letter-spacing:.1em; text-transform:uppercase; }
        .payment-meta span { font-weight:700; word-break:break-word; }
        .qr-box { padding:12px; background:#fff; box-shadow:0 15px 34px rgba(0,0,0,.22); }
        .qr-box img { display:block; width:100%; aspect-ratio:1; object-fit:contain; }
        .qr-pending { display:grid; width:100%; aspect-ratio:1; place-items:center; padding:22px; border:1px dashed rgba(155,213,246,.72); color:#c8eaff; background:rgba(255,255,255,.08); font-size:.85rem; font-weight:700; line-height:1.65; text-align:center; }
        .qr-caption { margin:12px 0 0; color:rgba(234,247,255,.75); font-size:.76rem; line-height:1.5; text-align:center; }
        .rsvp { margin-top:30px; padding:clamp(32px,5vw,58px); border:1px solid #cbdce9; background:#eaf5fc; }
        .rsvp h2 { margin:0; font-size:clamp(1.45rem,2.4vw,2.1rem); line-height:1.18; }
        .rsvp > p { max-width:650px; color:#526779; font-size:.94rem; line-height:1.75; }
        form { display:grid; gap:15px; margin-top:26px; }
        .choices { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .choice { display:flex; align-items:center; gap:10px; min-height:54px; padding:14px 16px; border:1px solid #bcd1df; cursor:pointer; color:#193957; background:#fff; font-weight:800; }
        input,textarea { width:100%; padding:14px; border:1px solid #bcd1df; border-radius:0; color:#17314d; background:#fff; font:inherit; }
        textarea { min-height:94px; resize:vertical; }
        button { min-height:52px; border:0; border-radius:0; padding:0 22px; cursor:pointer; color:#fff; background:var(--blue); font:800 .95rem "Be Vietnam Pro",sans-serif; transition:background .2s,transform .2s; }
        button:hover { background:#074f90; transform:translateY(-2px); }
        .flash { padding:15px 18px; color:#13563b; background:#dff5e8; font-weight:700; }
        .errors { color:#9d2630; font-size:.9rem; }
        .additional-memories { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-top:14px; }
        .additional-memories a { overflow:hidden; background:#dfe9ef; }
        .additional-memories img { display:block; width:100%; aspect-ratio:1.3; object-fit:cover; transition:transform .35s ease; }
        .additional-memories a:hover img { transform:scale(1.04); }
        footer { padding:0 0 54px; color:#697b8b; font-size:.88rem; text-align:center; }
        footer a { color:var(--blue); font-weight:800; text-decoration:none; }
        @media (max-width:760px) {
            .hero-grid { grid-template-columns:1fr; } .hero-copy { min-height:430px; padding:60px 24px 48px; } .hero-photo { min-height:320px; } .hero-bottom { align-items:start; flex-direction:column; margin-top:32px; }
            .timeline,.milestone,.meeting,.contribute,.appointment,.invite-letter { grid-template-columns:1fr; } .timeline-item + .timeline-item,.meeting-item + .meeting-item { border-top:1px solid var(--line); border-left:0; }
            .appointment-details { grid-template-columns:1fr; } .appointment-item { min-height:0; border-top:1px solid var(--line); border-left:0; } .appointment-title { min-height:0; gap:24px; }
            .milestone-photo { min-height:245px; } .team-section { margin-top:70px; } .team-photo { min-height:260px; } .photo-credit { position:static; max-width:none; }
            .meeting { margin-top:55px; } .contribute { gap:28px; } .qr-box { max-width:240px; } .choices { grid-template-columns:1fr; } .payment-meta div { grid-template-columns:1fr; gap:5px; }
        }
    </style>
</head>
<body>
    <header class="hero">
        <div class="orbit one"></div><div class="orbit two"></div>
        <div class="hero-grid">
            <div class="hero-copy">
                <p class="kicker">{{ $event->layout->hero_kicker }}</p>
                <h1>{!! nl2br(e($event->layout->hero_title)) !!}</h1>
                <span class="hero-title">{{ $event->headline }}</span>
                <div class="hero-bottom">
                    <p class="hero-note">{{ $event->layout->hero_note }}</p>
                    @if($guest)<span class="guest-chip">{{ $event->greeting }}</span>@endif
                </div>
            </div>
            <div class="hero-photo">
                @if($event->cover)<img class="hero-cover" src="{{ $event->cover }}" alt="{{ $event->layout->hero_photo_label }}">@endif
                <div class="hero-photo-label"><b>{{ $event->layout->hero_photo_label }}</b>{{ $event->layout->hero_photo_caption }}</div>
            </div>
        </div>
    </header>

    <section class="container appointment" aria-labelledby="appointment-title">
        <div class="appointment-title">
            <div><p>Thông tin hẹn gặp</p><h2 id="appointment-title">Mình gặp<br>nhau nhé.</h2></div>
            <span>Ban tổ chức sẽ cập nhật giờ đón tiếp và địa điểm chi tiết nếu có thay đổi.</span>
        </div>
        <div class="appointment-details">
            <div class="appointment-item"><small>Ngày hội ngộ</small><strong>{{ $gathering->event_date?->locale('vi')->translatedFormat('l, d/m/Y') ?? 'Đang cập nhật' }}</strong></div>
            <div class="appointment-item"><small>Thời gian</small><strong>{{ $gathering->event_time?->format('H:i') ?? 'Ban tổ chức sẽ cập nhật' }}</strong><span>Vui lòng theo dõi link mời để nhận thông tin mới nhất.</span></div>
            <div class="appointment-item"><small>Địa điểm</small><strong>{{ $gathering->venue_name ?: 'Đang cập nhật' }}</strong><span>{{ $gathering->venue_address ?: 'Ban tổ chức sẽ cập nhật địa điểm chi tiết.' }}</span>@if($gathering->map_url)<a class="map-link" href="{{ $gathering->map_url }}" target="_blank" rel="noopener">Mở chỉ đường</a>@endif</div>
        </div>
    </section>

    <div class="container timeline" aria-label="Hành trình hội ngộ" style="margin-top:30px">
        @foreach($event->layout->timeline as $timelineItem)
            <section class="timeline-item">
                <span class="timeline-year">{{ $timelineItem->date }}</span>
                <h2>{{ $timelineItem->title }}</h2>
                <p>{{ $timelineItem->description }}</p>
            </section>
        @endforeach
    </div>

    <main>
        <div class="container">
            <section class="invite-letter" aria-labelledby="invite-title">
                <div>
                    <p class="formal-greeting">Trân trọng kính mời</p>
                    <h2 id="invite-title">{{ $guest ? $event->greeting : ($gathering->host_name ?: 'Những người bạn từng đồng hành.') }}</h2>
                    <div class="invite-copy">{!! $event->introduction !!}</div>
                </div>
                <div class="invite-aside">Sự có mặt của mỗi người không chỉ là một cuộc gặp. Đó là dịp để những ký ức chung được gọi tên và hành trình từng cùng dựng xây được nối tiếp.</div>
            </section>

            @if($milestoneImage)
                <section aria-labelledby="milestone-title">
                    <p class="section-label">{{ $event->layout->milestone_label }}</p>
                    <h2 id="milestone-title" class="section-heading">{!! nl2br(e($event->layout->milestone_heading)) !!}</h2>
                    <div class="milestone">
                        <a class="milestone-photo" href="{{ $milestoneImage->url }}" target="_blank" rel="noopener"><img src="{{ $milestoneImage->url }}" alt="{{ $event->layout->milestone_title }}" loading="eager"></a>
                        <div class="milestone-copy">
                            <p class="memory-number">{{ $event->layout->milestone_date }}</p>
                            <h2>{{ $event->layout->milestone_title }}</h2>
                            <div class="rule"></div>
                            <p>{{ $event->layout->milestone_description }}</p>
                        </div>
                    </div>
                </section>
            @endif

            @if($teamImage)
                <section class="team-section" aria-labelledby="team-title">
                    <p class="section-label">{{ $event->layout->team_label }}</p>
                    <h2 id="team-title" class="section-heading">{!! nl2br(e($event->layout->team_heading)) !!}</h2>
                    <p class="section-intro">{{ $event->layout->team_intro }}</p>
                    <div class="team-photo-wrap">
                        <a href="{{ $teamImage->url }}" target="_blank" rel="noopener"><img class="team-photo" src="{{ $teamImage->url }}" alt="{{ $event->layout->team_heading }}" loading="lazy"></a>
                        <div class="photo-credit"><b>{{ $event->layout->team_credit_label }}</b>{{ $event->layout->team_credit }}</div>
                    </div>
                </section>
            @endif

            @if($additionalMemories->isNotEmpty())
                <section class="additional-memories" aria-label="Tư liệu bổ sung">
                    @foreach($additionalMemories as $image)<a href="{{ $image->url }}" target="_blank" rel="noopener"><img src="{{ $image->url }}" alt="{{ $image->alt }}" loading="lazy"></a>@endforeach
                </section>
            @endif

            <section class="meeting" aria-label="Thông tin hội ngộ">
                <div class="meeting-item">
                    <small>Ngày gặp mặt</small>
                    <strong>{{ $gathering->event_date?->locale('vi')->translatedFormat('l, d/m/Y') ?? 'Đang cập nhật' }}@if($gathering->event_time)<br>{{ $gathering->event_time->format('H:i') }}@endif</strong>
                </div>
                <div class="meeting-item">
                    <small>Địa điểm</small>
                    <strong>{{ $gathering->venue_name ?: 'Đang cập nhật' }}</strong>
                    @if($gathering->venue_address)<p>{{ $gathering->venue_address }}</p>@endif
                    @if($gathering->map_url)<a class="map-link" href="{{ $gathering->map_url }}" target="_blank" rel="noopener">Mở chỉ đường</a>@endif
                </div>
                <div class="meeting-item host-note">
                    <small>Lời nhắn</small>
                    <strong>{{ $gathering->host_name ?: 'Những người bạn cũ' }}</strong>
                    <p>{{ $event->host_note ?: 'Mình gặp nhau để ký ức không chỉ nằm lại trong những bức ảnh.' }}</p>
                </div>
            </section>

            @if($event->payment->enabled)
                <section class="contribute" id="dong-quy">
                    <div>
                        <p class="section-label" style="color:#9bd5f6">Đóng quỹ hội ngộ</p>
                        <h2>
                            @if ($guest && $event->payment->amount_for_guest > 0)
                                {{ number_format($event->payment->amount_for_guest, 0, ',', '.') }}đ cho {{ $event->payment->guest_count }} người
                            @elseif ($event->payment->amount > 0)
                                {{ number_format($event->payment->amount, 0, ',', '.') }}đ / người
                            @else
                                Quét mã để đóng quỹ
                            @endif
                        </h2>
                        <p class="contribute-copy">Mỗi khoản đóng góp giúp anh em mình chốt bàn tiệc và chuẩn bị cuộc gặp chu đáo hơn.</p>
                        @if($event->payment->transfer_reference || $event->payment->deadline)
                            <div class="payment-meta">
                                @if($event->payment->transfer_reference)<div><b>Nội dung CK</b><span>{{ $event->payment->transfer_reference }}</span></div>@endif
                                @if($event->payment->deadline)<div><b>Hạn đóng quỹ</b><span>{{ $event->payment->deadline->locale('vi')->translatedFormat('d/m/Y') }}</span></div>@endif
                            </div>
                        @endif
                        @if($event->payment->note)<p class="contribute-copy">{{ $event->payment->note }}</p>@endif
                    </div>
                    <div>
                        @if($event->payment->qr_url)
                            <div class="qr-box"><img src="{{ $event->payment->qr_url }}" alt="Mã QR đóng quỹ {{ $gathering->title }}"></div>
                            @if($event->payment->account_info)<p class="qr-caption" style="white-space:pre-line">{{ $event->payment->account_info }}</p>@endif
                            <p class="qr-caption">Mở ứng dụng ngân hàng và quét mã QR</p>
                        @else
                            <div class="qr-pending">Mã QR đóng quỹ sẽ được ban tổ chức cập nhật trước khi gửi link chính thức.</div>
                        @endif
                    </div>
                </section>
            @endif

            <section class="rsvp" id="xac-nhan">
                <p class="section-label">Xác nhận tham dự</p>
                @if($guest)
                    <h2>Hẹn gặp {{ $guest->name }}<br>đúng hẹn nhé.</h2>
                    <p>Phản hồi của bạn giúp anh em mình chuẩn bị chu đáo hơn cho lần gặp lại này.</p>
                    @if(session('gathering_rsvp_success'))<p class="flash">Đã nhận xác nhận của bạn. Hẹn gặp lại đúng ngày nhé!</p>@endif
                    @if(isset($errors) && $errors->has('rsvp'))<p class="errors">{{ $errors->first('rsvp') }}</p>@endif
                    <form method="POST" action="{{ route('gathering.rsvp.store', ['gathering' => $gathering->slug, 'guest' => $guest->code]) }}">
                        @csrf
                        <div class="choices">
                            <label class="choice"><input type="radio" name="rsvp_status" value="attending" @checked(old('rsvp_status', $guest->rsvp_status) === 'attending')> Có mặt, hẹn gặp anh em!</label>
                            <label class="choice"><input type="radio" name="rsvp_status" value="declined" @checked(old('rsvp_status') === 'declined')> Xin phép chưa tham dự được</label>
                        </div>
                        @if(isset($errors) && $errors->has('rsvp_status'))<p class="errors">{{ $errors->first('rsvp_status') }}</p>@endif
                        <input name="guest_count" type="number" min="1" max="50" value="{{ old('guest_count', $guest->guest_count) }}" placeholder="Số người tham dự">
                        <input name="phone" value="{{ old('phone', $guest->phone) }}" placeholder="Số điện thoại để tiện liên hệ">
                        <textarea name="note" placeholder="Có lời nhắn nào cho anh em không?">{{ old('note', $guest->note) }}</textarea>
                        <button type="submit">Gửi xác nhận</button>
                    </form>
                @else
                    <h2>Đợi link mời<br>mang tên mình nhé.</h2>
                    <p>Ban tổ chức sẽ gửi link riêng theo từng tên để anh em xác nhận tham dự, số người đi cùng và lưu lời nhắn. Form xác nhận sẽ hiện ngay tại phần này khi mở đúng link cá nhân.</p>
                @endif
            </section>
        </div>
    </main>

    <footer class="container">
        @if($gathering->contact_name || $gathering->contact_phone)Liên hệ {{ $gathering->contact_name ?: 'Ban tổ chức' }} @if($gathering->contact_phone)· <a href="tel:{{ preg_replace('/\s+/', '', $gathering->contact_phone) }}">{{ $gathering->contact_phone }}</a>@endif @else Hẹn gặp lại nhé. @endif
    </footer>
</body>
</html>
