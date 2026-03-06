<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-6 flex flex-col justify-between">

            <div>
                <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
                <div class="mb-6">
                    <p class="text-sm text-gray-400">Logged in as</p>
                    <p class="font-semibold">{{ Auth::user()->name }}</p>
                </div>
                <ul class="space-y-3">

                    <li>
                        <a href="/admin/dashboard" class="hover:text-gray-300">
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="#" class="hover:text-gray-300">
                            Courts
                        </a>
                    </li>

                    <li>
                        <a href="#" class="hover:text-gray-300">
                            Bookings
                        </a>
                    </li>

                    <li>
                        <a href="#" class="hover:text-gray-300">
                            Customers
                        </a>
                    </li>

                </ul>
            </div>



            <!-- Profile & Logout -->
            <div class="space-y-3 border-t border-gray-700 pt-4">


                <a href="{{ route('profile.edit') }}" class="block hover:text-gray-300">
                    Profile
                </a>

                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="text-red-400 hover:text-red-600">
                        Logout
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
            if (confirm("Apakah Anda yakin ingin logout?")) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
</body>

</html>
