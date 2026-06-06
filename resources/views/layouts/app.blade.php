<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ dark: localStorage.getItem('dark') === 'true' }"
    x-init="$watch('dark', val => localStorage.setItem('dark', val))" :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Gumbreg QuickBook - Booking Lapangan Tenis Lebih Mudah')</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo.webp') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">



    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body
    class="bg-neutralBg dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased selection:bg-yellow-200 dark:selection:bg-yellow-900/30 selection:text-gray-900 dark:selection:text-gray-100 overflow-x-hidden transition-colors duration-200">

    @include('layouts.header')

    <main class="min-h-screen">
        @include('components.sweet-alert')
        @yield('content')
    </main>

    @include('layouts.footer')

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.effect(() => {
                if (window.lucide) {
                    lucide.createIcons();
                }
            });
        });
    </script>
</body>

</html>