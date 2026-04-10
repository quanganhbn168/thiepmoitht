<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Thư Mời Họp Lớp')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

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
