<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: false }" :class="sidebarOpen ? 'overflow-hidden' : ''">

    <!-- ================= OVERLAY (MOBILE) ================= -->
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-40 md:hidden" x-cloak>
    </div>

    <!-- ================= SIDEBAR ================= -->
    <aside
        class="fixed top-0 left-0 z-50 h-full w-64 bg-white border-r shadow-sm flex flex-col
               transform transition-transform duration-300 ease-in-out
               md:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <!-- HEADER -->
        <div class="px-6 py-5 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold">
                <span class="text-gray-900">Gumbreg</span>
                <span class="text-yellow-500">QuickBook</span>
            </h2>

            <!-- CLOSE (MOBILE) -->
            <button @click="sidebarOpen = false" class="md:hidden text-xl">
                ✕
            </button>
        </div>

        <!-- MENU (SCROLLABLE) -->
        <div class="flex-1 overflow-y-auto">

            <nav class="mt-6 px-4 space-y-2">

                <a href="{{ route('customer.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                    {{ request()->routeIs('customer.dashboard')
                        ? 'bg-yellow-100 text-yellow-600'
                        : 'text-gray-600 hover:bg-gray-100' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard
                </a>

                <a href="{{ route('booking.create') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                    {{ request()->routeIs('booking.create') ? 'bg-yellow-100 text-yellow-600' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                    Booking
                </a>

            </nav>

        </div>

        <!-- FOOTER USER -->
        <div class="p-4 border-t">

            <div class="flex items-center gap-3 mb-4">
                <div
                    class="w-10 h-10 rounded-full bg-yellow-500 text-white flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Customer</p>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-gray-100 transition">
                <i data-lucide="user" class="w-4 h-4"></i>
                Profile
            </a>

            <!-- LOGOUT -->
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="button" onclick="confirmLogout()"
                    class="w-full flex items-center gap-2 text-left px-3 py-2 text-sm text-red-500 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    Logout
                </button>
            </form>

        </div>

    </aside>

    <!-- ================= MAIN ================= -->
    <div class="min-h-screen md:ml-64 flex flex-col">

        <!-- TOPBAR -->
        <div class="bg-white border-b px-4 md:px-6 py-4 flex justify-between items-center">

            <div class="flex items-center gap-3">
                <!-- HAMBURGER -->
                <button @click="sidebarOpen = true" class="md:hidden text-xl">
                    ☰
                </button>

                <h1 class="text-lg font-semibold text-gray-800">
                    Dashboard
                </h1>
            </div>

            <!-- ACTION -->
            <a href="{{ route('booking.create') }}"
                class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-400 transition">
                Book Court
            </a>

        </div>

        <!-- CONTENT -->
        <main class="p-4 md:p-6 flex-1">
            <div class="max-w-6xl">
                @yield('content')
            </div>
        </main>

    </div>

    <!-- ================= SCRIPT ================= -->
    <script>
        lucide.createIcons();

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
