<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Connexion') — Atelier Maison</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-100 min-h-screen flex items-center justify-center p-6">
    <main class="w-full max-w-sm">
        @yield('content')
    </main>
</body>
</html>
