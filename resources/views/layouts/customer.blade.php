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

            <!-- LEFT -->
            <div class="flex items-center gap-4 md:gap-8">

                <!-- Logo -->
                <div class="text-lg md:text-2xl font-bold tracking-tight">
                    <span class="text-gray-900">Gumbreg</span>
                    <span class="text-yellow-500">Court</span>
                </div>

                <!-- Menu (Desktop only) -->
                <div class="hidden md:flex items-center gap-6 text-sm font-medium">

                    <a href="{{ route('customer.dashboard') }}"
                        class="{{ request()->routeIs('customer.dashboard') ? 'text-yellow-500 font-semibold' : 'text-gray-600 hover:text-yellow-500' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('booking.create') }}"
                        class="{{ request()->routeIs('booking.create') ? 'text-yellow-500 font-semibold' : 'text-gray-600 hover:text-yellow-500' }}">
                        Booking
                    </a>

                </div>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">

                <!-- Mobile Menu Button -->
                <div x-data="{ mobileMenu: false }" class="md:hidden">

                    <button @click="mobileMenu = !mobileMenu" class="text-gray-600 focus:outline-none">
                        ☰
                    </button>

                    <!-- Mobile Dropdown -->
                    <div x-show="mobileMenu" @click.outside="mobileMenu = false"
                        class="absolute right-4 mt-3 w-40 bg-white rounded-lg shadow-lg border z-50">

                        <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                            Dashboard
                        </a>

                        <a href="{{ route('booking.create') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                            Booking
                        </a>
                    </div>
                </div>

                <!-- Avatar Dropdown -->
                <div x-data="{ open: false }" class="relative">

                    <button @click="open = !open"
                        class="w-9 h-9 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-500 text-white flex items-center justify-center font-semibold shadow hover:scale-105 transition">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border z-50">

                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100">
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

</body>

</html>
