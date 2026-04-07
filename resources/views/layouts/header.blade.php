<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gumbreg Tennis Court</title>

    <!-- Alpine -->
    <script src="https://unpkg.com/alpinejs" defer></script>

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind (optional kalau pakai CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body x-data="{ open: false, active: 'home', scrolled: false }" :class="open ? 'overflow-hidden' : ''" class="isolate relative z-0">

    <!-- ================= NAVBAR ================= -->
    <header class="fixed top-0 left-0 w-full z-50">

        <!-- BACKGROUND -->
        <div :class="scrolled
            ?
            'bg-white/80 backdrop-blur-xl shadow-md border-b border-gray-200' :
            'bg-transparent'"
            class="absolute inset-0 -z-10 transition-all duration-500">
        </div>

        <!-- NAV -->
        <nav x-init="const onScroll = () => {
            scrolled = window.scrollY > 50;

            const sections = ['home', 'about', 'court', 'pricing' ,'how-it-works'];
            sections.forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;

                const offset = el.offsetTop - 120;
                const height = el.offsetHeight;

                if (window.scrollY >= offset && window.scrollY < offset + height) {
                    active = id;
                }
            });
        };

        window.addEventListener('scroll', onScroll);
        onScroll();" class="relative max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- LOGO -->
            <a href="#home" class="text-2xl font-bold tracking-tight">
                <span :class="scrolled ? 'text-gray-900' : 'text-white'">
                    Gumbreg
                </span>
                <span class="text-yellow-500">QuickBook</span>
            </a>

            <!-- DESKTOP MENU -->
            <div class="hidden md:flex items-center gap-10 text-base font-medium">

                <template
                    x-for="menu in [
                {id:'about', label:'Tentang Kami'},
                {id:'court', label:'Lapangan'},
                {id:'pricing', label:'Harga'},
                {id:'how-it-works', label:'Cara Booking', icon:'list'},
            ]"
                    :key="menu.id">

                    <a :href="'#' + menu.id" @click="open=false"
                        :class="active === menu.id ?
                            'text-yellow-500' :
                            (scrolled ? 'text-gray-700' : 'text-white')"
                        class="relative hover:text-yellow-400 transition">

                        <span x-text="menu.label"></span>

                        <span x-show="active === menu.id"
                            class="absolute -bottom-2 left-0 w-full h-[2px] bg-yellow-500 rounded-full">
                        </span>

                    </a>

                </template>

            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

                @guest
                    <a href="{{ route('login') }}"
                        class="hidden md:flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-lg"
                        :class="scrolled
                            ?
                            'bg-yellow-500 text-white hover:bg-yellow-400' :
                            'bg-white text-black hover:bg-gray-200'">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        Masuk
                    </a>
                @endguest

                <!-- HAMBURGER -->
                <button @click="open = true" :class="scrolled ? 'text-gray-800' : 'text-white'"
                    class="md:hidden text-xl">
                    <i data-lucide="menu"></i>
                </button>

            </div>

        </nav>
    </header>

    <!-- ================= SMOOTH SCROLL ================= -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const target = document.querySelector(this.getAttribute('href'));

                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

    <!-- ================= SIDEBAR ================= -->
    <template x-teleport="body">

        <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-[9999] flex justify-end items-stretch">

            <!-- BACKDROP -->
            <div class="absolute inset-0 bg-black/60" @click="open = false">
            </div>

            <!-- PANEL -->
            <div @click.stop x-show="open" x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full" class="relative w-[75%] max-w-xs h-full isolate">

                <!-- BACKGROUND -->
                <div class="absolute inset-0 bg-black/40 backdrop-blur-xl border-l border-white/10"></div>

                <!-- CONTENT -->
                <div class="relative z-10 p-6 text-white overflow-y-auto h-full">

                    <!-- HEADER -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-lg">Menu</h2>
                        <button @click="open = false">✕</button>
                    </div>

                    <!-- DESC -->
                    <p class="text-sm text-white/60 mb-6">
                        Navigasi ke bagian yang ingin kamu lihat
                    </p>

                    <!-- MENU -->
                    <nav class="flex flex-col gap-4 font-medium">

                        <template
                            x-for="menu in [
                        {id:'home', label:'Home', icon:'home'},
                        {id:'about', label:'About', icon:'info'},
                        {id:'court', label:'Courts', icon:'map'},
                        {id:'pricing', label:'Pricing', icon:'tag'}
                    ]"
                            :key="menu.id">

                            <a :href="'#' + menu.id" @click="open=false"
                                :class="active === menu.id ?
                                    'bg-white text-black shadow' :
                                    'text-white/80 hover:text-white hover:bg-white/10'"
                                class="flex items-center gap-3 px-4 py-3 rounded-full transition">

                                <i :data-lucide="menu.icon" class="w-5 h-5"></i>
                                <span x-text="menu.label"></span>

                            </a>

                        </template>

                        <hr class="my-3 border-white/10">

                        @guest
                            <a href="{{ route('login') }}"
                                class="flex items-center justify-center gap-2 bg-yellow-500 text-white px-4 py-3 rounded-xl font-semibold hover:bg-yellow-400 transition">
                                <i data-lucide="log-in" class="w-4 h-4"></i>
                                Masuk
                            </a>
                        @endguest

                    </nav>

                </div>
            </div>
        </div>
    </template>

    <!-- ================= LUCIDE INIT ================= -->
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
