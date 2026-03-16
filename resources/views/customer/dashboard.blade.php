@extends('layouts.customer')

@section('content')
    <div class="space-y-8">

        <!-- Welcome -->
        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Welcome back, {{ Auth::user()->name }} 👋
                </h1>

                <p class="text-gray-500 text-sm mt-1">
                    Manage your tennis court bookings easily.
                </p>
            </div>

            <a href="/customer/booking"
                class="bg-yellow-500 hover:bg-yellow-400 text-white px-5 py-2 rounded-lg font-medium shadow">
                Book Court
            </a>

        </div>

        <!-- Stats -->
        <div class="grid md:grid-cols-3 gap-6">

            <!-- Active Booking -->
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">

                <p class="text-gray-500 text-sm">
                    Active Booking
                </p>

                <h2 class="text-3xl font-bold mt-2 text-gray-800">
                    1
                </h2>

                <p class="text-green-500 text-sm mt-2">
                    Booking berjalan
                </p>

            </div>

            <!-- Booking History -->
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">

                <p class="text-gray-500 text-sm">
                    Total Booking
                </p>

                <h2 class="text-3xl font-bold mt-2 text-gray-800">
                    5
                </h2>

                <p class="text-blue-500 text-sm mt-2">
                    Semua riwayat booking
                </p>

            </div>

            <!-- Courts Available -->
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">

                <p class="text-gray-500 text-sm">
                    Courts Available
                </p>

                <h2 class="text-3xl font-bold mt-2 text-gray-800">
                    2
                </h2>

                <p class="text-purple-500 text-sm mt-2">
                    Lapangan tersedia
                </p>

            </div>

        </div>

        <!-- Active Booking Section -->
        <div class="bg-white rounded-xl shadow p-6">

            <h2 class="text-lg font-semibold mb-4">
                Active Booking
            </h2>

            <div class="border rounded-lg p-4 flex justify-between items-center">

                <div>
                    <p class="font-semibold text-gray-800">
                        Court A
                    </p>

                    <p class="text-sm text-gray-500">
                        20 March 2026 • 08:00 - 10:00
                    </p>
                </div>

                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">
                    Confirmed
                </span>

            </div>

        </div>

        <!-- Booking History -->
        <div class="bg-white rounded-xl shadow p-6">

            <h2 class="text-lg font-semibold mb-4">
                Recent Booking
            </h2>

            <table class="w-full text-sm">

                <thead class="text-gray-500 border-b">

                    <tr>
                        <th class="py-2 text-left">Court</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    <tr class="border-b">
                        <td class="py-3">Court A</td>
                        <td>18 Mar 2026</td>
                        <td>08:00 - 10:00</td>
                        <td>
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                                Confirmed
                            </span>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <td class="py-3">Court B</td>
                        <td>16 Mar 2026</td>
                        <td>19:00 - 21:00</td>
                        <td>
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                                Pending
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>
@endsection
