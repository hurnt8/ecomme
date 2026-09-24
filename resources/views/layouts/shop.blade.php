<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', $settings->site_name) — {{ $settings->site_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', $settings->description)">
    <meta name="author" content="{{ $settings->site_name }}">

    <meta property="og:title" content="@yield('title', $settings->site_name)">
    <meta property="og:description" content="@yield('meta_description', $settings->description)">
    <meta property="og:site_name" content="{{ $settings->site_name }}">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- The vendored stylesheet asks for Montserrat and Playfair Display but never loaded them,
         so every page fell back to the system sans-serif — and the back-office, asking for Lato,
         fell back to the same one. Loading them here is what actually makes the two look related;
         `display=swap` keeps text readable while they arrive. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap">

    {{-- shop-master template stylesheet, kept as static vendor assets for pixel fidelity (see resources/css/app.css) --}}
    <link rel="stylesheet" href="{{ asset('template/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/flexslider.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="page">
        @include('partials.shop.announcement-bar')
        @include('partials.shop.header')

        @yield('content')

        @include('partials.shop.footer')
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
    </div>

    @include('partials.shop.toasts')

    <script src="{{ asset('template/js/jquery.min.js') }}"></script>
    <script src="{{ asset('template/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('template/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template/js/jquery.flexslider-min.js') }}"></script>
    <script src="{{ asset('template/js/site.js') }}"></script>
    @stack('scripts')
</body>
</html>
