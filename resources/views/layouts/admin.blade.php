<!DOCTYPE html>
<html lang="en" x-data="{ dark: localStorage.getItem('dark') === 'true' }"
    x-init="$watch('dark', val => localStorage.setItem('dark', val))" :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="{{ asset('image/logo.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans antialiased transition-colors duration-200">

    <div x-data="{ sidebarOpen: false, collapsed: false }" class="flex h-screen overflow-hidden">

        <!-- MOBILE OVERLAY -->
        <div x-show="sidebarOpen" x-transition.opacity x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden">
        </div>

        <!-- SIDEBAR -->
        <aside :class="[
                sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                collapsed ? 'lg:w-20' : 'lg:w-64'
            ]"
            class="fixed inset-y-0 left-0 z-50 flex flex-col h-full bg-white dark:bg-gray-900 border-r border-gray-100 dark:border-gray-700 shadow-sm transition-all duration-300 ease-in-out w-64 lg:static lg:flex shrink-0">

            <!-- HEADER / LOGO -->
            <div class="flex items-center h-16 border-b border-gray-100 dark:border-gray-700 shrink-0 px-4"
                :class="collapsed ? 'justify-center' : 'justify-between'">

                <div class="flex items-center gap-2 overflow-hidden whitespace-nowrap" x-show="!collapsed"
                    x-transition.opacity.duration.200ms>
                    <span class="font-bold text-lg tracking-tight">
                        <span class="text-gray-900 dark:text-gray-100">Gumbreg</span><span
                            class="text-yellow-500">QuickBook</span>
                    </span>
                </div>

                <button @click="collapsed = !collapsed"
                    class="hidden lg:flex items-center justify-center p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 text-gray-500 dark:text-gray-400">
                    <i data-lucide="panel-left-close" class="w-5 h-5" x-show="!collapsed"></i>
                    <i data-lucide="panel-left-open" class="w-5 h-5" x-show="collapsed" x-cloak></i>
                </button>

                <!-- Tombol Close Mobile -->
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 text-gray-500 dark:text-gray-400">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- MENU NAVIGASI -->
            <nav
                class="flex-1 overflow-y-auto overflow-x-hidden px-4 py-6 flex flex-col space-y-1.5 text-gray-500 dark:text-gray-400 scrollbar-hide">
                <!-- Dashboard -->
                <a href="/admin/dashboard"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group" :class="[
                        '{{ request()->is('admin/dashboard') }}' === '1'
                        ? 'bg-yellow-50 dark:bg-gray-800 text-yellow-600 dark:text-gray-100 font-medium'
                        : 'hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-800 dark:hover:text-gray-100',
                        collapsed ? 'justify-center' : ''
                    ]" title="Dashboard">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0 transition-colors"
                        :class="'{{ request()->is('admin/dashboard') }}' === '1' ? 'text-yellow-600 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300'"></i>
                    <span x-show="!collapsed" x-transition.opacity.duration.200ms
                        class="text-sm whitespace-nowrap">Dashboard</span>
                </a>

                <!-- Courts -->
                <a href="/admin/courts"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group" :class="[
                        '{{ request()->is('admin/courts*') }}' === '1'
                        ? 'bg-yellow-50 dark:bg-gray-800 text-yellow-600 dark:text-gray-100 font-medium'
                        : 'hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-800 dark:hover:text-gray-100',
                        collapsed ? 'justify-center' : ''
                    ]" title="Data Lapangan">
                    <i data-lucide="circle-star" class="w-5 h-5 shrink-0 transition-colors"
                        :class="'{{ request()->is('admin/courts*') }}' === '1' ? 'text-yellow-600 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300'"></i>
                    <span x-show="!collapsed" x-transition.opacity.duration.200ms class="text-sm whitespace-nowrap">Data
                        Lapangan</span>
                </a>


                <!-- Bookings -->
                <a href="/admin/bookings"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group" :class="[
                        '{{ request()->is('admin/bookings*') }}' === '1'
                        ? 'bg-yellow-50 dark:bg-gray-800 text-yellow-600 dark:text-gray-100 font-medium'
                        : 'hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-800 dark:hover:text-gray-100',
                        collapsed ? 'justify-center' : ''
                    ]" title="Data Pemesanan">
                    <i data-lucide="calendar" class="w-5 h-5 shrink-0 transition-colors"
                        :class="'{{ request()->is('admin/bookings*') }}' === '1' ? 'text-yellow-600 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300'"></i>
                    <span x-show="!collapsed" x-transition.opacity.duration.200ms class="text-sm whitespace-nowrap">Data
                        Pemesanan</span>
                </a>

                <!-- Payments -->
                <a href="/admin/payments"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group" :class="[
                        '{{ request()->is('admin/payments*') }}' === '1'
                        ? 'bg-yellow-50 dark:bg-gray-800 text-yellow-600 dark:text-gray-100 font-medium'
                        : 'hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-800 dark:hover:text-gray-100',
                        collapsed ? 'justify-center' : ''
                    ]" title="Pembayaran">
                    <i data-lucide="wallet" class="w-5 h-5 shrink-0 transition-colors"
                        :class="'{{ request()->is('admin/payments*') }}' === '1' ? 'text-yellow-600 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300'"></i>
                    <span x-show="!collapsed" x-transition.opacity.duration.200ms
                        class="text-sm whitespace-nowrap">Pembayaran</span>
                </a>

                <!-- Users -->
                <a href="{{ route('admin.users') ?? '#' }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group" :class="[
                        '{{ request()->is('admin/users*') }}' === '1'
                        ? 'bg-yellow-50 dark:bg-gray-800 text-yellow-600 dark:text-gray-100 font-medium'
                        : 'hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-800 dark:hover:text-gray-100',
                        collapsed ? 'justify-center' : ''
                    ]" title="Data User">
                    <i data-lucide="users" class="w-5 h-5 shrink-0 transition-colors"
                        :class="'{{ request()->is('admin/users*') }}' === '1' ? 'text-yellow-600 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300'"></i>
                    <span x-show="!collapsed" x-transition.opacity.duration.200ms class="text-sm whitespace-nowrap">Data
                        User</span>
                </a>
            </nav>

            <!-- USER SECTION -->
            <div class="mt-auto p-4 shrink-0 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900">
                <div x-data="{ openUser: false }" class="relative">
                    <button @click="openUser = !openUser"
                        class="w-full flex items-center gap-3 p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-500/50"
                        :class="collapsed ? 'justify-center' : ''">

                        <div
                            class="w-10 h-10 rounded-full bg-yellow-500 text-white flex items-center justify-center font-bold shrink-0 shadow-sm text-lg">
                            {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'A' }}
                        </div>

                        <div x-show="!collapsed" x-transition.opacity.duration.200ms class="flex-1 min-w-0 text-left">
                            <p class="text-sm font-bold text-gray-800 dark:text-gray-100 truncate">
                                {{ Auth::user()->name ?? 'Admin' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">Admin</p>
                        </div>

                        <i x-show="!collapsed" x-transition.opacity.duration.200ms data-lucide="more-vertical"
                            class="w-4 h-4 text-gray-400 dark:text-gray-500 shrink-0"></i>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="openUser" x-transition x-cloak @click.outside="openUser = false"
                        class="absolute bottom-full left-0 mb-2 w-full min-w-[200px] bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-lg z-50 py-1"
                        :class="collapsed ? 'left-14' : 'left-0'">

                        <a href="{{ route('profile.edit') ?? '#' }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700">
                            <i data-lucide="user" class="w-4 h-4 text-gray-400 dark:text-gray-500"></i>
                            Profil Saya
                        </a>

                        <div class="h-px bg-gray-100 dark:bg-gray-700 my-1"></div>

                        <button onclick="confirmLogout()"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:bg-red-50 dark:focus:bg-gray-700">
                            <i data-lucide="log-out" class="w-4 h-4 text-red-500 dark:text-red-400"></i>
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
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors duration-200 shrink-0 focus:outline-none">
                        <i data-lucide="sun" x-show="!dark" class="w-5 h-5"></i>
                        <i data-lucide="moon" x-show="dark" x-cloak class="w-5 h-5"></i>
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