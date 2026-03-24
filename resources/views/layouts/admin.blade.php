<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div x-data="{ open: false }" class="flex">

        <!-- Sidebar -->
        <aside :class="open ? 'w-64' : 'w-20'"
            class="bg-white border-r min-h-screen flex flex-col py-6 shadow-sm transition-all duration-300 ease-in-out">

            <!-- TOP -->
            <div class="flex flex-col items-center px-2 mb-6">

                <!-- BRAND -->
                <div class="mb-4 font-bold text-yellow-500 text-lg">
                    <span x-show="!open">GC</span>
                    <span x-show="open" x-transition>Gumbreg Court</span>
                </div>

                <!-- TOGGLE -->
                <button @click="open = !open"
                    class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-500 transition">

                    <i data-lucide="menu" class="w-5 h-5"></i>

                </button>

            </div>

            <!-- MENU -->
            <nav class="flex flex-col gap-2 px-2">

                <!-- ITEM -->
                <a href="/admin/dashboard" class="flex items-center gap-3 py-2 rounded-lg transition group w-full"
                    :class="(open ? 'px-4 justify-start' : 'justify-center') +
                    (window.location.pathname.includes('dashboard') ?
                        ' bg-yellow-100 text-yellow-500' :
                        ' text-gray-400 hover:bg-yellow-100 hover:text-yellow-500')">

                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>

                    <span x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        Dashboard
                    </span>
                </a>

                <a href="/admin/courts" class="flex items-center gap-3 py-2 rounded-lg transition group w-full"
                    :class="(open ? 'px-4 justify-start' : 'justify-center') +
                    (window.location.pathname.includes('courts') ?
                        ' bg-yellow-100 text-yellow-500' :
                        ' text-gray-400 hover:bg-yellow-100 hover:text-yellow-500')">

                    <i data-lucide="layout-grid" class="w-5 h-5"></i>

                    <span x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        Courts
                    </span>
                </a>

                <a href="/admin/bookings" class="flex items-center gap-3 py-2 rounded-lg transition group w-full"
                    :class="(open ? 'px-4 justify-start' : 'justify-center') +
                    (window.location.pathname.includes('bookings') ?
                        ' bg-yellow-100 text-yellow-500' :
                        ' text-gray-400 hover:bg-yellow-100 hover:text-yellow-500')">

                    <i data-lucide="calendar" class="w-5 h-5"></i>

                    <span x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        Bookings
                    </span>
                </a>

            </nav>

            <!-- BOTTOM -->
            <div class="mt-auto flex flex-col gap-2 px-2">

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 py-2 rounded-lg transition group w-full text-gray-400 hover:text-yellow-500 hover:bg-yellow-100"
                    :class="(open ? 'px-4 justify-start' : 'justify-center')">

                    <i data-lucide="settings"></i>

                    <span x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-x-2"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        Settings</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" onclick="confirmLogout()"
                        class="flex items-center gap-3 py-2 rounded-lg transition group w-full text-red-400 hover:text-red-500 hover:bg-red-50"
                        :class="(open ? 'px-4 justify-start' : 'justify-center')">

                        <i data-lucide="log-out"></i>

                        <span x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-x-2"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0">
                            Logout
                        </span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>
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
    </script>
</body>

</html>
