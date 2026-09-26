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

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-18475917188"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-18475917188');
    </script>
</head>
<body>
    <div id="page">
        @include('partials.shop.announcement-bar')
        @include('partials.shop.header')

        @yield('content')

        @include('partials.shop.footer')
    </div>

    {{-- Sits above .gototop (bottom: 20px, see the vendored stylesheet), not over it. Rendered
         only when an address is on file: a mailto: with nothing after it opens an empty compose
         window, which is worse than no button at all. --}}
    @if ($settings->contact_email)
        <a href="mailto:{{ $settings->contact_email }}" class="floating-email" aria-label="Schreiben Sie uns eine E-Mail">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true" focusable="false">
                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                <polyline points="3,7 12,13 21,7"></polyline>
            </svg>
        </a>
    @endif

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
