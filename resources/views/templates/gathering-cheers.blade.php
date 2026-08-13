{{-- Template Name: Hội ngộ - Kèo thân tình --}}
{{-- Type: gathering --}}
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
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#21160f; --wine:#7a1f2b; --coral:#d95f3d; --cream:#fff8ec; --gold:#d7a849; }
        * { box-sizing:border-box; } body { margin:0; color:var(--ink); background:#f7eee1; font-family:"Be Vietnam Pro",sans-serif; }
        .hero { min-height:600px; position:relative; overflow:hidden; isolation:isolate; display:grid; place-items:center; padding:56px 20px 88px; color:#fffaf2; text-align:center; background:radial-gradient(circle at 20% 20%,#d46d48 0,transparent 34%),radial-gradient(circle at 80% 0,#9f3442 0,transparent 35%),linear-gradient(135deg,#2a1719,#7a1f2b 54%,#bc5140); }
        .hero:before { content:""; position:absolute; inset:0; z-index:-2; background:linear-gradient(180deg,rgba(24,12,10,.38),rgba(24,12,10,.72)); }
        .hero-cover { position:absolute; inset:0; z-index:-3; width:100%; height:100%; object-fit:cover; opacity:.42; }
        .spark { position:absolute; width:15rem; height:15rem; border:1px solid rgba(255,255,255,.2); border-radius:50%; filter:blur(.2px); }
        .spark.one { left:-6rem; top:8rem; } .spark.two { right:-7rem; bottom:-7rem; width:22rem; height:22rem; }
        .eyebrow { margin:0 0 18px; font-size:.76rem; letter-spacing:.2em; font-weight:800; text-transform:uppercase; color:#ffd27b; }
        h1,h2 { font-family:"Playfair Display",serif; } h1 { max-width:840px; margin:0; font-size:clamp(2.8rem,8vw,6.3rem); line-height:.98; letter-spacing:-.045em; }
        .headline { max-width:650px; margin:24px auto 0; font-size:clamp(1rem,2.4vw,1.28rem); line-height:1.7; color:rgba(255,250,242,.88); }
        .guest { display:inline-block; margin-top:30px; padding:10px 19px; border:1px solid rgba(255,232,186,.55); border-radius:999px; color:#fff2d7; font-weight:700; background:rgba(55,16,18,.22); backdrop-filter:blur(8px); }
        .container { width:min(100% - 32px,1050px); margin:0 auto; } .card { border:1px solid rgba(122,31,43,.11); border-radius:28px; background:#fffcf6; box-shadow:0 18px 55px rgba(84,40,28,.10); }
        main { margin-top:-48px; position:relative; z-index:2; padding-bottom:72px; } .details { display:grid; grid-template-columns:repeat(3,1fr); gap:0; overflow:hidden; }
        .detail { padding:28px; border-right:1px solid rgba(122,31,43,.12); } .detail:last-child { border:0; } .detail b { display:block; margin-bottom:8px; font-size:.75rem; letter-spacing:.12em; text-transform:uppercase; color:var(--wine); } .detail span { font-size:1rem; font-weight:700; line-height:1.5; }
        .grid { display:grid; grid-template-columns:minmax(0,1.1fr) minmax(300px,.9fr); gap:24px; margin-top:24px; } .letter { padding:clamp(28px,5vw,58px); } h2 { margin:0; color:var(--wine); font-size:clamp(2rem,4vw,3.3rem); line-height:1.1; } .copy { margin-top:22px; color:#593e34; line-height:1.85; } .copy p:first-child { margin-top:0; }
        .aside { padding:30px; background:linear-gradient(155deg,#40201e,#7a1f2b); color:#fff8ec; } .aside h3 { margin:0; font-size:1.25rem; } .aside p { color:rgba(255,248,236,.77); line-height:1.7; } .agenda { margin:26px 0 0; padding:0; list-style:none; } .agenda li { padding:16px 0; border-top:1px solid rgba(255,255,255,.16); } .agenda strong { display:block; color:#ffd27b; font-size:.9rem; } .agenda span { display:block; margin-top:5px; font-size:.9rem; line-height:1.55; color:rgba(255,248,236,.8); }
        .rsvp { margin-top:24px; padding:clamp(28px,5vw,48px); background:linear-gradient(135deg,#f3d98e,#e4a64a); } .rsvp h2 { color:#4a231d; } .rsvp > p { max-width:650px; color:#634022; line-height:1.7; } form { display:grid; gap:16px; margin-top:24px; } .choices { display:grid; grid-template-columns:1fr 1fr; gap:12px; } .choice { display:flex; align-items:center; gap:10px; padding:15px; cursor:pointer; border:1px solid rgba(74,35,29,.22); border-radius:15px; color:#4a231d; background:rgba(255,252,246,.45); font-weight:800; transition:border-color .2s,background .2s,box-shadow .2s; } .choice:has(input:checked) { border-color:var(--wine); background:#fff0d5; box-shadow:inset 0 0 0 1px var(--wine); } .choice input[type="radio"] { flex:0 0 18px; width:18px; height:18px; min-height:0; margin:0; padding:0; accent-color:var(--wine); } input:not([type="radio"]),textarea { width:100%; border:1px solid rgba(74,35,29,.25); border-radius:13px; padding:14px; color:#3b241d; font:inherit; background:#fffaf1; } textarea { min-height:90px; resize:vertical; } button,.map-link { display:inline-flex; justify-content:center; align-items:center; min-height:52px; border:0; border-radius:14px; padding:0 22px; cursor:pointer; color:#fffaf1; background:#4a231d; font:800 .95rem inherit; text-decoration:none; transition:transform .2s,background .2s; } button:hover,.map-link:hover { transform:translateY(-2px); background:#26120f; } .flash { margin-top:24px; padding:15px 18px; border-radius:14px; color:#195f44; background:#dff5e8; font-weight:700; } .errors { margin-top:20px; color:#8b1d25; font-size:.93rem; }
        .memories { margin-top:24px; padding:clamp(28px,5vw,48px); } .memories-head { display:flex; justify-content:space-between; gap:18px; align-items:end; margin-bottom:24px; } .memories-head p { margin:0; max-width:440px; color:#7b6558; line-height:1.7; } .memory-grid { display:grid; grid-template-columns:1.2fr .8fr .8fr; grid-auto-rows:170px; gap:14px; } .memory { overflow:hidden; border-radius:18px; background:#e7d9c9; } .memory:first-child { grid-row:span 2; } .memory img { width:100%; height:100%; object-fit:cover; transition:transform .45s ease; } .memory:hover img { transform:scale(1.05); }
        .payment { display:grid; grid-template-columns:minmax(0,1fr) 220px; gap:34px; align-items:center; margin-top:24px; padding:clamp(28px,5vw,48px); color:#fff8ec; background:linear-gradient(135deg,#271514,#6b2029 58%,#9d4535); } .payment h2 { color:#fff5dc; } .payment-copy { margin:18px 0 0; color:rgba(255,248,236,.8); line-height:1.8; } .payment-meta { display:grid; gap:13px; margin-top:24px; } .payment-meta div { display:flex; gap:12px; align-items:baseline; padding-bottom:12px; border-bottom:1px solid rgba(255,255,255,.15); } .payment-meta b { flex:0 0 128px; color:#f2c76d; font-size:.77rem; letter-spacing:.08em; text-transform:uppercase; } .payment-meta span { font-weight:700; word-break:break-word; } .qr-box { padding:12px; border-radius:22px; background:#fffaf1; box-shadow:0 14px 36px rgba(0,0,0,.22); } .qr-box img { display:block; width:100%; aspect-ratio:1; object-fit:contain; } .qr-caption { margin:13px 0 0; color:rgba(255,248,236,.72); text-align:center; font-size:.76rem; line-height:1.5; }
        .foot { padding:32px 0 12px; text-align:center; color:#7b6558; font-size:.9rem; } .foot a { color:var(--wine); font-weight:700; }
        @media (max-width:720px) { .hero { min-height:530px; } .details,.grid,.payment { grid-template-columns:1fr; } .detail { border-right:0; border-bottom:1px solid rgba(122,31,43,.12); } .choices { grid-template-columns:1fr; } .memories-head { align-items:start; flex-direction:column; } .memory-grid { grid-template-columns:1fr 1fr; grid-auto-rows:135px; } .payment-meta div { display:block; } .payment-meta b { display:block; margin-bottom:5px; } .qr-box { max-width:250px; } }
    </style>
</head>
<body>
    <header class="hero">
        @if($event->cover)<img class="hero-cover" src="{{ $event->cover }}" alt="{{ $gathering->title }}">@endif
        <div class="spark one"></div><div class="spark two"></div>
        <div>
            <p class="eyebrow">Lời mời hội ngộ</p>
            <h1>{{ $gathering->title }}</h1>
            <p class="headline">{{ $event->headline }}</p>
            @if($guest)<span class="guest">{{ $event->greeting }}</span>@endif
        </div>
    </header>

    <main>
        <div class="container">
            <section class="card details" aria-label="Thông tin buổi hội ngộ">
                <div class="detail"><b>Thời gian</b><span>{{ $event->event_datetime?->locale('vi')->translatedFormat('H:i · l, d/m/Y') ?? 'Đang cập nhật' }}</span></div>
                <div class="detail"><b>Địa điểm</b><span>{{ $gathering->venue_name ?: 'Đang cập nhật' }}</span></div>
                <div class="detail"><b>Địa chỉ</b><span>{{ $gathering->venue_address ?: 'Ban tổ chức sẽ thông báo' }}</span></div>
            </section>

            <section class="grid">
                <article class="card letter">
                    <p class="eyebrow" style="color:#b05a38">Gặp nhau một bữa</p>
                    <h2>{{ $event->greeting }}</h2>
                    <div class="copy">{!! $event->introduction !!}</div>
                    @if($guest?->note)<p class="copy"><strong>Lời nhắn riêng:</strong> {{ $guest->note }}</p>@endif
                    @if($event->dress_code)<p class="copy"><strong>Dress code:</strong> {{ $event->dress_code }}</p>@endif
                    @if($event->menu_note)<p class="copy"><strong>Ghi chú:</strong> {{ $event->menu_note }}</p>@endif
                    @if($gathering->map_url)<p style="margin:28px 0 0"><a class="map-link" target="_blank" rel="noopener" href="{{ $gathering->map_url }}">Mở chỉ đường</a></p>@endif
                </article>
                <aside class="card aside">
                    <h3>Chương trình dự kiến</h3>
                    @if($event->schedule->isNotEmpty())
                        <ul class="agenda">@foreach($event->schedule as $item)<li><strong>{{ $item->time }} · {{ $item->title }}</strong>@if($item->description)<span>{{ $item->description }}</span>@endif</li>@endforeach</ul>
                    @else
                        <p>Đến đúng giờ, ngồi đúng bàn, còn vui đến đâu thì để anh em mình tự quyết.</p>
                    @endif
                    @if($event->host_note)<p><strong>{{ $gathering->host_name ?: 'Ban tổ chức' }}:</strong> {{ $event->host_note }}</p>@endif
                </aside>
            </section>

            @if($event->gallery->isNotEmpty())
                <section class="card memories">
                    <div class="memories-head">
                        <div><p class="eyebrow" style="color:#b05a38">Khoảnh khắc</p><h2>Để lần gặp này thành kỷ niệm</h2></div>
                        <p>Thêm vài bức ảnh để lời mời có không khí riêng của hội mình.</p>
                    </div>
                    <div class="memory-grid">
                        @foreach($event->gallery as $image)
                            <a class="memory" href="{{ $image->url }}" target="_blank" rel="noopener"><img src="{{ $image->url }}" alt="{{ $image->alt }}" loading="lazy"></a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($event->payment->enabled)
                <section class="card payment" id="dong-quy">
                    <div>
                        <p class="eyebrow" style="color:#f2c76d">Đóng quỹ hội ngộ</p>
                        <h2>{{ $event->payment->amount > 0 ? number_format($event->payment->amount, 0, ',', '.') . 'đ' : 'Quét mã để đóng quỹ' }}</h2>
                        <p class="payment-copy">Mỗi khoản đóng góp giúp ban tổ chức chuẩn bị buổi gặp gỡ chu đáo hơn.</p>
                        <div class="payment-meta">
                            @if($event->payment->bank_name)<div><b>Ngân hàng</b><span>{{ $event->payment->bank_name }}</span></div>@endif
                            @if($event->payment->account_number)<div><b>Số tài khoản</b><span>{{ $event->payment->account_number }}</span></div>@endif
                            @if($event->payment->account_holder)<div><b>Chủ tài khoản</b><span>{{ $event->payment->account_holder }}</span></div>@endif
                            @if($event->payment->transfer_reference)
                                <div><b>Nội dung CK</b><span>{{ $event->payment->transfer_reference }}</span></div>
                            @endif
                            @if($event->payment->deadline)<div><b>Hạn đóng quỹ</b><span>{{ $event->payment->deadline->locale('vi')->translatedFormat('d/m/Y') }}</span></div>@endif
                        </div>
                        @if($event->payment->note)<p class="payment-copy">{{ $event->payment->note }}</p>@endif
                    </div>
                    @if($event->payment->qr_url)
                        <div><div class="qr-box"><img src="{{ $event->payment->qr_url }}" alt="Mã QR đóng quỹ {{ $gathering->title }}"></div><p class="qr-caption">Mở ứng dụng ngân hàng và quét mã QR để chuyển khoản.</p></div>
                    @endif
                </section>
            @endif

            @if($guest)
                <section class="card rsvp" id="xac-nhan">
                    <p class="eyebrow" style="color:#6c301f">Xác nhận tham dự</p>
                    <h2>Chốt kèo với {{ $guest->name }}</h2>
                    <p>Phản hồi của bạn giúp ban tổ chức chuẩn bị bàn tiệc chu đáo hơn.</p>
                    @if(session('gathering_rsvp_success'))<p class="flash">Đã nhận xác nhận của bạn. Hẹn gặp đúng giờ nhé!</p>@endif
                    @if(isset($errors) && $errors->has('rsvp'))<p class="errors">{{ $errors->first('rsvp') }}</p>@endif
                    <form method="POST" action="{{ route('gathering.rsvp.store', ['gathering' => $gathering->slug, 'guest' => $guest->code]) }}">
                        @csrf
                        <div class="choices">
                            <label class="choice"><input type="radio" name="rsvp_status" value="attending" @checked(old('rsvp_status', $guest->rsvp_status) === 'attending') required> Có mặt, chốt kèo!</label>
                            <label class="choice"><input type="radio" name="rsvp_status" value="declined" @checked(old('rsvp_status') === 'declined')> Xin phép vắng mặt</label>
                        </div>
                        @if(isset($errors) && $errors->has('rsvp_status'))<p class="errors">{{ $errors->first('rsvp_status') }}</p>@endif
                        <input name="phone" value="{{ old('phone', $guest->phone) }}" placeholder="Số điện thoại (để BTC tiện liên hệ)">
                        <textarea name="note" placeholder="Có lời nhắn gì cho kèo này không?">{{ old('note', $guest->note) }}</textarea>
                        <button type="submit">Gửi xác nhận</button>
                    </form>
                </section>
            @else
                <section class="card rsvp" id="xac-nhan">
                    <p class="eyebrow" style="color:#6c301f">Xác nhận tham dự</p>
                    <h2>Xác nhận ngay trên link chung</h2>
                    <p>Điền họ và tên để ban tổ chức ghi nhận phản hồi.</p>
                    @if(isset($errors) && $errors->has('rsvp'))<p class="errors">{{ $errors->first('rsvp') }}</p>@endif
                    <form method="POST" action="{{ route('gathering.shared-rsvp.store', ['gathering' => $gathering->slug]) }}">
                        @csrf
                        <input name="name" value="{{ old('name') }}" placeholder="Họ và tên của bạn" autocomplete="name" required>
                        @if(isset($errors) && $errors->has('name'))<p class="errors">{{ $errors->first('name') }}</p>@endif
                        <div class="choices">
                            <label class="choice"><input type="radio" name="rsvp_status" value="attending" @checked(old('rsvp_status') === 'attending') required> Có mặt, chốt kèo!</label>
                            <label class="choice"><input type="radio" name="rsvp_status" value="declined" @checked(old('rsvp_status') === 'declined')> Xin phép vắng mặt</label>
                        </div>
                        @if(isset($errors) && $errors->has('rsvp_status'))<p class="errors">{{ $errors->first('rsvp_status') }}</p>@endif
                        <input name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại (để BTC tiện liên hệ)" autocomplete="tel">
                        <textarea name="note" placeholder="Có lời nhắn gì cho kèo này không?">{{ old('note') }}</textarea>
                        <button type="submit">Gửi xác nhận</button>
                    </form>
                </section>
            @endif
        </div>
    </main>
    <footer class="container foot">
        @if($gathering->contact_name || $gathering->contact_phone)Liên hệ {{ $gathering->contact_name ?: 'Ban tổ chức' }} @if($gathering->contact_phone)· <a href="tel:{{ preg_replace('/\s+/', '', $gathering->contact_phone) }}">{{ $gathering->contact_phone }}</a>@endif @endif
    </footer>
</body>
</html>
