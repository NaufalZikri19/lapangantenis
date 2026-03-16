@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-8">
        Admin Dashboard
    </h1>

    <!-- STATISTICS -->
    <div class="grid md:grid-cols-3 gap-6 mb-10">

        <p class="text-3xl font-bold">
            {{ $totalCourts }}
        </p>
        <p class="text-green-600 text-sm">
            Lapangan tersedia
        </p>

        <p class="text-3xl font-bold">
            {{ $todayBookings }}
        </p>
        <p class="text-blue-600 text-sm">
            Booking hari ini
        </p>

        <p class="text-3xl font-bold">
            {{ $totalCustomers }}
        </p>
        <p class="text-purple-600 text-sm">
            User terdaftar
        </p>

    </div>


    <!-- RECENT BOOKINGS -->
    <div class="bg-white rounded-xl shadow p-6 mt-8">

        <h2 class="text-lg font-semibold mb-4">
            Recent Bookings
        </h2>

        <table class="w-full text-sm">

            <thead class="border-b text-gray-500">
                <tr>
                    <th class="py-2 text-left">Customer</th>
                    <th class="text-left">Court</th>
                    <th class="text-left">Date</th>
                    <th class="text-left">Time</th>
                    <th class="text-left">Status</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($recentBookings as $booking)
                    <tr class="border-b">

                        <td class="py-3">
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
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>
@endsection
