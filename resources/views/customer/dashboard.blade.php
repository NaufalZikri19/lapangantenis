@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')

    <div class="w-full space-y-6">

        {{-- HERO --}}
        <div
            class="relative bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-400 text-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row md:justify-between md:items-center gap-4 overflow-hidden">

            <!-- TEXT -->
            <div class="relative z-10">
                <h2 class="text-xl md:text-2xl font-bold">
                    Halo, {{ auth()->user()->name }}
                </h2>
                <p class="text-sm opacity-90 mt-1">
                    Atur jadwal main tenis dengan mudah & cepat
                </p>
            </div>

            <!-- BUTTON (FIXED) -->
            <a href="{{ route('booking.create') }}"
                class="relative z-20 bg-white text-yellow-500 font-semibold px-5 py-2 rounded-lg shadow hover:scale-105 hover:bg-gray-100 transition-all duration-200 flex items-center gap-2 w-fit cursor-pointer">

                <i data-lucide="clock-plus" class="w-4 h-4"></i>
                <span>Booking Lapangan</span>

            </a>

            <!-- DECORATION -->
            <div class="pointer-events-none absolute right-0 top-0 w-40 h-40 bg-white/10 rounded-full blur-3xl z-0"></div>
        </div>


        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- ACTIVE BOOKING --}}
            <div class="bg-white p-5 rounded-xl shadow border hover:shadow-md transition">
                <div class="flex items-center gap-3">

                    <div class="p-2 bg-green-100 rounded-lg">
                        <i data-lucide="calendar-check" class="w-5 h-5 text-green-500"></i>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Pemesanan Aktif</p>
                        <h2 class="text-2xl font-bold leading-none">{{ $activeBooking }}</h2>
                    </div>
                </div>
                <p class="text-green-500 text-xs mt-2">Sedang berjalan</p>
            </div>


            {{-- TOTAL BOOKING --}}
            <div class="bg-white p-5 rounded-xl shadow border hover:shadow-md transition">
                <div class="flex items-center gap-3">

                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i data-lucide="history" class="w-5 h-5 text-blue-500"></i>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Total Pemesanan</p>
                        <h2 class="text-2xl font-bold leading-none">{{ $totalBooking }}</h2>
                    </div>
                </div>
                <p class="text-blue-500 text-xs mt-2">Semua riwayat</p>
            </div>


            {{-- AVAILABLE COURTS --}}
            <div class="bg-white p-5 rounded-xl shadow border hover:shadow-md transition">
                <div class="flex items-center gap-3">

                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i data-lucide="map" class="w-5 h-5 text-blue-500"></i>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Jumlah Lapangan</p>
                        <h2 class="text-2xl font-bold leading-none">{{ $courts }}</h2>
                    </div>
                </div>
                <p class="text-purple-500 text-xs mt-2">Lapangan aktif</p>
            </div>

        </div>


        {{-- ACTIVE BOOKING --}}
        <div class="bg-white rounded-xl shadow p-5 md:p-6 border">

            <h2 class="font-semibold mb-4 flex items-center gap-2 text-lg">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                <span>Pemesanan Aktif</span>
            </h2>

            @forelse($activeBookings as $booking)
                @php
                    $now = \Carbon\Carbon::now();
                    $date = \Carbon\Carbon::parse($booking->date);
                    $start = \Carbon\Carbon::parse($booking->date . ' ' . $booking->start_time);
                    $end = \Carbon\Carbon::parse($booking->date . ' ' . $booking->end_time);

                    $isToday = $date->isToday();
                    $isOngoing = $isToday && $now->between($start, $end);
                @endphp

                <div
                    class="flex flex-col md:flex-row md:justify-between md:items-center border-l-4
                                                                                                                                                                                                                                                                        {{ $isOngoing ? 'border-yellow-400 bg-yellow-50' : 'border-green-400' }}
                                                                                                                                                                                                                                                                        rounded-lg p-4 mb-3 gap-2 hover:shadow transition">

                    <div class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-4 h-4 text-gray-400 mt-1"></i>

                        <div>
                            <p class="font-semibold">{{ $booking->court->name }}</p>

                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                                • {{ $booking->start_time }} - {{ $booking->end_time }}
                            </p>

                            @if ($isOngoing)
                                <p class="text-xs text-yellow-600 mt-1 font-medium">
                                    Sedang berlangsung
                                </p>
                            @elseif($isToday)
                                <p class="text-xs text-blue-500 mt-1">
                                    Hari ini
                                </p>
                            @endif
                        </div>
                    </div>

                    <span
                        class="px-3 py-1 rounded-full text-xs w-fit
                                                                                                                        {{ $isOngoing ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' }}">
                        {{ $isOngoing ? 'Sedang berlangsung' : $booking->status_label }}
                    </span>

                </div>

            @empty
                <p class="text-gray-400 text-sm">Belum ada booking aktif</p>
            @endforelse

        </div>


        {{-- BOOKING HISTORY --}}
        <div id="history" class="bg-white rounded-xl shadow border overflow-hidden">

            <div class="p-5 md:p-6 border-b flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                <h2 class="font-semibold flex items-center gap-2 text-lg">
                    <i data-lucide="history" class="w-4 h-4"></i>
                    <span>Riwayat Pemesanan</span>
                </h2>

                <form method="GET" action="{{ route('customer.dashboard') }}#history" class="relative w-full md:w-64"
                    id="searchForm">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari booking..."
                        class="w-full border rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-2 focus:ring-yellow-400"
                        oninput="debounceSearch()">

                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                </form>

            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[600px] border-separate border-spacing-y-2">

                    <thead>
                        <tr class="text-gray-500">
                            <th class="text-center py-3 px-5">Lapangan</th>
                            <th class="text-center py-3 px-5">Tanggal</th>
                            <th class="text-center py-3 px-5">Jam</th>
                            <th class="text-center py-3 px-5">Status</th>
                            <th class="text-center py-3 px-5">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($recentBookings as $booking)
                            <tr class="bg-white shadow-sm rounded-lg hover:bg-gray-50 transition text-center">

                                <td class="py-3 px-5 whitespace-nowrap">
                                    {{ $booking->court->name }}
                                </td>

                                <td class="py-3 px-5 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                                </td>

                                <td class="py-3 px-5 whitespace-nowrap">
                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                </td>

                                <td class="py-3 px-5">
                                    <span class="{{ $booking->status_class }} px-3 py-1 rounded-full text-xs">
                                        {{ $booking->status_label }}
                                    </span>
                                </td>

                                <td class="py-3 px-5">

                                    @if($booking->payment_status === 'unpaid')
                                        <a href="{{ route('booking.payment', $booking->id) }}"
                                            class="inline-flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                                            Bayar
                                        </a>

                                    @elseif($booking->payment_status === 'waiting')
                                        <span class="text-blue-500 text-xs font-medium">
                                            Menunggu Verifikasi
                                        </span>

                                    @elseif($booking->payment_status === 'confirmed')
                                        <span class="text-green-600 text-xs font-medium">
                                            Lunas
                                        </span>

                                    @elseif($booking->status === 'expired')
                                        <span class="text-red-500 text-xs">
                                             Kadaluarsa
                                        </span>

                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

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