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
</head>

<body class="bg-gray-100">

    <div x-data="{
        open: localStorage.getItem('sidebar') === 'true',
        profileOpen: false
    }" x-init="$watch('open', val => localStorage.setItem('sidebar', val))" class="min-h-screen">

        <!-- SIDEBAR -->
        <aside :style="`width: ${open ? '256px' : '80px'}`"
            class="fixed top-0 left-0 h-screen bg-white border-r flex flex-col py-6 shadow-sm transition-all duration-300 z-50 overflow-y-auto">

            <!-- LOGO -->
            <div class="flex items-center justify-between px-4 mb-6">

                <span x-show="open" class="font-bold text-lg text-gray-800">
                    <span class="text-gray-900">Gumbreg</span>
                    <span class="text-yellow-500">Court</span>
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
                    <i data-lucide="layout-grid"></i>
                    <span x-show="open">Courts</span>
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
                    <span x-show="open">Bookings</span>
                </a>

            </nav>

            <!-- BOTTOM -->
            <div class="mt-auto flex flex-col gap-2 px-2">

                <a href="{{ route('profile.edit') }}" title="Settings"
                    class="flex items-center gap-3 py-2 rounded-lg text-gray-500"
                    :class="open ? 'px-4 hover:bg-gray-100' : 'justify-center hover:bg-gray-100'">
                    <i data-lucide="settings"></i>
                    <span x-show="open">Settings</span>
                </a>

                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" onclick="confirmLogout()" title="Logout"
                        class="flex items-center gap-3 py-2 w-full rounded-lg text-red-400"
                        :class="open ? 'px-4 hover:bg-red-50' : 'justify-center hover:bg-red-50'">
                        <i data-lucide="log-out"></i>
                        <span x-show="open">Logout</span>
                    </button>
                </form>

            </div>

        </aside>

        <!-- MAIN -->
        <div :style="`margin-left: ${open ? '256px' : '80px'}`" class="min-h-screen transition-all duration-300">

            <!--  HEADER -->
            <header
                class="h-16 bg-white border-b px-6 flex justify-between items-start py-3
           sticky top-0 z-40">

                <!-- LEFT -->
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">
                        Dashboard
                    </h1>
                    <p class="text-xs text-gray-400">
                        Overview & analytics
                    </p>
                </div>

                <!-- RIGHT -->
                <div class="flex items-center gap-4 mt-1">

                    <form method="GET" action="{{ route('admin.bookings') }}" class="relative hidden md:block">

                        <!-- ICON -->
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </span>

                        <!-- INPUT -->
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari booking..."
                            class="w-64 h-10 pl-10 pr-4 rounded-full bg-gray-100
           focus:bg-white focus:ring-2 focus:ring-yellow-400
           outline-none text-sm transition shadow-sm">

                    </form>

                    <!-- AVATAR -->
                    <div class="relative">

                        <div @click="profileOpen = !profileOpen"
                            class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center font-bold text-gray-900">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <!-- DROPDOWN -->
                        <div x-show="profileOpen" @click.outside="profileOpen = false"
                            class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-md py-2 z-50">

                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                Profile
                            </a>

                            <button onclick="confirmLogout()"
                                class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100">
                                Logout
                            </button>

                        </div>

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

            searchInput.addEventListener('keyup', function() {

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
