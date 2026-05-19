<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.getItem('dark') === 'true' }"
    x-init="$watch('dark', val => localStorage.setItem('dark', val))" :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Akses Akun - Gumbreg QuickBook' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#EAB308', primaryHover: '#CA8A04' }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="antialiased text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 transition-colors duration-200">
    <div class="flex min-h-screen">

        <!-- LEFT SIDE -->
        <div class="hidden md:flex flex-col w-1/2 relative bg-gray-900 overflow-hidden">
            <div class="absolute inset-0 bg-yellow-500 z-0 mix-blend-multiply opacity-20"></div>
            <img src="{{ asset('image/image1.jpg') }}" class="absolute inset-0 w-full h-full object-cover z-10"
                alt="Tennis Court"
                onerror="this.src='https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?q=80&w=1000&auto=format&fit=crop'">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent z-20"></div>

            <div class="relative z-30 flex flex-col justify-between h-full p-12 lg:p-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 group w-max">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Gumbreg QuickBook"
                        class="w-10 h-10 rounded-xl shadow-sm group-hover:scale-105 transition-transform duration-200 object-cover bg-white">
                    <span class="text-xl font-bold tracking-tight text-white">
                        Gumbreg<span class="text-yellow-400">QuickBook</span>
                    </span>
                </a>

                <div class="text-white">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/20 border border-white/10 text-xs font-semibold uppercase tracking-wider mb-6 backdrop-blur-sm">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        Aman & Terpercaya
                    </div>
                    <h3 class="text-4xl lg:text-5xl font-bold leading-tight mb-4">
                        Mulai langkah Anda menuju lapangan.
                    </h3>
                    <p class="text-lg text-gray-200 leading-relaxed max-w-md">
                        Sistem manajemen reservasi lapangan tenis yang dirancang untuk kecepatan dan kemudahan akses.
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex items-center justify-center w-full md:w-1/2 p-6 lg:p-16 bg-white dark:bg-gray-900 overflow-hidden relative">
            <div class="w-full max-w-md relative z-10">
                <div class="md:hidden flex items-center justify-center gap-2 mb-10">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Gumbreg QuickBook"
                        class="w-10 h-10 rounded-xl shadow-sm group-hover:scale-105 transition-transform duration-200 object-cover bg-white">
                    <span class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Gumbreg<span class="text-primary">QuickBook</span>
                    </span>
                </div>

                @include('components.sweet-alert')
                {{ $slot }}
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (window.lucide) { lucide.createIcons(); }
        });
    </script>
</body>

</html>