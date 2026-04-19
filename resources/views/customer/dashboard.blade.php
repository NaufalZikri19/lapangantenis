@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')

    <div class="space-y-6">

        {{-- HERO --}}
        <div
            class="relative bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-400 text-white p-6 rounded-2xl shadow-lg flex flex-col md:flex-row md:justify-between md:items-center gap-4 overflow-hidden">

            <!-- TEXT -->
            <div class="relative z-10">
                <h2 class="text-xl md:text-2xl font-bold">
                    Welcome back, {{ auth()->user()->name }}
                </h2>
                <p class="text-sm opacity-90 mt-1">
                    Manage your tennis bookings easily & quickly
                </p>
            </div>

            <!-- BUTTON (FIXED) -->
            <a href="{{ route('booking.create') }}"
                class="relative z-20 bg-white text-yellow-500 font-semibold px-5 py-2 rounded-lg shadow hover:scale-105 hover:bg-gray-100 transition-all duration-200 flex items-center gap-2 w-fit cursor-pointer">

                <i data-lucide="clock-plus" class="w-4 h-4"></i>
                <span>Book Court</span>

            </a>

            <!-- DECORATION (FIXED) -->
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
                        <p class="text-gray-500 text-sm">Active Booking</p>
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
                        <p class="text-gray-500 text-sm">Total Booking</p>
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
                        <p class="text-gray-500 text-sm">Available Courts</p>
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
                <span>Active Booking</span>
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
                        {{ $isOngoing ? 'Ongoing' : ucfirst($booking->status) }}
                    </span>

                </div>

            @empty
                <p class="text-gray-400 text-sm">Belum ada booking aktif</p>
            @endforelse

        </div>


        {{-- BOOKING HISTORY --}}
        <div class="bg-white rounded-xl shadow border overflow-hidden">

            <div class="p-5 md:p-6 border-b">
                <h2 class="font-semibold flex items-center gap-2 text-lg">
                    <i data-lucide="history" class="w-4 h-4"></i>
                    <span>Booking History</span>
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[500px]">
                    <thead class="text-gray-500 border-b bg-gray-50">
                        <tr>
                            <th class="text-left py-3 px-4">Court</th>
                            <th class="text-left py-3 px-4">Date</th>
                            <th class="text-left py-3 px-4">Time</th>
                            <th class="text-left py-3 px-4">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($recentBookings as $booking)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4">{{ $booking->court->name }}</td>
                                <td class="px-4">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</td>
                                <td class="px-4">{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                                <td class="px-4">
                                    @if ($booking->status == 'confirmed')
                                        <span
                                            class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">Confirmed</span>
                                    @elseif($booking->status == 'pending')
                                        <span
                                            class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-xs">Pending</span>
                                    @elseif($booking->status == 'completed')
                                        <span
                                            class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs">Completed</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>


    </div>

@endsection
