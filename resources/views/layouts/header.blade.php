<header x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100 py-3' : 'bg-transparent py-5'"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between">

            <!-- LOGO -->
            <a href="/" class="flex items-center gap-2 group">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Gumbreg QuickBook"
                    class="w-10 h-10 rounded-xl shadow-sm group-hover:scale-105 transition-transform duration-200 object-cover bg-white">
                <span class="text-xl font-bold tracking-tight text-gray-900">
                    Gumbreg<span class="text-primary">QuickBook</span>
                </span>
            </a>

            <!-- DESKTOP MENU -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#about"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200">Tentang
                    Kami</a>
                <a href="#pricing"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200">Harga</a>
                <a href="#cara-booking"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200">Cara
                    Booking</a>
                <a href="#kontak"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200">Kontak</a>
            </nav>

            <!-- AUTH BUTTONS -->
            <div class="hidden md:flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200">
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

            <!-- MOBILE MENU BUTTON -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                <i x-show="!mobileMenuOpen" data-lucide="menu" class="w-6 h-6"></i>
                <i x-show="mobileMenuOpen" x-cloak data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
    </div>

    <!-- MOBILE MENU PANEL -->
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="absolute top-full left-0 w-full bg-white border-b border-gray-100 shadow-lg md:hidden">

        <div class="px-6 py-4 space-y-4">
            <a href="#about" @click="mobileMenuOpen = false"
                class="block text-base font-medium text-gray-700 hover:text-primary transition-colors">Tentang Kami</a>
            <a href="#pricing" @click="mobileMenuOpen = false"
                class="block text-base font-medium text-gray-700 hover:text-primary transition-colors">Harga</a>
            <a href="#cara-booking" @click="mobileMenuOpen = false"
                class="block text-base font-medium text-gray-700 hover:text-primary transition-colors">Cara Booking</a>
            <a href="#kontak" @click="mobileMenuOpen = false"
                class="block text-base font-medium text-gray-700 hover:text-primary transition-colors">Kontak</a>

            <hr class="border-gray-100">

            <div class="flex flex-col gap-3 pt-2">
                @guest
                    <a href="{{ route('login') }}"
                        class="w-full text-center py-2.5 text-base font-medium text-gray-700 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
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