<header x-data="{ 
    scrolled: false, 
    mobileMenuOpen: false,
    activeSection: '',
    updateActive() {
        const sections = ['about', 'pricing', 'cara-booking', 'contact'];
        sections.forEach(id => {
            const el = document.getElementById(id);
            if (el && window.scrollY >= el.offsetTop - 150) {
                this.activeSection = id;
            }
        });
        if (window.scrollY < 100) this.activeSection = '';
    }
}" x-init="scrolled = window.scrollY > 10; updateActive()"
    @scroll.window="scrolled = window.scrollY > 10; updateActive()"
    :class="scrolled ? 'bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm border-b border-gray-100 dark:border-gray-800 py-3' : 'bg-transparent py-5'"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between">

            <!-- LOGO -->
            <a href="/" class="flex items-center gap-2 group">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Gumbreg QuickBook"
                    class="w-10 h-10 rounded-xl shadow-sm group-hover:scale-105 transition-transform duration-200 object-cover bg-white">
                <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Gumbreg<span class="text-primary">QuickBook</span>
                </span>
            </a>

            <!-- DESKTOP MENU -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#about"
                    :class="activeSection === 'about' ? 'text-primary font-bold' : 'text-gray-600 dark:text-gray-400 font-medium'"
                    class="text-sm hover:text-gray-900 dark:hover:text-white transition-colors duration-200">Tentang
                    Kami</a>
                <a href="#pricing"
                    :class="activeSection === 'pricing' ? 'text-primary font-bold' : 'text-gray-600 dark:text-gray-400 font-medium'"
                    class="text-sm hover:text-gray-900 dark:hover:text-white transition-colors duration-200">Harga</a>
                <a href="#cara-booking"
                    :class="activeSection === 'cara-booking' ? 'text-primary font-bold' : 'text-gray-600 dark:text-gray-400 font-medium'"
                    class="text-sm hover:text-gray-900 dark:hover:text-white transition-colors duration-200">Cara
                    Booking</a>
                <a href="#contact"
                    :class="activeSection === 'contact' ? 'text-primary font-bold' : 'text-gray-600 dark:text-gray-400 font-medium'"
                    class="text-sm hover:text-gray-900 dark:hover:text-white transition-colors duration-200">Kontak</a>
            </nav>

            <!-- AUTH BUTTONS -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Theme Toggle Button -->
                <button @click="dark = !dark"
                    class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 shrink-0 focus:outline-none overflow-hidden flex items-center justify-center w-9 h-9">
                    <div x-show="!dark"
                        x-transition:enter="transition-transform transition-opacity duration-500 ease-out"
                        x-transition:enter-start="opacity-0 rotate-90 scale-50"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition-transform transition-opacity duration-500 ease-in absolute"
                        x-transition:leave-start="opacity-100 rotate-0 scale-100"
                        x-transition:leave-end="opacity-0 -rotate-90 scale-50">
                        <i data-lucide="sun" class="w-5 h-5"></i>
                    </div>
                    <div x-show="dark" x-cloak
                        x-transition:enter="transition-transform transition-opacity duration-500 ease-out"
                        x-transition:enter-start="opacity-0 -rotate-90 scale-50"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition-transform transition-opacity duration-500 ease-in absolute"
                        x-transition:leave-start="opacity-100 rotate-0 scale-100"
                        x-transition:leave-end="opacity-0 rotate-90 scale-50">
                        <i data-lucide="moon" class="w-5 h-5"></i>
                    </div>
                </button>
                @guest
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-medium text-gray-900 bg-primary hover:bg-primaryHover shadow-sm hover:shadow transition-all duration-200">
                        Daftar Sekarang
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-medium text-gray-900 bg-primary hover:bg-primaryHover shadow-sm hover:shadow transition-all duration-200">
                        Dashboard
                    </a>
                @endguest
            </div>

            <!-- MOBILE ACTIONS -->
            <div class="flex items-center gap-2 md:hidden">
                <!-- Theme Toggle Button Mobile -->
                <button @click="dark = !dark"
                    class="relative p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 shrink-0 focus:outline-none overflow-hidden flex items-center justify-center w-9 h-9">
                    <div x-show="!dark"
                        x-transition:enter="transition-transform transition-opacity duration-500 ease-out"
                        x-transition:enter-start="opacity-0 rotate-90 scale-50"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition-transform transition-opacity duration-500 ease-in absolute"
                        x-transition:leave-start="opacity-100 rotate-0 scale-100"
                        x-transition:leave-end="opacity-0 -rotate-90 scale-50">
                        <i data-lucide="sun" class="w-5 h-5"></i>
                    </div>
                    <div x-show="dark" x-cloak
                        x-transition:enter="transition-transform transition-opacity duration-500 ease-out"
                        x-transition:enter-start="opacity-0 -rotate-90 scale-50"
                        x-transition:enter-end="opacity-100 rotate-0 scale-100"
                        x-transition:leave="transition-transform transition-opacity duration-500 ease-in absolute"
                        x-transition:leave-start="opacity-100 rotate-0 scale-100"
                        x-transition:leave-end="opacity-0 rotate-90 scale-50">
                        <i data-lucide="moon" class="w-5 h-5"></i>
                    </div>
                </button>
                <!-- MOBILE MENU BUTTON -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors relative z-50">
                    <i x-show="!mobileMenuOpen" data-lucide="menu" class="w-6 h-6"></i>
                    <i x-show="mobileMenuOpen" x-cloak data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU PANEL -->
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="absolute top-0 left-0 w-full bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 shadow-lg md:hidden pt-20 pb-8 z-40">

        <div class="px-6 space-y-4">
            <a href="#about" @click="mobileMenuOpen = false"
                :class="activeSection === 'about' ? 'text-primary font-bold' : 'text-gray-700 dark:text-gray-300 font-medium'"
                class="block text-base transition-colors hover:text-gray-900 dark:hover:text-white">Tentang Kami</a>
            <a href="#pricing" @click="mobileMenuOpen = false"
                :class="activeSection === 'pricing' ? 'text-primary font-bold' : 'text-gray-700 dark:text-gray-300 font-medium'"
                class="block text-base transition-colors hover:text-gray-900 dark:hover:text-white">Harga</a>
            <a href="#cara-booking" @click="mobileMenuOpen = false"
                :class="activeSection === 'cara-booking' ? 'text-primary font-bold' : 'text-gray-700 dark:text-gray-300 font-medium'"
                class="block text-base transition-colors hover:text-gray-900 dark:hover:text-white">Cara Booking</a>
            <a href="#contact" @click="mobileMenuOpen = false"
                :class="activeSection === 'contact' ? 'text-primary font-bold' : 'text-gray-700 dark:text-gray-300 font-medium'"
                class="block text-base transition-colors hover:text-gray-900 dark:hover:text-white">Kontak</a>

            <hr class="border-gray-100 dark:border-gray-800">

            <div class="flex flex-col gap-3 pt-2">
                @guest
                    <a href="{{ route('login') }}"
                        class="w-full text-center py-2.5 text-base font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="w-full text-center py-2.5 text-base font-medium text-gray-900 bg-primary rounded-xl shadow-sm hover:bg-primaryHover transition-colors">
                        Daftar Sekarang
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="w-full text-center py-2.5 text-base font-medium text-gray-900 bg-primary rounded-xl shadow-sm hover:bg-primaryHover transition-colors">
                        Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</header>