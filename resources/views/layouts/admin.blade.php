<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tableau de bord') — Administration {{ $settings->site_name }}</title>

    {{-- Same two families as the shop front, so the back-office reads as the same product rather
         than as a separate tool bolted on. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{-- `admin-ui` carries the back-office base reset — fonts, links, form controls, focus rings.
     The admin loads no stylesheet but app.css, and Tailwind's Preflight is excluded there for
     the shop's sake, so without this class everything renders in Times New Roman. --}}
<body class="admin-ui bg-neutral-50 text-neutral-900">
    <div class="min-h-screen flex">
        @include('partials.admin.sidebar')

        <div class="flex-1 flex flex-col min-w-0">
            @include('partials.admin.topbar')

            <main class="flex-1 p-6">
                @if (session('status'))
                    <div class="mb-5 rounded-md border border-sage-100 bg-sage-50 px-4 py-3 text-sm text-sage-700">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
