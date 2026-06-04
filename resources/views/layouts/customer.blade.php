<!DOCTYPE html>
<html lang="en" x-data="{ 
    dark: localStorage.getItem('dark') === 'true',
    sidebarOpen: false,
    isCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
    notificationsOpen: false,
    userMenuOpen: false
}" x-init="
    $watch('dark', val => localStorage.setItem('dark', val));
    $watch('isCollapsed', val => localStorage.setItem('sidebarCollapsed', val));
" :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Customer') | GumbregQuickBook</title>
    <link rel="icon" href="{{ asset('image/logo.webp') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-transition {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content-transition {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body
    class="bg-gray-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans antialiased selection:bg-yellow-500/30 transition-colors duration-300">

    <div class="flex h-screen overflow-hidden">

        <!-- MOBILE OVERLAY -->
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden">
        </div>

        <!-- SIDEBAR -->
        <aside :class="[
                sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                isCollapsed ? 'lg:w-20 w-72' : 'w-72'
            ]"
            class="fixed inset-y-0 left-0 z-50 flex flex-col h-full bg-slate-900 text-slate-300 border-r border-slate-800 shadow-2xl sidebar-transition shrink-0 lg:static lg:flex">

            <!-- HEADER / LOGO -->
            <div class="flex items-center h-20 px-5 shrink-0 relative">
                <div class="flex items-center w-full">
                    <!-- Logo Icon Container (Fixed position) -->
                    <button @click="window.innerWidth >= 1024 ? isCollapsed = !isCollapsed : null"
                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shrink-0 shadow-sm overflow-hidden relative group cursor-default lg:cursor-pointer focus:outline-none transition-all">
                        <img src="{{ asset('image/logo.webp') }}" alt="Logo"
                            class="w-full h-full object-cover transition-opacity duration-300 lg:group-hover:opacity-20">
                        <div
                            class="absolute inset-0 hidden lg:flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <i :data-lucide="isCollapsed ? 'chevrons-right' : 'chevrons-left'"
                                class="w-6 h-6 text-slate-900"></i>
                        </div>
                    </button>

                    <!-- Logo Text (Fades in/out) -->
                    <div x-show="!isCollapsed" x-transition:enter="transition ease-out duration-300 delay-100"
                        x-transition:enter-start="opacity-0 -translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="ml-3 whitespace-nowrap overflow-hidden">
                        <span class="font-bold text-xl tracking-tight text-white">
                            Gumbreg<span class="text-yellow-500">QuickBook</span>
                        </span>
                    </div>
                </div>

                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false"
                    class="lg:hidden absolute right-4 p-1.5 rounded-lg hover:bg-slate-800 transition-colors text-slate-400">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- MENU NAVIGASI -->
            <nav class="flex-1 overflow-y-auto scrollbar-hide px-4 py-4 space-y-1.5">
                @php
                    $menus = [
                        ['route' => 'customer.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                        ['route' => 'booking.create', 'icon' => 'calendar-plus', 'label' => 'Booking Lapangan'],
                        ['route' => 'customer.dashboard', 'anchor' => 'history', 'icon' => 'clipboard-list', 'label' => 'Riwayat Booking'],
                        ['route' => 'customer.vouchers', 'icon' => 'ticket', 'label' => 'Voucher Saya'],
                        ['route' => 'profile.edit', 'icon' => 'user-circle', 'label' => 'Profil Saya'],
                    ];
                @endphp

                @foreach($menus as $menu)
                    @php
                        $isActive = request()->routeIs($menu['route']) && (!isset($menu['anchor']) || str_contains(url()->current(), $menu['anchor']));
                    @endphp
                    <a href="{{ isset($menu['anchor']) ? route($menu['route']) . '#' . $menu['anchor'] : route($menu['route']) }}"
                        @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 group relative overflow-hidden
                                                               {{ $isActive ? 'bg-yellow-500/10 text-yellow-500 font-semibold' : 'hover:bg-slate-800/50 hover:text-white' }}">

                        <!-- Active Indicator -->
                        <div x-show="!isCollapsed"
                            class="absolute left-0 w-1 h-6 bg-yellow-500 rounded-r-full transition-transform duration-300 {{ $isActive ? 'scale-y-100' : 'scale-y-0' }}">
                        </div>

                        <i data-lucide="{{ $menu['icon'] }}"
                            class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ $isActive ? 'text-yellow-500' : 'text-slate-400 group-hover:text-white' }}"></i>

                        <span x-show="!isCollapsed" x-transition:enter="transition ease-out duration-200 delay-100"
                            x-transition:enter-start="opacity-0 -translate-x-2"
                            x-transition:enter-end="opacity-100 translate-x-0" class="text-sm truncate">
                            {{ $menu['label'] }}
                        </span>

                        <!-- Tooltip for collapsed mode -->
                        <div x-show="isCollapsed"
                            class="hidden group-hover:block absolute left-16 bg-slate-800 text-white text-xs px-2 py-1 rounded shadow-xl z-50 whitespace-nowrap">
                            {{ $menu['label'] }}
                        </div>
                    </a>
                @endforeach
            </nav>

            <!-- USER SECTION (BOTTOM) -->
            <div class="p-4 mt-auto border-t border-slate-800 bg-slate-900/50">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="w-full flex items-center gap-3 py-2 rounded-2xl hover:bg-slate-800 transition-all duration-200 group"
                        :class="isCollapsed ? 'justify-center px-0' : 'px-2'">
                        <div
                            class="w-10 h-10 rounded-xl bg-yellow-500 text-slate-900 flex items-center justify-center font-bold shadow-lg shadow-yellow-500/10 group-hover:scale-105 transition-transform shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div x-show="!isCollapsed" class="flex-1 text-left min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Customer</p>
                        </div>
                        <i x-show="!isCollapsed" data-lucide="chevron-up" :class="open ? 'rotate-180' : ''"
                            class="w-4 h-4 text-slate-500 transition-transform"></i>
                    </button>

                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" x-cloak
                        class="absolute bottom-full left-0 mb-2 w-full min-w-[160px] bg-slate-800 border border-slate-700 rounded-2xl shadow-2xl overflow-hidden py-1.5 z-50">

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> Profil Saya
                        </a>
                        <div class="h-px bg-slate-700 my-1.5 mx-2"></div>
                        <button @click="confirmLogout()"
                            class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4 text-red-400"></i> Keluar
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50 dark:bg-slate-950 content-transition overflow-hidden">

            <!-- HEADER -->
            <header
                class="h-16 shrink-0 flex items-center justify-between px-4 md:px-8 z-30 w-full transition-all duration-300 bg-white/80 dark:bg-slate-900/80 shadow-sm backdrop-blur-md border-b border-slate-200/50 dark:border-slate-800/50">

                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>



                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-slate-800 dark:text-white tracking-tight">
                            @yield('title', 'Dashboard')
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Notifications -->
                    <x-notification-dropdown />

                    <!-- Theme Toggle -->
                    <button @click="dark = !dark"
                        class="relative p-2.5 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200 group overflow-hidden flex items-center justify-center w-10 h-10">
                        <div x-show="!dark"
                            x-transition:enter="transition-transform transition-opacity duration-500 ease-out"
                            x-transition:enter-start="opacity-0 rotate-90 scale-50"
                            x-transition:enter-end="opacity-100 rotate-0 scale-100"
                            x-transition:leave="transition-transform transition-opacity duration-500 ease-in absolute"
                            x-transition:leave-start="opacity-100 rotate-0 scale-100"
                            x-transition:leave-end="opacity-0 -rotate-90 scale-50">
                            <i data-lucide="sun" class="w-5 h-5 group-hover:rotate-45 transition-transform"></i>
                        </div>
                        <div x-show="dark" x-cloak
                            x-transition:enter="transition-transform transition-opacity duration-500 ease-out"
                            x-transition:enter-start="opacity-0 -rotate-90 scale-50"
                            x-transition:enter-end="opacity-100 rotate-0 scale-100"
                            x-transition:leave="transition-transform transition-opacity duration-500 ease-in absolute"
                            x-transition:leave-start="opacity-100 rotate-0 scale-100"
                            x-transition:leave-end="opacity-0 rotate-90 scale-50">
                            <i data-lucide="moon" class="w-5 h-5 group-hover:-rotate-12 transition-transform"></i>
                        </div>
                    </button>

                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-700 mx-1 hidden sm:block"></div>

                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen"
                            class="flex items-center gap-2 p-1 pr-3 rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all group">
                            <div
                                class="w-9 h-9 rounded-xl bg-yellow-500 text-slate-900 flex items-center justify-center font-bold shadow-lg shadow-yellow-500/10 group-hover:scale-105 transition-transform">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-xs font-bold text-slate-800 dark:text-white">
                                    {{ explode(' ', auth()->user()->name)[0] }}
                                </p>
                                <p class="text-[9px] text-slate-500 uppercase tracking-tighter">Customer</p>
                            </div>
                            <i data-lucide="chevron-down"
                                class="w-3 h-3 text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                        </button>

                        <div x-show="userMenuOpen" @click.outside="userMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0" x-cloak
                            class="absolute right-0 mt-3 w-48 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl shadow-2xl overflow-hidden py-1.5 z-50">

                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> Profil Saya
                            </a>
                            <div class="h-px bg-slate-100 dark:bg-slate-700 my-1.5"></div>
                            <button @click="confirmLogout()"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            @include('components.sweet-alert')

            <!-- CONTENT AREA -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden w-full p-4 md:p-8 lg:p-10">
                <div class="max-w-7xl mx-auto space-y-8">
                    <div class="sm:hidden mb-6">
                        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">@yield('title', 'Dashboard')</h1>
                        <p class="text-sm text-slate-500 mt-1">GumbregQuickBook Dashboard</p>
                    </div>
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @include('components.chatbot')

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });

        document.addEventListener("alpine:init", () => {
            Alpine.effect(() => {
                nextTick(() => lucide.createIcons());
            });
        });

        function nextTick(callback) {
            requestAnimationFrame(() => requestAnimationFrame(callback));
        }

        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Anda yakin ingin keluar dari sesi ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EAB308',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl dark:bg-slate-800 dark:text-white',
                    title: 'text-xl font-bold',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>

    @stack('scripts')
</body>

</html>