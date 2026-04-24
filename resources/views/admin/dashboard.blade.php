@extends('layouts.admin')

@section('content')

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-yellow-500">
            <p class="text-gray-500 text-sm">Total Lapangan</p>
            <h2 class="text-3xl font-bold mt-2 counter" data-target="{{ $totalCourts }}">0</h2>
            <p class="text-yellow-500 text-sm mt-1">Lapangan aktif</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm">Pemesanan Hari Ini</p>
            <h2 class="text-3xl font-bold mt-2 counter" data-target="{{ $todayBookings }}">0</h2>
            <p class="text-blue-500 text-sm mt-1">Hari ini</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500">
            <p class="text-gray-500 text-sm">Booking Selesai</p>
            <h2 class="text-3xl font-bold mt-2 counter" data-target="{{ $completed }}">0</h2>
            <p class="text-green-500 text-sm mt-1">Completed</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-purple-500">
            <p class="text-gray-500 text-sm">Total Pelanggan</p>
            <h2 class="text-3xl font-bold mt-2 counter" data-target="{{ $totalCustomers }}">0</h2>
            <p class="text-purple-500 text-sm mt-1">User</p>
        </div>

    </div>


    <!-- CHART -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

        <!-- LINE -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Ringkasan Pemesanan</h2>
                <span class="text-sm text-gray-400">7 hari terakhir</span>
            </div>

            <div class="h-[250px] sm:h-[300px]">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>

        <!-- DONUT -->
        <div class="bg-white rounded-2xl shadow-md p-6">

            <h2 class="text-lg font-semibold mb-6">Status Pemesanan</h2>

            <div class="flex flex-col xl:flex-row items-center justify-center gap-6 min-h-[250px]">
                <div class="flex items-center justify-center w-full h-full">
                    <div class="relative w-40 h-40">
                        <canvas id="statusChart"></canvas>

                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold">
                                {{ $confirmed + $pending + $completed + $cancelled }}
                            </span>
                            <span class="text-xs text-gray-400">Total</span>
                        </div>
                    </div>
                </div>

                <!-- LEGEND -->
                <div class="w-full space-y-2 text-sm">

                    <div class="flex justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                            Dikonfirmasi
                        </span>
                        <span>{{ $confirmed }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                            Menunggu
                        </span>
                        <span>{{ $pending }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                            Selesai
                        </span>
                        <span>{{ $completed }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            Dibatalkan
                        </span>
                        <span>{{ $cancelled }}</span>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- TODAY SCHEDULE -->
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Jadwal Hari Ini</h2>
            <span class="text-sm text-gray-400">{{ now()->format('d M Y') }}</span>
        </div>

        <div class="space-y-3">

            @forelse($todaySchedule as $item)
                <div class="flex justify-between items-center p-3 rounded-xl hover:bg-gray-50">

                    <div>
                        <p class="font-medium">{{ $item->start_time }} - {{ $item->end_time }}</p>
                        <p class="text-sm text-gray-500">{{ $item->court->name }}</p>
                    </div>

                    <!-- CLEAN STATUS -->
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $item->status_class }}">
                        {{ $item->status_label }}
                    </span>

                </div>
            @empty
                <p class="text-center text-gray-400">Belum ada booking</p>
            @endforelse

        </div>

    </div>


    <!-- RECENT BOOKINGS -->
    <div class="bg-white rounded-2xl shadow-md p-6">

        <h2 class="text-lg font-semibold mb-4">Pemesanan Terbaru</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                    <tr class="text-center text-gray-400 border-b">
                        <th class="py-3">Pelanggan</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr class="border-b text-center hover:bg-gray-50">

                            <td class="py-3 font-medium">
                                {{ $booking->user->name }}
                            </td>

                            <td>{{ $booking->court->name }}</td>
                            <td>{{ $booking->date }}</td>
                            <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>

                            <td>
                                <span class="px-3 py-1 rounded-full text-xs {{ $booking->status_class }}">
                                    {{ $booking->status_label }}
                                </span>
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
    document.addEventListener("DOMContentLoaded", function () {

        // DONUT CHART
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Dikonfirmasi', 'Menunggu', 'Selesai', 'Dibatalkan'],
                datasets: [{
                    data: [
                    {{ $confirmed }},
                    {{ $pending }},
                    {{ $completed }},
                        {{ $cancelled }}
                    ],
                    backgroundColor: [
                        '#22c55e',
                        '#eab308',
                        '#3b82f6',
                        '#ef4444'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });

    });

    document.addEventListener("DOMContentLoaded", function () {

        const ctx = document.getElementById('bookingChart');

        if (!ctx) return;

        new Chart(ctx, {
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
                maintainAspectRatio: false,
            }
        });

    });


    document.addEventListener("DOMContentLoaded", function () {

        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');

            let count = 0;
            const speed = 20;

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