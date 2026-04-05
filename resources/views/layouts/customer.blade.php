<!DOCTYPE html>

<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-3 flex justify-between items-center">

            {{-- LEFT --}}
            <div class="flex items-center gap-6 md:gap-10">

                {{-- LOGO --}}
                <div class="text-lg md:text-2xl font-bold tracking-tight">
                    <span class="text-gray-900">Gumbreg</span>
                    <span class="text-yellow-500">Court</span>
                </div>

                {{-- MENU DESKTOP --}}
                <div class="hidden md:flex items-center gap-6 text-sm font-medium">

                    <a href="{{ route('customer.dashboard') }}"
                        class="relative pb-2 transition
                    {{ request()->routeIs('customer.dashboard')
                        ? 'text-yellow-500 font-semibold'
                        : 'text-gray-600 hover:text-yellow-500' }}">

                        Dashboard

                        @if (request()->routeIs('customer.dashboard'))
                            <span class="absolute left-0 -bottom-2 w-full h-[2px] bg-yellow-500 rounded"></span>
                        @endif
                    </a>

                    <a href="{{ route('booking.create') }}"
                        class="relative pb-2 transition
                    {{ request()->routeIs('booking.create')
                        ? 'text-yellow-500 font-semibold'
                        : 'text-gray-600 hover:text-yellow-500' }}">

                        Booking

                        @if (request()->routeIs('booking.create'))
                            <span class="absolute left-0 -bottom-2 w-full h-[2px] bg-yellow-500 rounded"></span>
                        @endif
                    </a>

                </div>
            </div>


            {{-- RIGHT --}}
            <div class="flex items-center gap-3">

                {{-- AVATAR (ALL MENU FOR MOBILE, PROFILE FOR DESKTOP) --}}
                <div x-data="{ open: false }" class="relative">

                    <!-- BUTTON -->
                    <button @click="open = !open"
                        class="w-9 h-9 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-500 text-white flex items-center justify-center font-semibold shadow hover:scale-105 transition">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </button>

                    <!-- DROPDOWN -->
                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border overflow-hidden">

                        <!-- USER INFO -->
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Customer</p>
                        </div>

                        <!-- MOBILE NAVIGATION ONLY -->
                        <div class="md:hidden">
                            <a href="{{ route('customer.dashboard') }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                Dashboard
                            </a>

                            <a href="{{ route('booking.create') }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100">
                                <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                                Booking
                            </a>

                            <hr>
                        </div>

                        <!-- PROFILE -->
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            Profile
                        </a>

                        <!-- LOGOUT -->
                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="button" onclick="confirmLogout()"
                                class="w-full flex items-center gap-2 text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                Logout
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-7xl mx-auto p-4 md:p-6">
        @yield('content')
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
