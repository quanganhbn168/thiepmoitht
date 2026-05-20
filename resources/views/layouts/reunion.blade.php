<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    @php
        $defaultTitle = data_get($event ?? null, 'title', 'Thư Mời Họp Lớp');
        $pageTitle = trim($__env->yieldContent('title', $defaultTitle));
        $metaTitle = trim($__env->yieldContent('meta_title', $pageTitle));

        $defaultDescription = data_get($event ?? null, 'description', '');
        $defaultDescription = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $defaultDescription), ENT_QUOTES | ENT_HTML5, 'UTF-8')));

        if ($defaultDescription === '' && isset($schoolInfo)) {
            $defaultDescription = trim(($schoolInfo['anniversary'] ?? '') . ' ngày ra trường - ' . ($schoolInfo['course'] ?? '') . ' - ' . ($schoolInfo['name'] ?? ''));
        }

        $metaDescription = trim($__env->yieldContent('meta_description', $defaultDescription ?: 'Thư mời họp lớp online'));
        $metaDescription = \Illuminate\Support\Str::limit($metaDescription, 180, '');

        $shareImage = trim($__env->yieldContent(
            'share_image',
            data_get($event ?? null, 'share_image')
                ?: (isset($reunion) ? $reunion->getShareUrl() : '')
        ));

        if ($shareImage !== '' && ! \Illuminate\Support\Str::startsWith($shareImage, ['http://', 'https://'])) {
            $shareImage = \Illuminate\Support\Str::startsWith($shareImage, '/')
                ? url($shareImage)
                : asset($shareImage);
        }

        $canonicalUrl = trim($__env->yieldContent(
            'canonical_url',
            isset($reunion) ? url('/' . $reunion->slug) : url()->current()
        ));
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $pageTitle }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('meta')
        @yield('meta')
    @else
        <meta name="description" content="{{ $metaDescription }}">
        <link rel="canonical" href="{{ $canonicalUrl }}">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="vi_VN">
        <meta property="og:site_name" content="{{ config('app.name', 'Thiệp Mời') }}">
        <meta property="og:url" content="{{ $canonicalUrl }}">
        <meta property="og:title" content="{{ $metaTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        @if($shareImage !== '')
            <meta property="og:image" content="{{ $shareImage }}">
            <meta property="og:image:secure_url" content="{{ $shareImage }}">
            <meta property="og:image:width" content="@yield('share_image_width', '1200')">
            <meta property="og:image:height" content="@yield('share_image_height', '630')">
        @endif
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $metaTitle }}">
        <meta name="twitter:description" content="{{ $metaDescription }}">
        @if($shareImage !== '')
            <meta name="twitter:image" content="{{ $shareImage }}">
        @endif
    @endif

    <!-- Favicon -->
    <link rel="icon" href="/favicon.png" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Be+Vietnam+Pro:wght@300;400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="@yield('body_class', 'antialiased overflow-x-hidden')">
    @yield('content')

    <!-- SCRIPTS -->
    <script>
        
        // ---- Copy link globally ----
        window.copyLink = function() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Đã copy!',
                        text: 'Đã copy link thiệp mời! Gửi cho bạn bè nhé 🎓',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('Đã copy link!');
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
