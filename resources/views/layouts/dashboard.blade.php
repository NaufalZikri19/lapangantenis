<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ config('app.name') }}</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-gray-900 text-gray-300 flex flex-col">

            <!-- LOGO -->
            <div class="h-16 flex items-center px-6 border-b border-gray-800">
                <h2 class="text-white font-semibold text-lg">
                    Gumbreg Court
                </h2>
            </div>

            <!-- MENU -->
            <nav class="flex-1 px-4 py-6 space-y-2 text-sm">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg bg-gray-800 text-white">

                    <span>🏠</span>
                    Dashboard

                </a>

                <a href="{{ route('booking') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800">

                    <span>📅</span>
                    Booking Saya

                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800">

                    <span>📋</span>
                    Jadwal Lapangan

                </a>

            </nav>

        </aside>


        <!-- MAIN AREA -->
        <div class="flex flex-col flex-1 overflow-hidden">

            <!-- TOPBAR -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">

                <!-- SEARCH -->
                <div class="w-96">
                    <input type="text" placeholder="Search..."
                        class="w-full bg-gray-100 rounded-lg px-4 py-2 text-sm focus:outline-none">
                </div>

                <!-- User -->
                <div class="relative">

                    <button onclick="toggleUserMenu()" class="flex items-center gap-3">

                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                            class="w-8 h-8 rounded-full">

                        <span class="text-sm font-medium text-gray-700">
                            {{ auth()->user()->name }}
                        </span>

                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>

                    </button>

                    <!-- DROPDOWN -->
                    <div id="userMenu" class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border hidden">

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Your profile
                        </a>

                        <button onclick="openLogoutModal()"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            Logout
                        </button>

                    </div>

                </div>

            </header>


            <!-- CONTENT -->
            <main class="flex-1 overflow-y-auto p-8">

                {{ $slot }}

            </main>

        </div>

    </div>


    <!-- LOGOUT MODAL -->
    <div id="logoutModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center">

        <div class="bg-white rounded-xl shadow-lg p-6 w-96">

            <h2 class="text-lg font-semibold mb-3">
                Konfirmasi Logout
            </h2>

            <p class="text-sm text-gray-600 mb-6">
                Apakah Anda yakin ingin keluar?
            </p>

            <div class="flex justify-end gap-3">

                <button onclick="closeLogoutModal()" class="px-4 py-2 border rounded-lg text-sm">
                    Batal
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm">
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </div>


    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu')
            menu.classList.toggle('hidden')
        }

        // close jika klik luar
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('userMenu')
            if (!e.target.closest('#userMenu') && !e.target.closest('button')) {
                menu.classList.add('hidden')
            }
        })

        function openLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden')
            document.getElementById('logoutModal').classList.add('flex')
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('flex')
            document.getElementById('logoutModal').classList.add('hidden')
        }
    </script>

</body>

</html>
