@extends('layouts.customer')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- HERO --}}
        <div
            class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white p-5 md:p-6 rounded-2xl shadow flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <div>
                <h1 class="text-xl md:text-2xl font-bold">
                    Welcome back, {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-sm opacity-90 mt-1">
                    Manage your tennis bookings easily & quickly
                </p>
            </div>

            <a href="{{ route('booking.create') }}"
                class="bg-white text-yellow-500 font-semibold px-5 py-2 rounded-lg shadow hover:bg-gray-100 transition text-center">
                + Book Court
            </a>
        </div>


        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-white p-5 rounded-xl shadow border">
                <p class="text-gray-500 text-sm">Active Booking</p>
                <h2 class="text-2xl font-bold mt-1">{{ $activeBooking }}</h2>
                <p class="text-green-500 text-sm">Sedang berjalan</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow border">
                <p class="text-gray-500 text-sm">Total Booking</p>
                <h2 class="text-2xl font-bold mt-1">{{ $totalBooking }}</h2>
                <p class="text-blue-500 text-sm">Semua riwayat</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow border">
                <p class="text-gray-500 text-sm">Available Courts</p>
                <h2 class="text-2xl font-bold mt-1">{{ $courts }}</h2>
                <p class="text-purple-500 text-sm">Lapangan aktif</p>
            </div>

        </div>


        {{-- ACTIVE BOOKING --}}
        <div class="bg-white rounded-xl shadow p-5 md:p-6 border">
            <h2 class="font-semibold mb-4">🎾 Active Booking</h2>

            @forelse($activeBookings as $booking)
                <div
                    class="flex flex-col md:flex-row md:justify-between md:items-center border rounded-lg p-4 mb-3 gap-2 hover:shadow transition">

                    <div>
                        <p class="font-semibold">{{ $booking->court->name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                            • {{ $booking->start_time }} - {{ $booking->end_time }}
                        </p>
                    </div>

                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs w-fit">
                        {{ ucfirst($booking->status) }}
                    </span>

                </div>
            @empty
                <p class="text-gray-400 text-sm">Belum ada booking aktif</p>
            @endforelse
        </div>


        {{-- RECENT BOOKINGS --}}
        <div class="bg-white rounded-xl shadow p-5 md:p-6 border">
            <h2 class="font-semibold mb-4">📋 Booking History</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[500px]">
                    <thead class="text-gray-500 border-b">
                        <tr>
                            <th class="text-left py-2">Court</th>
                            <th class="text-left py-2">Date</th>
                            <th class="text-left py-2">Time</th>
                            <th class="text-left py-2">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($recentBookings as $booking)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">{{ $booking->court->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</td>
                                <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                                <td>
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
