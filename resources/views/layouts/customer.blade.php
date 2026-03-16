<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between">

            <h1 class="font-bold text-lg">
                Gumbreg Court
            </h1>

            <div class="space-x-6">

                <a href="{{ route('customer.dashboard') }}">
                    Dashboard
                </a>

                <a href="{{ route('booking.create') }}">
                    Booking
                </a>

                <a href="{{ route('profile.edit') }}">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-red-500">
                        Logout
                    </button>
                </form>

            </div>

        </div>
    </nav>

    <!-- Content -->
    <div class="p-8">

        @yield('content')

    </div>

</body>

</html>
