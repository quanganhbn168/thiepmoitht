{{-- Template Name: Thiệp cưới - Modern --}}
{{-- Type: wedding --}}
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->title }}</title>
    <meta name="description" content="{{ $event->description }}">
    <meta property="og:title" content="{{ $event->title }}">
    <meta property="og:description" content="{{ $event->description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $event->url }}">
    @if($event->share_image)<meta property="og:image" content="{{ $event->share_image }}">@endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#522d35; --rose:#b95769; --cream:#fff9f6; --line:#eadad3; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--ink); background:linear-gradient(180deg,#fff 0%,var(--cream) 100%); font-family:"Be Vietnam Pro",sans-serif; }
        .shell { width:min(920px,calc(100% - 32px)); margin:auto; }
        .hero { position:relative; min-height:620px; display:grid; place-items:center; overflow:hidden; color:#fff; text-align:center; background:linear-gradient(135deg,rgba(77,34,44,.76),rgba(185,87,105,.55)); }
        .hero::before { position:absolute; inset:0; background:radial-gradient(circle at 10% 10%,rgba(255,230,212,.4),transparent 30%),radial-gradient(circle at 90% 90%,rgba(255,215,222,.24),transparent 35%); content:""; }
        .hero-image { position:absolute; inset:0; z-index:-1; width:100%; height:100%; object-fit:cover; }
        .hero-content { position:relative; z-index:1; padding:72px 24px; text-shadow:0 2px 18px rgba(44,19,25,.45); }
        .eyebrow { margin:0 0 20px; font-size:12px; font-weight:700; letter-spacing:.18em; text-transform:uppercase; }
        h1 { max-width:780px; margin:0; font-family:"Great Vibes",cursive; font-size:clamp(64px,12vw,128px); font-weight:400; line-height:.86; }
        .amp { display:block; font-family:"Be Vietnam Pro",sans-serif; font-size:17px; font-weight:500; line-height:2.2; }
        .date { margin:28px 0 0; font-size:16px; font-weight:600; letter-spacing:.06em; }
        .card { margin:28px auto; padding:clamp(28px,6vw,58px); border:1px solid var(--line); border-radius:24px; background:#fff; box-shadow:0 20px 48px rgba(104,56,66,.08); text-align:center; }
        .script { margin:0; font-family:"Great Vibes",cursive; color:var(--rose); font-size:44px; font-weight:400; }
        .lead { max-width:630px; margin:18px auto 0; line-height:1.85; color:#755b61; }
        .detail-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; margin-top:30px; text-align:left; }
        .detail { padding:18px; border-radius:16px; background:#fff7f5; }
        .detail b { display:block; margin-bottom:7px; font-size:12px; letter-spacing:.08em; text-transform:uppercase; color:#a46b75; }
        .detail span, .detail a { color:var(--ink); line-height:1.6; text-decoration:none; }
        .family { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:20px; margin-top:30px; }
        .family div { padding:22px; border-top:1px solid var(--line); border-bottom:1px solid var(--line); }
        .family small { color:#a46b75; font-size:12px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; }
        .family p { margin:10px 0 0; line-height:1.7; }
        .gallery { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-top:28px; }
        .gallery img { display:block; width:100%; aspect-ratio:1; border-radius:14px; object-fit:cover; }
        .qr { display:grid; grid-template-columns:1fr auto; gap:28px; align-items:center; text-align:left; }
        .qr img { width:min(210px,50vw); border-radius:14px; background:#fff; padding:8px; box-shadow:0 8px 25px rgba(82,45,53,.13); }
        footer { padding:40px 0 60px; color:#96747b; font-size:14px; text-align:center; }
        @media (max-width:640px) { .hero { min-height:540px; } .detail-grid,.family,.qr { grid-template-columns:1fr; } .qr { text-align:center; } .qr img { margin:auto; order:-1; } .gallery { grid-template-columns:repeat(2,1fr); } }
    </style>
</head>
<body>
    <header class="hero">
        @if($event->cover)<img class="hero-image" src="{{ $event->cover }}" alt="{{ $wedding->groom_name }} và {{ $wedding->bride_name }}">@endif
        <div class="hero-content">
            <p class="eyebrow">{{ $event->headline }}</p>
            <h1>{{ $wedding->groom_name }}<span class="amp">&amp;</span>{{ $wedding->bride_name }}</h1>
            @if($event->event_datetime)<p class="date">{{ $event->event_datetime->locale('vi')->translatedFormat('l, d \t\h\á\n\g m \n\ă\m Y · H:i') }}</p>@endif
        </div>
    </header>

    <main class="shell">
        <section class="card">
            <p class="script">Save the date</p>
            <div class="lead">{!! $event->introduction !!}</div>
            @if($wedding->event_date || $wedding->venue_name || $wedding->venue_address)
                <div class="detail-grid">
                    @if($event->event_datetime)<div class="detail"><b>Thời gian</b><span>{{ $event->event_datetime->locale('vi')->translatedFormat('H:i · d/m/Y') }}</span></div>@endif
                    @if($wedding->venue_name || $wedding->venue_address)<div class="detail"><b>Địa điểm</b><span>{{ $wedding->venue_name }}@if($wedding->venue_name && $wedding->venue_address)<br>@endif{{ $wedding->venue_address }}</span>@if($wedding->map_url)<br><a href="{{ $wedding->map_url }}" target="_blank" rel="noopener" style="color:var(--rose);font-weight:700">Mở Google Maps</a>@endif</div>@endif
                </div>
            @endif
            @if(data_get($wedding->content, 'groom_family') || data_get($wedding->content, 'bride_family'))
                <div class="family">
                    @if(data_get($wedding->content, 'groom_family'))<div><small>Nhà trai</small><p>{{ data_get($wedding->content, 'groom_family') }}</p></div>@endif
                    @if(data_get($wedding->content, 'bride_family'))<div><small>Nhà gái</small><p>{{ data_get($wedding->content, 'bride_family') }}</p></div>@endif
                </div>
            @endif
            @if(data_get($wedding->content, 'note'))<p class="lead">{{ data_get($wedding->content, 'note') }}</p>@endif
        </section>

        @if($event->gallery->isNotEmpty())
            <section class="card">
                <p class="script">Our story</p>
                <div class="gallery">
                    @foreach($event->gallery as $image)<a href="{{ $image->url }}" target="_blank" rel="noopener"><img src="{{ $image->url }}" alt="{{ $image->alt }}" loading="lazy"></a>@endforeach
                </div>
            </section>
        @endif

        @if($event->payment->enabled)
            <section class="card qr">
                <div>
                    <p class="script">Mừng cưới</p>
                    <p class="lead" style="margin-left:0">Sự hiện diện của bạn là món quà quý giá nhất. Nếu tiện gửi lời chúc mừng, gia đình xin trân trọng cảm ơn.</p>
                    @if($event->payment->bank_name)<p><b>Ngân hàng:</b> {{ $event->payment->bank_name }}</p>@endif
                    @if($event->payment->account_number)<p><b>Số tài khoản:</b> {{ $event->payment->account_number }}</p>@endif
                    @if($event->payment->account_holder)<p><b>Chủ tài khoản:</b> {{ $event->payment->account_holder }}</p>@endif
                    @if($event->payment->transfer_note)<p><b>Nội dung CK:</b> {{ $event->payment->transfer_note }}</p>@endif
                    @if($event->payment->deadline)<p><b>Hạn mừng:</b> {{ $event->payment->deadline->locale('vi')->translatedFormat('d/m/Y') }}</p>@endif
                    @if($event->payment->note)<p class="lead" style="margin-left:0">{{ $event->payment->note }}</p>@endif
                </div>
                @if($event->payment->qr_url)<img src="{{ $event->payment->qr_url }}" alt="Mã QR mừng cưới">@endif
            </section>
        @endif
    </main>

    <footer>
        @if($wedding->contact_phone)Liên hệ {{ $wedding->contact_name ?: 'gia đình' }} · <a href="tel:{{ preg_replace('/\s+/', '', $wedding->contact_phone) }}">{{ $wedding->contact_phone }}</a>@else Hẹn gặp bạn trong ngày vui của chúng tôi. @endif
    </footer>
</body>
</html>
