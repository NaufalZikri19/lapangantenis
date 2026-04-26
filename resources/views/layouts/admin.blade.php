<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

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

<body class="bg-gray-100">

    <div x-data="{
    open: false,
    isDesktop: window.innerWidth >= 768
}" x-init="
    window.addEventListener('resize', () => {
        isDesktop = window.innerWidth >= 768
        if(isDesktop) open = true
    })
" class="min-h-screen flex">

        <!-- SIDEBAR -->
        <aside :class="open ? 'w-64' : 'w-20'"
            class="hidden md:flex flex-col bg-white border-r shadow-sm transition-all duration-300 h-screen sticky top-0">

            <!-- LOGO -->
            <div class="flex items-center justify-between px-4 py-4">
                <span x-show="open" class="font-bold text-lg text-gray-800">
                    <span>Gumbreg</span>
                    <span class="text-yellow-500">QuickBook</span>
                </span>

                <button @click="open = !open" class="p-2 rounded-lg hover:bg-gray-100">
                    <i data-lucide="menu"></i>
                </button>
            </div>

            <!-- MENU -->
            <nav class="flex flex-col gap-2 px-2 text-gray-500">

                <a href="/admin/dashboard" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/dashboard') }}' === '1'
                    ? 'bg-yellow-100 text-yellow-500'
                    : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="layout-dashboard"></i>
                    <span x-show="open">Dashboard</span>
                </a>

                <a href="/admin/courts" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/courts*') }}' === '1'
                    ? 'bg-yellow-100 text-yellow-500'
                    : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="circle-star"></i>
                    <span x-show="open">Data Lapangan</span>
                </a>

                <a href="/admin/bookings" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/bookings*') }}' === '1'
                    ? 'bg-yellow-100 text-yellow-500'
                    : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="calendar"></i>
                    <span x-show="open">Data Pemesanan</span>
                </a>

                <a href="/admin/payments" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/payments*') }}' === '1'
                    ? 'bg-yellow-100 text-yellow-500'
                    : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="credit-card"></i>
                    <span x-show="open">Pembayaran</span>
                </a>

                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/users*') }}' === '1'
                    ? 'bg-yellow-100 text-yellow-500'
                    : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="users"></i>
                    <span x-show="open">Data User</span>
                </a>

            </nav>

            <!-- USER -->
            <div class="mt-auto p-3 border-t bg-gray-50">

                <div x-data="{ openUser: false }" class="relative">

                    <button @click="openUser = !openUser"
                        class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">

                        <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <div x-show="open" class="flex-1 text-left">
                            <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>

                        <i data-lucide="chevron-up" class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="openUser ? 'rotate-180' : ''" x-show="open">
                        </i>

                    </button>

                    <div x-show="openUser" x-transition @click.outside="openUser = false"
                        class="absolute bottom-full left-0 mb-2 w-56 bg-white border rounded-xl shadow-lg z-50 overflow-hidden">

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100 transition">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            Profil
                        </a>

                        <button onclick="confirmLogout()"
                            class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            Logout
                        </button>

                    </div>
                </div>

                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>

            </div>

        </aside>


        <!-- MOBILE SIDEBAR -->
        <div x-show="open && !isDesktop" class="fixed inset-0 bg-black/40 z-40" @click="open = false"></div>

        <aside x-show="open && !isDesktop" x-cloak class="fixed top-0 left-0 w-64 h-full bg-white z-50 shadow"
            @click.stop>

            <div class="p-4 font-bold">Menu</div>

            <nav class="flex flex-col gap-2 px-2 text-gray-500">

                <a href="/admin/dashboard" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/dashboard') }}' === '1'
                        ? 'bg-yellow-100 text-yellow-500'
                        : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="layout-dashboard"></i>
                    <span x-show="open">Dashboard</span>
                </a>

                <a href="/admin/courts" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/courts*') }}' === '1'
                        ? 'bg-yellow-100 text-yellow-500'
                        : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="circle-star"></i>
                    <span x-show="open">Data Lapangan</span>
                </a>

                <a href="/admin/bookings" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/bookings*') }}' === '1'
                        ? 'bg-yellow-100 text-yellow-500'
                        : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="calendar"></i>
                    <span x-show="open">Data Pemesanan</span>
                </a>

                <a href="/admin/payments" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/payments*') }}' === '1'
                        ? 'bg-yellow-100 text-yellow-500'
                        : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="credit-card"></i>
                    <span x-show="open">Pembayaran</span>
                </a>

                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
                    open ? 'px-4' : 'justify-center',
                    '{{ request()->is('admin/users*') }}' === '1'
                        ? 'bg-yellow-100 text-yellow-500'
                        : 'hover:bg-yellow-100 hover:text-yellow-500'
                ]">
                    <i data-lucide="users"></i>
                    <span x-show="open">Data User</span>
                </a>

            </nav>

            <div class="mt-auto p-3 border-t bg-gray-50">

                <div x-data="{ openUser: false }" class="relative">

                    <button @click="openUser = !openUser"
                        class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">

                        <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <div x-show="open" class="flex-1 text-left">
                            <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </button>

                    <div x-show="openUser" @click.outside="openUser = false"
                        class="absolute bottom-full mb-2 w-full bg-white border rounded-xl shadow">

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
                            Profil
                        </a>

                        <button onclick="confirmLogout()"
                            class="w-full text-left px-4 py-2 text-red-500 hover:bg-red-50">
                            Logout
                        </button>

                    </div>
                </div>

                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>

            </div>

        </aside>


        <!-- MAIN -->
        <div class="flex-1 flex flex-col">

            <!-- HEADER -->
            <header class="bg-gray-50 border-b px-4 md:px-6 lg:px-8 py-5">

                <div class="flex items-center gap-4 w-full">

                    <!-- MOBILE BTN -->
                    <button @click="open = true" class="md:hidden">
                        <i data-lucide="menu"></i>
                    </button>

                    <div class="w-1.5 h-10 bg-yellow-400 rounded-full"></div>

                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">
                            Selamat Datang, {{ Auth::user()->name }}
                        </h1>

                        <p class="text-sm text-gray-500">
                            Kelola seluruh aktivitas sistem dengan mudah
                        </p>
                    </div>

                </div>

            </header>


            <!-- CONTENT -->
            <main :class="open ? 'max-w-7xl mx-auto' : 'max-w-full'"
                class="p-3 sm:p-4 md:p-6 lg:p-8 w-full transition-all duration-300">
                @yield('content')
            </main>

        </div>

    </div>


    <!-- INIT -->
    <script>
        lucide.createIcons();
    </script>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Logout?',
                text: "Anda yakin ingin keluar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FBBF24',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        document.addEventListener("alpine:updated", () => {
            lucide.createIcons();
        });

    </script>

</body>

</html>