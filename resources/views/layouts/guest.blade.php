<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
   <body class="relative flex items-center justify-center min-h-screen">
    <!-- Layer blur -->
    <div class="absolute inset-0 bg-cover bg-center blur-sm" style="background-image: url('/images/ngab.jpg')"></div>

    <!-- Optional: Layer transparan gelap -->
    <div class="absolute inset-0 bg-black/40"></div>

    <!-- Form container -->
    <div class="relative z-10 w-full max-w-md p-6 bg-zinc-700 rounded shadow">
        {{ $slot }}
    </div>
</body>
</html>
