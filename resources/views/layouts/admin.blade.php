<!DOCTYPE html>
<html lang="en" x-data="{ dark: localStorage.getItem('dark') === 'true' }"
    x-init="$watch('dark', val => localStorage.setItem('dark', val))" :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="{{ asset('image/logo.webp') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])



    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans antialiased transition-colors duration-200">

    <div x-data="{ 
        sidebarOpen: false, 
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true' 
    }" x-init="$watch('collapsed', val => localStorage.setItem('sidebarCollapsed', val))"
        class="flex h-screen overflow-hidden">

        <!-- MOBILE OVERLAY -->
        <div x-show="sidebarOpen" x-transition.opacity x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden">
        </div>

        <!-- SIDEBAR -->
        <aside :class="[
                sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                collapsed ? 'lg:w-20 w-72' : 'w-72'
            ]"
            class="fixed inset-y-0 left-0 z-50 flex flex-col h-full bg-slate-900 text-slate-300 border-r border-slate-800 shadow-2xl transition-all duration-300 ease-in-out shrink-0 lg:static lg:flex">

            <!-- HEADER / LOGO -->
            <div class="flex items-center h-20 px-4 shrink-0 relative"
                :class="collapsed ? 'justify-center' : 'justify-between'">

                <div class="flex items-center gap-3 overflow-hidden w-full" :class="collapsed ? 'justify-center' : ''">
                    <!-- Logo Icon Container -->
                    <button @click="window.innerWidth >= 1024 ? collapsed = !collapsed : null"
                        class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shrink-0 shadow-sm overflow-hidden relative group cursor-default lg:cursor-pointer focus:outline-none transition-all">
                        <img src="{{ asset('image/logo.webp') }}" alt="Logo"
                            class="w-full h-full object-cover transition-opacity duration-300 lg:group-hover:opacity-20">
                        <div
                            class="absolute inset-0 hidden lg:flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <i :data-lucide="collapsed ? 'panel-left-open' : 'panel-left-close'"
                                class="w-5 h-5 text-slate-900"></i>
                        </div>
                    </button>

                    <!-- Logo Text -->
                    <div x-show="!collapsed" x-transition.opacity.duration.200ms
                        class="whitespace-nowrap overflow-hidden">
                        <span class="font-bold text-xl tracking-tight text-white">
                            Gumbreg<span class="text-yellow-500">QuickBook</span>
                        </span>
                    </div>
                </div>



                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-lg hover:bg-slate-800 transition-colors text-slate-400 shrink-0">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- MENU NAVIGASI -->
            <nav class="flex-1 overflow-y-auto scrollbar-hide px-4 py-4 space-y-1.5">
                @php
                    $menus = [
                        ['url' => '/admin/dashboard', 'path' => 'admin/dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                        ['url' => '/admin/courts', 'path' => 'admin/courts*', 'icon' => 'circle-star', 'label' => 'Data Lapangan'],
                        ['url' => '/admin/bookings', 'path' => 'admin/bookings*', 'icon' => 'calendar', 'label' => 'Data Pemesanan'],
                        ['url' => '/admin/payments', 'path' => 'admin/payments*', 'icon' => 'wallet', 'label' => 'Pembayaran'],
                        ['url' => route('admin.users'), 'path' => 'admin/users*', 'icon' => 'users', 'label' => 'Data User'],
                    ];
                @endphp

                @foreach($menus as $menu)
                    @php
                        $isActive = request()->is($menu['path']);
                    @endphp
                    <a href="{{ $menu['url'] }}"
                        class="flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 group relative overflow-hidden
                                                                                   {{ $isActive ? 'bg-yellow-500/10 text-yellow-500 font-semibold' : 'hover:bg-slate-800/50 hover:text-white' }}"
                        title="{{ $menu['label'] }}">

                        <!-- Active Indicator -->
                        <div x-show="!collapsed"
                            class="absolute left-0 w-1 h-6 bg-yellow-500 rounded-r-full transition-transform duration-300 {{ $isActive ? 'scale-y-100' : 'scale-y-0' }}">
                        </div>

                        <i data-lucide="{{ $menu['icon'] }}"
                            class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ $isActive ? 'text-yellow-500' : 'text-slate-400 group-hover:text-white' }}"></i>

                        <span x-show="!collapsed" x-transition.opacity.duration.200ms
                            class="text-sm truncate whitespace-nowrap">
                            {{ $menu['label'] }}
                        </span>

                        <!-- Tooltip for collapsed mode -->
                        <div x-show="collapsed"
                            class="hidden group-hover:block absolute left-16 bg-slate-800 text-white text-xs px-2 py-1 rounded shadow-xl z-50 whitespace-nowrap">
                            {{ $menu['label'] }}
                        </div>
                    </a>
                @endforeach
            </nav>

            <!-- USER SECTION (BOTTOM) -->
            <div class="p-4 mt-auto border-t border-slate-800 bg-slate-900/50">
                <div x-data="{ openUser: false }" class="relative">
                    <button @click="openUser = !openUser"
                        class="w-full flex items-center gap-3 py-2 rounded-2xl hover:bg-slate-800 transition-all duration-200 group"
                        :class="collapsed ? 'justify-center px-0' : 'px-2'">

                        <div
                            class="w-10 h-10 rounded-xl bg-yellow-500 text-slate-900 flex items-center justify-center font-bold shadow-lg shadow-yellow-500/10 group-hover:scale-105 transition-transform shrink-0">
                            {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'A' }}
                        </div>

                        <div x-show="!collapsed" x-transition.opacity.duration.200ms class="flex-1 text-left min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-slate-400 truncate">Admin</p>
                        </div>

                        <i x-show="!collapsed" data-lucide="more-vertical" class="w-4 h-4 text-slate-500 shrink-0"></i>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="openUser" x-transition x-cloak @click.outside="openUser = false"
                        class="absolute bottom-full left-0 mb-2 w-full min-w-[200px] bg-slate-800 border border-slate-700 rounded-xl shadow-xl z-50 py-1"
                        :class="collapsed ? 'left-14' : 'left-0'">

                        <a href="{{ route('profile.edit') ?? '#' }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            Profil Saya
                        </a>

                        <div class="h-px bg-slate-700 my-1"></div>

                        <button onclick="confirmLogout()"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-slate-700 hover:text-red-300 transition-colors text-left">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            Keluar
                        </button>
                    </div>
                </div>

                <form id="logout-form" method="POST" action="{{ route('logout') ?? '#' }}" class="hidden">
                    @csrf
                </form>
            </div>
        </aside>

        <!-- MAIN LAYOUT -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50 dark:bg-gray-900">

            <!-- HEADER -->
            <header
                class="h-16 shrink-0 flex items-center justify-between px-4 sm:px-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm z-30 w-full transition-all duration-300">
                <div class="flex items-center gap-4 min-w-0">
                    <!-- Hamburger Mobile -->
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 -ml-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 transition-colors shrink-0">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>

                    <div class="hidden sm:block w-1 h-8 bg-yellow-400 rounded-full shrink-0"></div>

                    <div class="min-w-0">
                        <h1 class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-100 truncate">
                            Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden sm:block truncate">
                            Kelola seluruh aktivitas sistem dengan mudah
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 ml-auto">
                    <!-- Notification Dropdown -->
                    <x-notification-dropdown />

                    <!-- Theme Toggle Button -->
                    <button @click="dark = !dark"
                        class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors duration-200 shrink-0 focus:outline-none overflow-hidden flex items-center justify-center w-9 h-9">
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
                </div>
            </header>

            <!-- SweetAlert Component -->
            @include('components.sweet-alert')

            <!-- CONTENT AREA -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden w-full p-3 sm:p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- INIT -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });

        document.addEventListener("alpine:updated", () => {
            lucide.createIcons();
        });

        function confirmLogout() {
            Alert.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin keluar dari sistem?",
                icon: 'question',
                confirmButtonText: 'Ya, Keluar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

    @stack('scripts')

</body>

</html>