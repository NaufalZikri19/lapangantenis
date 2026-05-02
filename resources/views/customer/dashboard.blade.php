@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@section('content')

    <!-- HERO SECTION -->
    <div
        class="relative bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:justify-between md:items-center gap-6 overflow-hidden">
        <!-- TEXT -->
        <div class="relative z-10 space-y-1">
            <h2 class="text-xl md:text-2xl font-bold flex items-center gap-2">
                Halo, {{ auth()->user()->name }}
            </h2>
            <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">
                Siap untuk main tenis hari ini? Atur jadwal lapangan dengan mudah.
            </p>
        </div>

        <!-- BUTTON -->
        <a href="{{ route('booking.create') }}"
            class="relative z-20 w-full md:w-auto inline-flex justify-center items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-6 py-3 rounded-xl shadow-sm transition duration-200">
            <i data-lucide="calendar-plus" class="w-5 h-5"></i>
            <span>Booking Lapangan</span>
        </a>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
        <!-- ACTIVE BOOKING -->
        <div
            class="bg-white dark:bg-gray-800 p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-xl">
                    <i data-lucide="calendar-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Pemesanan Aktif</p>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $activeBooking }}</h2>
                </div>
            </div>
        </div>

        <!-- TOTAL BOOKING -->
        <div
            class="bg-white dark:bg-gray-800 p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                    <i data-lucide="history" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Booking</p>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalBooking }}</h2>
                </div>
            </div>
        </div>

        <!-- AVAILABLE COURTS -->
        <div
            class="bg-white dark:bg-gray-800 p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-200 sm:col-span-2 lg:col-span-1">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl">
                    <i data-lucide="map" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Jumlah Lapangan</p>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $courts }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT BOOKINGS / HISTORY -->
    <div id="history"
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        <div
            class="p-5 md:p-6 border-b border-gray-50 dark:border-gray-700/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i data-lucide="clipboard-list" class="w-5 h-5 text-gray-400 dark:text-gray-500"></i>
                Riwayat & Status Booking
            </h2>

            <form method="GET" action="{{ route('customer.dashboard') }}#history" class="relative w-full sm:w-64"
                id="searchForm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pemesanan..."
                    class="w-full border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg pl-9 pr-3 py-2 text-sm focus:ring-1 focus:ring-yellow-500 focus:border-yellow-500 transition-colors"
                    oninput="debounceSearch()">
                <i data-lucide="search"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 dark:text-gray-500"></i>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-sm text-left">
                <thead
                    class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-4">Lapangan</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Jam</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @forelse ($recentBookings as $booking)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $booking->court->name }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">ID:
                                    #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                {{ $booking->start_time }} - {{ $booking->end_time }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300';
                                    if ($booking->status === 'pending' || $booking->payment_status === 'unpaid') {
                                        $statusClass = 'bg-yellow-100 text-yellow-600';
                                    } elseif ($booking->status === 'confirmed') {
                                        $statusClass = 'bg-green-100 text-green-600';
                                    } elseif ($booking->status === 'cancelled' || $booking->status === 'expired' || $booking->payment_status === 'rejected') {
                                        $statusClass = 'bg-red-100 text-red-600';
                                    } elseif ($booking->payment_status === 'waiting') {
                                        $statusClass = 'bg-blue-100 text-blue-600';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $booking->status_label ?? ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                @if($booking->status === 'expired')
                                    <button disabled
                                        class="inline-flex items-center justify-center gap-1.5 w-full md:w-auto bg-red-50 text-red-600 px-4 py-2 rounded-full text-xs font-medium opacity-50 cursor-not-allowed">
                                        <i data-lucide="clock-4" class="w-3.5 h-3.5"></i>
                                        Kadaluarsa
                                    </button>
                                @elseif($booking->payment_status === 'waiting')
                                    <button disabled
                                        class="inline-flex items-center justify-center gap-1.5 w-full md:w-auto bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-xs font-medium cursor-wait">
                                        <i data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
                                        Menunggu
                                    </button>
                                @elseif($booking->status === 'pending' || $booking->payment_status === 'unpaid')
                                    <a href="{{ route('booking.payment', $booking->id) }}"
                                        class="inline-flex items-center justify-center gap-1.5 w-full md:w-auto bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-full text-xs font-medium transition duration-200">
                                        <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                                        Bayar Sekarang
                                    </a>
                                @elseif($booking->status === 'confirmed' || $booking->status === 'completed' || $booking->payment_status === 'confirmed')
                                    <button
                                        class="inline-flex items-center justify-center gap-1.5 w-full md:w-auto bg-green-50 text-green-600 hover:bg-green-100 px-4 py-2 rounded-full text-xs font-medium transition duration-200">
                                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                        Lunas
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500 italic">Dibatalkan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-12 h-12 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3 border border-gray-100 dark:border-gray-600">
                                        <i data-lucide="inbox" class="w-6 h-6 text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Belum ada booking</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 mb-4">Ayo mulai booking lapangan
                                        tenis pertamamu.</p>
                                    <a href="{{ route('booking.create') }}"
                                        class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                        Booking Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let searchTimeout;
        function debounceSearch() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const form = document.getElementById('searchForm');
                form.action = window.location.pathname + '#history';
                form.submit();
            }, 500);
        }
    </script>
@endsection