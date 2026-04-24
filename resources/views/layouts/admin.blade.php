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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

    <div x-data="{
        open: localStorage.getItem('sidebar') === 'true',
        profileOpen: false
    }" x-init="$watch('open', val => localStorage.setItem('sidebar', val))" class="min-h-screen">

        <!-- SIDEBAR -->
        <aside :style="`width: ${open ? '256px' : '80px'}`"
            class="fixed top-0 left-0 h-screen bg-white border-r flex flex-col pt-6 shadow-sm transition-all duration-300 z-50 overflow-y-auto">

            <!-- LOGO -->
            <div class="flex items-center justify-between px-4 mb-6">

                <span x-show="open" class="font-bold text-lg text-gray-800">
                    <span class="text-gray-900">Gumbreg</span>
                    <span class="text-yellow-500">QuickBook</span>
                </span>

                <button @click="open = !open" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                    <i data-lucide="menu"></i>
                </button>

            </div>

            <!-- MENU -->
            <nav class="flex flex-col gap-2 text-gray-500 px-2">

                <a href="/admin/dashboard" title="Dashboard" class="flex items-center gap-3 py-2 rounded-lg transition"
                    :class="[
                        open ? 'px-4' : 'justify-center',
                        '{{ request()->is('admin/dashboard') }}'
                        === '1' ?
                        'bg-yellow-100 text-yellow-500' :
                        'hover:bg-yellow-100 hover:text-yellow-500'
                    ]">
                    <i data-lucide="layout-dashboard"></i>
                    <span x-show="open">Dashboard</span>
                </a>

                <a href="/admin/courts" title="Courts" class="flex items-center gap-3 py-2 rounded-lg transition"
                    :class="[
                        open ? 'px-4' : 'justify-center',
                        '{{ request()->is('admin/courts*') }}'
                        === '1' ?
                        'bg-yellow-100 text-yellow-500' :
                        'hover:bg-yellow-100 hover:text-yellow-500'
                    ]">
                    <i data-lucide="circle-star"></i>
                    <span x-show="open">Data Lapangan</span>
                </a>

                <a href="/admin/bookings" title="Bookings" class="flex items-center gap-3 py-2 rounded-lg transition"
                    :class="[
                        open ? 'px-4' : 'justify-center',
                        '{{ request()->is('admin/bookings*') }}'
                        === '1' ?
                        'bg-yellow-100 text-yellow-500' :
                        'hover:bg-yellow-100 hover:text-yellow-500'
                    ]">
                    <i data-lucide="calendar"></i>
                    <span x-show="open">Data Pemesanan</span>
                </a>

                <a href="/admin/payments" title="Payments" class="flex items-center gap-3 py-2 rounded-lg transition"
                    :class="[
                        open ? 'px-4' : 'justify-center',
                        '{{ request()->is('admin/payments*') }}'
                        === '1' ?
                        'bg-yellow-100 text-yellow-500' :
                        'hover:bg-yellow-100 hover:text-yellow-500'
                    ]">
                    <i data-lucide="credit-card"></i>
                    <span x-show="open">Pembayaran</span>
                </a>

                <a href="{{ route('admin.users') }}" title="Users"
                    class="flex items-center gap-3 py-2 rounded-lg transition" :class="[
        open ? 'px-4' : 'justify-center',
        '{{ request()->is('admin/users*') }}'
        === '1'
        ? 'bg-yellow-100 text-yellow-500'
        : 'hover:bg-yellow-100 hover:text-yellow-500'
    ]">

                    <i data-lucide="users"></i>

                    <span x-show="open">Data User</span>
                </a>
            </nav>

            <!-- USER DROPDOWN -->
            <div class="mt-auto p-3 border-t bg-gray-50">

                <div x-data="{ openUser: false }" class="relative">

                    <!-- TRIGGER -->
                    <button @click="openUser = !openUser"
                        class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 transition">

                        <!-- AVATAR -->
                        <div
                            class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center font-bold text-gray-900">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <!-- INFO -->
                        <div class="flex-1 text-left" x-show="open">
                            <p class="text-sm font-semibold text-gray-800">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 truncate">
                                {{ Auth::user()->email }}
                            </p>
                        </div>

                        <!-- ICON -->
                        <i data-lucide="chevron-up" class="w-4 h-4 text-gray-400 transition-transform"
                            :class="openUser ? 'rotate-180' : ''" x-show="open">
                        </i>

                    </button>

                    <!-- DROPDOWN (DROP-UP) -->
                    <div x-show="openUser" @click.outside="openUser = false" x-transition
                        class="absolute bottom-full left-0 mb-2 w-full bg-white border rounded-xl shadow-lg overflow-hidden z-50">

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

                <!-- FORM LOGOUT -->
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>

            </div>

        </aside>

        <!-- MAIN -->
        <div :style="`margin-left: ${open ? '256px' : '80px'}`" class="min-h-screen transition-all duration-300">

            <!--  HEADER -->
            <header class="sticky top-0 z-40 bg-gray-50 border-b px-8 py-5">

                <div class="flex items-start gap-4 max-w-7xl">

                    <!-- ACCENT -->
                    <div class="w-1.5 h-10 bg-yellow-400 rounded-full mt-1"></div>

                    <!-- TEXT -->
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">
                            Selamat Datang, {{ Auth::user()->name }}
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Kelola seluruh aktivitas sistem dengan mudah
                        </p>
                    </div>

                </div>

            </header>

            <!-- CONTENT -->
            <main class="p-6 md:p-8">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- ICON INIT -->
    <script>
        lucide.createIcons();
    </script>

    <!-- LOGOUT -->
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


        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');

        if (searchInput) {

            let timeout;

            searchInput.addEventListener('keyup', function () {

                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    this.form.submit(); //  kirim ke backend
                }, 500);

            });

            clearBtn.addEventListener('click', () => {
                searchInput.value = '';
                searchInput.form.submit();
            });
        }
    </script>

</body>

</html>