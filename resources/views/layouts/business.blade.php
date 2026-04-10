<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $card->name ?? 'Business Card' }} - {{ $card->title ?? 'Profile' }}</title>
    
    <!-- SEO Meta -->
    <meta name="description" content="{{ Str::limit(strip_tags($card->about ?? ''), 160) }}">
    <meta property="og:title" content="{{ $card->name }} - {{ $card->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($card->about ?? ''), 160) }}">
    @if($card->hasMedia('cover'))
    <meta property="og:image" content="{{ $card->getFirstMediaUrl('cover', 'share') }}">
    @elseif($card->hasMedia('avatar'))
    <meta property="og:image" content="{{ $card->getFirstMediaUrl('avatar') }}">
    @endif

    <!-- Vite Assets (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Template Specific Styles -->
    @stack('styles')
</head>
<body class="antialiased" style="{{ $card->theme_color ? 'background-color: '.$card->theme_color : '' }}">
    
    @yield('content')

    <!-- Template Specific Scripts -->
    @stack('scripts')
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
        });
    </script>
</body>
</html>
