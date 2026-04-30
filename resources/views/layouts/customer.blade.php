<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Customer')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen overflow-hidden">

        <!-- MOBILE OVERLAY -->
        <div x-show="sidebarOpen" x-transition.opacity x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden">
        </div>

        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 flex flex-col h-full bg-white border-r border-gray-100 shadow-sm transition-transform duration-300 w-64 shrink-0">

            <!-- HEADER / LOGO -->
            <div class="flex items-center justify-between px-6 h-16 border-b border-gray-100 shrink-0">
                <div class="flex items-center gap-2 overflow-hidden whitespace-nowrap">
                    <span class="font-bold text-lg tracking-tight">
                        <span class="text-gray-900">Gumbreg</span><span class="text-yellow-500">QuickBook</span>
                    </span>
                </div>

                <!-- Tombol Close Mobile -->
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-gray-500">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- MENU NAVIGASI -->
            <nav
                class="flex-1 overflow-y-auto overflow-x-hidden px-4 py-6 flex flex-col space-y-1.5 text-gray-500 scrollbar-hide">

                <a href="{{ route('customer.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group
                    {{ request()->routeIs('customer.dashboard') ? 'bg-yellow-50 text-yellow-600 font-medium' : 'hover:bg-gray-100 hover:text-gray-800' }}">
                    <i data-lucide="layout-dashboard"
                        class="w-5 h-5 shrink-0 transition-colors {{ request()->routeIs('customer.dashboard') ? 'text-yellow-600' : 'text-gray-500 group-hover:text-gray-700' }}"></i>
                    <span class="text-sm">Dashboard</span>
                </a>

                <a href="{{ route('booking.create') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group
                    {{ request()->routeIs('booking.create') ? 'bg-yellow-50 text-yellow-600 font-medium' : 'hover:bg-gray-100 hover:text-gray-800' }}">
                    <i data-lucide="calendar-plus"
                        class="w-5 h-5 shrink-0 transition-colors {{ request()->routeIs('booking.create') ? 'text-yellow-600' : 'text-gray-500 group-hover:text-gray-700' }}"></i>
                    <span class="text-sm">Booking Lapangan</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group hover:bg-gray-100 hover:text-gray-800">
                    <i data-lucide="user"
                        class="w-5 h-5 shrink-0 transition-colors text-gray-500 group-hover:text-gray-700"></i>
                    <span class="text-sm">Profil Saya</span>
                </a>

            </nav>

            <!-- USER SECTION -->
            <div class="mt-auto p-4 shrink-0 border-t border-gray-100 bg-gray-50/50">
                <div x-data="{ openUser: false }" class="relative">
                    <button @click="openUser = !openUser"
                        class="w-full flex items-center gap-3 p-2 rounded-xl hover:bg-gray-200/50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-500/50">

                        <div
                            class="w-9 h-9 rounded-full bg-yellow-500 text-white flex items-center justify-center font-bold shrink-0 shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="flex-1 min-w-0 text-left">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">Customer</p>
                        </div>

                        <i data-lucide="more-vertical" class="w-4 h-4 text-gray-400 shrink-0"></i>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="openUser" x-transition x-cloak @click.outside="openUser = false"
                        class="absolute bottom-full left-0 mb-2 w-full min-w-[200px] bg-white border border-gray-100 rounded-xl shadow-lg z-50 py-1">

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none focus:bg-gray-50">
                            <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                            Profil Saya
                        </a>

                        <div class="h-px bg-gray-100 my-1"></div>

                        <button onclick="confirmLogout()"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors focus:outline-none focus:bg-red-50">
                            <i data-lucide="log-out" class="w-4 h-4 text-red-500"></i>
                            Keluar
                        </button>
                    </div>
                </div>

                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
            </div>
        </aside>

        <!-- MAIN WRAPPER -->
        <div class="flex-1 flex flex-col min-w-0 lg:ml-64 bg-gray-50 h-screen">

            <!-- HEADER -->
            <header
                class="h-16 shrink-0 flex items-center justify-between px-4 md:px-6 bg-white border-b border-gray-100 shadow-sm z-30 w-full transition-all duration-300">
                <div class="flex items-center gap-4 min-w-0">
                    <!-- Hamburger Mobile -->
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 -ml-2 rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 transition-colors shrink-0">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>

                    <div class="min-w-0">
                        <h1 class="text-lg sm:text-xl font-semibold text-gray-800 truncate flex items-center gap-2">
                            @yield('title', 'Dashboard')
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <div class="hidden sm:flex flex-col items-end text-sm">
                        <span class="font-medium text-gray-800">{{ auth()->user()->name }}</span>
                        <span class="text-xs text-gray-500">Customer</span>
                    </div>
                    <div
                        class="w-9 h-9 rounded-full bg-yellow-500 text-white flex items-center justify-center font-bold shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- CONTENT AREA -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden w-full p-4 md:p-6 lg:p-8">
                <div class="w-full mx-auto space-y-6">
                    @yield('content')
                </div>
            </main>

        </div>

    </div>

    <!-- CHATBOT -->
    @include('components.chatbot')

    <!-- SCRIPT INIT -->
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
                confirmButtonColor: '#eab308',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'rounded-lg',
                    cancelButton: 'rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

</body>

</html>