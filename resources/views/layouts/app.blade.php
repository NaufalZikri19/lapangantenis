<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Gumbreg QuickBook - Booking Lapangan Tenis Lebih Mudah')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    
    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Tailwind CSS CDN for instant styling as requested -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#EAB308', // yellow-500
                        primaryHover: '#CA8A04', // yellow-600
                        neutralBg: '#F9FAFB', // gray-50
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-neutralBg text-gray-900 antialiased selection:bg-yellow-200 selection:text-gray-900 overflow-x-hidden">

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
