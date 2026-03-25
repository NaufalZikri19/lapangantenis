@extends('layouts.admin')

@section('content')
    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-yellow-500">
            <p class="text-gray-500 text-sm">Total Courts</p>
            <h2 class="text-3xl font-bold mt-2 counter" data-target="{{ $totalCourts }}">0</h2>
            <p class="text-yellow-500 text-sm mt-1">Lapangan tersedia</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm">Today's Booking</p>
            <h2 class="text-3xl font-bold mt-2 counter" data-target="{{ $todayBookings }}">0</h2>
            <p class="text-blue-500 text-sm mt-1">Booking hari ini</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-purple-500">
            <p class="text-gray-500 text-sm">Total Customers</p>
            <h2 class="text-3xl font-bold mt-2 counter" data-target="{{ $totalCustomers }}">0</h2>
            <p class="text-purple-500 text-sm mt-1">User terdaftar</p>
        </div>

    </div>


    <!-- CHART -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

        <!-- LINE -->
        <div class="bg-white rounded-2xl shadow-md p-6">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Booking Overview</h2>
                <span class="text-sm text-gray-400">Last 7 days</span>
            </div>

            <!-- FIX HEIGHT BIAR AMAN -->
            <div class="h-[250px] sm:h-[300px]">
                <canvas id="bookingChart" class="w-full h-full"></canvas>
            </div>

        </div>

        <!-- DONUT -->
        <div class="bg-white rounded-2xl shadow-md p-6">

            <h2 class="text-lg font-semibold mb-6 text-center xl:text-left">
                Booking Status
            </h2>

            <div class="flex flex-col xl:flex-row items-center gap-6">

                <!-- CHART -->
                <div class="relative w-36 h-36 sm:w-48 sm:h-48">

                    <canvas id="statusChart"></canvas>

                    <!-- CENTER -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold">
                            {{ $confirmed + $pending + $cancelled }}
                        </span>
                        <span class="text-xs text-gray-400">Total</span>
                    </div>

                </div>

                <!-- LEGEND -->
                <div class="w-full space-y-2 text-sm">

                    <div class="flex justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                            Confirmed
                        </span>
                        <span>{{ $confirmed }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                            Pending
                        </span>
                        <span>{{ $pending }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            Cancelled
                        </span>
                        <span>{{ $cancelled }}</span>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- TODAY SCHEDULE -->
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">
            <h2 class="text-lg font-semibold">Today Schedule</h2>
            <span class="text-sm text-gray-400">
                {{ now()->format('d M Y') }}
            </span>
        </div>

        <div class="space-y-3">

            @forelse($todaySchedule as $item)
                <div
                    class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 p-3 rounded-xl hover:bg-gray-50 transition">

                    <div>
                        <p class="font-medium text-gray-800">
                            {{ $item->start_time }} - {{ $item->end_time }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $item->court->name }}
                        </p>
                    </div>

                    @if ($item->status == 'confirmed')
                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-semibold w-fit">
                            Confirmed
                        </span>
                    @elseif($item->status == 'pending')
                        <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-semibold w-fit">
                            Pending
                        </span>
                    @else
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold w-fit">
                            Cancelled
                        </span>
                    @endif

                </div>
            @empty
                <div class="text-center py-6 text-gray-400 text-sm">
                    No bookings today
                </div>
            @endforelse

        </div>

    </div>


    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-md p-6">

        <h2 class="text-lg font-semibold mb-4">Recent Bookings</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[600px]">

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

                            <td>{{ $booking->court->name }}</td>
                            <td>{{ $booking->date }}</td>
                            <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>

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

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // LINE CHART
        new Chart(document.getElementById('bookingChart'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Bookings',
                    data: [3, 5, 2, 8, 6, 9, 4],
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // DONUT CHART (FIXED)
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Confirmed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $confirmed }},
                        {{ $pending }},
                        {{ $cancelled }}
                    ],
                    backgroundColor: [
                        '#22c55e',
                        '#eab308',
                        '#ef4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // ========================
        // COUNTER ANIMATION
        // ========================
        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let count = 0;

            const speed = 50; // makin kecil = makin cepat

            const updateCount = () => {
                const increment = Math.ceil(target / speed);

                if (count < target) {
                    count += increment;
                    counter.innerText = count;
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
            };

            updateCount();
        });


    });
</script>
