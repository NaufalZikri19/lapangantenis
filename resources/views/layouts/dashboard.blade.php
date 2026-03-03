<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Dashboard - {{ config('app.name') }}</title>
</head>

<body class="bg-gray-100 overflow-x-hidden">

<div class="flex min-h-screen">

    <!-- OVERLAY (mobile) -->
    <div id="sidebarOverlay"
         class="fixed inset-0 bg-black/40 hidden z-30 lg:hidden"
         onclick="toggleSidebar()">
    </div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed lg:static z-40
               bg-gray-900 text-white
               w-64
               -translate-x-full lg:translate-x-0
               transition-all duration-300
               flex flex-col">

        <!-- HEADER -->
        <div class="p-6 border-b border-gray-800 flex justify-between items-center">

            <h2 id="sidebarTitle" class="text-2xl font-bold">
                Gumbreg Court
            </h2>

            <!-- CLOSE BUTTON (mobile only) -->
            <button class="lg:hidden text-gray-400"
                    onclick="toggleSidebar()">
                ✕
            </button>

        </div>

        <!-- MENU -->
        <nav class="flex-1 p-6 space-y-2 text-sm">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg bg-gray-800">
                <span>🏠</span>
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="{{ route('booking') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                <span>📅</span>
                <span class="menu-text">Booking Saya</span>
            </a>

            <a href="#"
               class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                <span>📋</span>
                <span class="menu-text">Jadwal Lapangan</span>
            </a>

        </nav>

        <!-- FOOTER -->
        <div class="p-6 border-t border-gray-800">

            <div class="text-sm text-gray-400 mb-4 menu-text">
                {{ auth()->user()->name }}
            </div>

            <button onclick="openLogoutModal()"
                class="w-full bg-red-500 py-2 rounded-lg hover:bg-red-400 transition">
                Logout
            </button>

        </div>

    </aside>

    <!-- RIGHT SIDE -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white shadow-sm px-6 lg:px-10 py-4 flex justify-between items-center">

            <div class="flex items-center gap-4">

                <!-- HAMBURGER -->
                <button class="lg:hidden text-gray-700"
                        onclick="toggleSidebar()">
                    ☰
                </button>

                <h1 class="text-lg font-semibold text-gray-800">
                    Dashboard
                </h1>

            </div>

            <div class="text-sm text-gray-500">
                {{ now()->format('l, d M Y') }}
            </div>

        </header>

        <!-- CONTENT -->
        <main class="flex-1 p-6 lg:p-10">
            {{ $slot }}
        </main>

    </div>

</div>


<!-- LOGOUT MODAL -->
<div id="logoutModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">

        <h2 class="text-xl font-bold mb-4">
            Konfirmasi Logout
        </h2>

        <p class="text-gray-600 mb-8">
            Apakah Anda yakin ingin keluar dari akun?
        </p>

        <div class="flex justify-end gap-4">

            <button onclick="closeLogoutModal()"
                class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                Batal
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-400 transition">
                    Ya, Logout
                </button>
            </form>

        </div>

    </div>

</div>


<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
}

function openLogoutModal() {
    document.getElementById('logoutModal').classList.remove('hidden');
    document.getElementById('logoutModal').classList.add('flex');
}

function closeLogoutModal() {
    document.getElementById('logoutModal').classList.remove('flex');
    document.getElementById('logoutModal').classList.add('hidden');
}
</script>

</body>
</html>
