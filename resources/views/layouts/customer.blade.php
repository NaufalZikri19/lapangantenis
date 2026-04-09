<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100 overflow-x-hidden" x-data="{ sidebarOpen: false }">

    <!--  MOBILE OVERLAY  -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-40 md:hidden"
        x-transition.opacity x-cloak>
    </div>

    <!--  MOBILE SIDEBAR  -->
    <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full" @click.outside="sidebarOpen = false"
        class="fixed top-0 left-0 h-screen w-64 bg-white border-r shadow-sm flex flex-col z-50 md:hidden" x-cloak>

        <!-- HEADER -->
        <div class="px-6 py-5 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold">
                <span class="text-gray-900">Gumbreg</span>
                <span class="text-yellow-500">QuickBook</span>
            </h2>
            <button @click="sidebarOpen = false">✕</button>
        </div>

        <!-- MENU -->
        <nav class="mt-6 px-4 space-y-2 flex-1 overflow-y-auto">

            <a href="{{ route('customer.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                {{ request()->routeIs('customer.dashboard')
                    ? 'bg-yellow-100 text-yellow-600'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>

            <a href="{{ route('booking.create') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                {{ request()->routeIs('booking.create') ? 'bg-yellow-100 text-yellow-600' : 'text-gray-600 hover:bg-gray-100' }}">
                <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                Booking
            </a>

        </nav>

        <!-- USER -->
        <div class="p-4 border-t bg-gray-50">
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
                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-gray-100">
                <i data-lucide="user" class="w-4 h-4"></i>
                Profile
            </a>

            <button onclick="confirmLogout()"
                class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-500 rounded-lg hover:bg-red-50">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                Logout
            </button>

            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
            </form>
        </div>
    </aside>

    <!--  DESKTOP SIDEBAR  -->
    <aside class="hidden md:flex fixed top-0 left-0 h-screen w-64 bg-white border-r shadow-sm flex-col z-50">

        <div class="px-6 py-5 border-b">
            <h2 class="text-xl font-bold">
                <span class="text-gray-900">Gumbreg</span>
                <span class="text-yellow-500">QuickBook</span>
            </h2>
        </div>

        <nav class="mt-6 px-4 space-y-2 flex-1 overflow-y-auto">

            <a href="{{ route('customer.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                {{ request()->routeIs('customer.dashboard')
                    ? 'bg-yellow-100 text-yellow-600'
                    : 'text-gray-600 hover:bg-gray-100' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                Dashboard
            </a>

            <a href="{{ route('booking.create') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                {{ request()->routeIs('booking.create') ? 'bg-yellow-100 text-yellow-600' : 'text-gray-600 hover:bg-gray-100' }}">
                <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                Booking
            </a>

        </nav>

        <!-- USER -->
        <div class="p-4 border-t bg-gray-50">
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
                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-gray-100">
                <i data-lucide="user" class="w-4 h-4"></i>
                Profile
            </a>

            <button onclick="confirmLogout()"
                class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-500 rounded-lg hover:bg-red-50">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                Logout
            </button>

            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
            </form>
        </div>
    </aside>

    <!--  MAIN  -->
    <div class="md:ml-64 flex flex-col min-h-screen">

        <!-- TOPBAR -->
        <header class="bg-white border-b px-6 py-4 flex justify-between items-center sticky top-0 z-40">

            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="md:hidden text-xl">☰</button>

                <h1 class="text-lg font-semibold">
                    @yield('title', 'Dashboard')
                </h1>
            </div>

            <div class="flex items-center gap-4">

                <!-- SEARCH -->
                <form method="GET" action="{{ route('customer.dashboard') }}"
                    class="hidden md:flex items-center bg-gray-100 px-3 py-2 rounded-lg">

                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search booking..." class="bg-transparent outline-none text-sm ml-2 w-40">
                </form>

                <!-- USER DROPDOWN -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-full bg-yellow-500 text-white flex items-center justify-center text-sm font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden md:block text-sm font-medium">
                            {{ auth()->user()->name }}
                        </span>
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </button>

                    <!-- DROPDOWN -->
                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow border" x-cloak>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                            Profile
                        </a>

                        <button onclick="confirmLogout()"
                            class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                            Logout
                        </button>
                    </div>
                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="p-6 flex-1">
            <div class="max-w-6xl mx-auto space-y-6">
                @yield('content')
            </div>
        </main>

    </div>

    <!--  SCRIPT  -->
    <script>
        lucide.createIcons();

        document.addEventListener("alpine:init", () => {
            Alpine.effect(() => {
                lucide.createIcons();
            });
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Logout?',
                text: "Anda yakin ingin keluar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FBBF24',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

</body>

</html>
