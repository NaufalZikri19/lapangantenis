@extends('layouts.admin')

@section('content')
    <!-- HEADER -->
    <div class="mb-8 space-y-4">

        <!-- TOP -->
        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-xl font-semibold">
                    Welcome back, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-sm text-gray-500">
                    Here’s what’s happening today
                </p>
            </div>

            <!-- Avatar -->
            <div
                class="w-10 h-10 rounded-full bg-yellow-400 text-gray-900 font-bold flex items-center justify-center shadow">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

        </div>

    </div>

    <!-- STAT CARDS -->
    <div class="grid md:grid-cols-3 gap-6 mb-10">

        <!-- CARD -->
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-xl transition">
            <p class="text-gray-500 text-sm">Total Courts</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalCourts }}</h2>
            <p class="text-yellow-500 text-sm mt-1">Lapangan tersedia</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-xl transition">
            <p class="text-gray-500 text-sm">Today's Booking</p>
            <h2 class="text-3xl font-bold mt-2">{{ $todayBookings }}</h2>
            <p class="text-blue-500 text-sm mt-1">Booking hari ini</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-xl transition">
            <p class="text-gray-500 text-sm">Total Customers</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalCustomers }}</h2>
            <p class="text-purple-500 text-sm mt-1">User terdaftar</p>
        </div>

    </div>



    <!-- RECENT BOOKINGS -->
    <div class="bg-white rounded-2xl shadow-md p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold">
                Recent Bookings
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                    <tr class="text-left text-gray-400 border-b">
                        <th class="py-3">Customer</th>
                        <th>Court</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="py-3 font-medium">
                                {{ $booking->user->name }}
                            </td>

                            <td>
                                {{ $booking->court->name }}
                            </td>

                            <td>
                                {{ $booking->date }}
                            </td>

                            <td>
                                {{ $booking->start_time }} - {{ $booking->end_time }}
                            </td>

                            <td>
                                @if ($booking->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs">
                                        Pending
                                    </span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">
                                        Confirmed
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs">
                                        Cancelled
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400">
                                Belum ada booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
@endsection
