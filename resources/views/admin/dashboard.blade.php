@extends('layouts.admin')

@section('content')

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">

        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 relative overflow-hidden group hover:shadow-md transition-shadow duration-200">
            <div class="absolute top-0 left-0 w-1 h-full bg-yellow-500"></div>
            <div class="flex justify-between items-start">
                <div class="min-w-0">
                    <p class="text-gray-500 text-sm font-medium truncate">Total Lapangan</p>
                    <h2 class="text-2xl sm:text-3xl font-bold mt-2 text-gray-800 counter"
                        data-target="{{ $totalCourts ?? 0 }}">0</h2>
                </div>
                <div
                    class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl group-hover:scale-110 transition-transform duration-200 shrink-0">
                    <i data-lucide="monitor" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-yellow-600 font-medium flex items-center gap-1.5 bg-yellow-50 px-2 py-0.5 rounded-md">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Lapangan Aktif
                </span>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 relative overflow-hidden group hover:shadow-md transition-shadow duration-200">
            <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
            <div class="flex justify-between items-start">
                <div class="min-w-0">
                    <p class="text-gray-500 text-sm font-medium truncate">Booking Hari Ini</p>
                    <h2 class="text-2xl sm:text-3xl font-bold mt-2 text-gray-800 counter"
                        data-target="{{ $todayBookings ?? 0 }}">0</h2>
                </div>
                <div
                    class="p-2.5 bg-blue-50 text-blue-600 rounded-xl group-hover:scale-110 transition-transform duration-200 shrink-0">
                    <i data-lucide="calendar-clock" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-blue-600 font-medium flex items-center gap-1.5 bg-blue-50 px-2 py-0.5 rounded-md">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i> Hari ini
                </span>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 relative overflow-hidden group hover:shadow-md transition-shadow duration-200">
            <div class="absolute top-0 left-0 w-1 h-full bg-green-500"></div>
            <div class="flex justify-between items-start">
                <div class="min-w-0">
                    <p class="text-gray-500 text-sm font-medium truncate">Booking Selesai</p>
                    <h2 class="text-2xl sm:text-3xl font-bold mt-2 text-gray-800 counter"
                        data-target="{{ $completed ?? 0 }}">0</h2>
                </div>
                <div
                    class="p-2.5 bg-green-50 text-green-600 rounded-xl group-hover:scale-110 transition-transform duration-200 shrink-0">
                    <i data-lucide="check-square" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-600 font-medium flex items-center gap-1.5 bg-green-50 px-2 py-0.5 rounded-md">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> Completed
                </span>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 relative overflow-hidden group hover:shadow-md transition-shadow duration-200">
            <div class="absolute top-0 left-0 w-1 h-full bg-purple-500"></div>
            <div class="flex justify-between items-start">
                <div class="min-w-0">
                    <p class="text-gray-500 text-sm font-medium truncate">Total Pelanggan</p>
                    <h2 class="text-2xl sm:text-3xl font-bold mt-2 text-gray-800 counter"
                        data-target="{{ $totalCustomers ?? 0 }}">0</h2>
                </div>
                <div
                    class="p-2.5 bg-purple-50 text-purple-600 rounded-xl group-hover:scale-110 transition-transform duration-200 shrink-0">
                    <i data-lucide="users" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-purple-600 font-medium flex items-center gap-1.5 bg-purple-50 px-2 py-0.5 rounded-md">
                    <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> Terdaftar
                </span>
            </div>
        </div>

    </div>


    <!-- CHART SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 sm:mb-8">

        <!-- LINE CHART (Main Chart) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 lg:col-span-2 flex flex-col">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Ringkasan Pemesanan</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Statistik 7 hari terakhir</p>
                </div>
                <div
                    class="px-3 py-1.5 bg-gray-50 text-gray-600 border border-gray-200 rounded-lg text-sm flex items-center gap-2 font-medium shrink-0">
                    <i data-lucide="calendar-range" class="w-4 h-4 text-gray-400"></i> 7 Hari Terakhir
                </div>
            </div>

            <div class="relative h-[220px] sm:h-[300px] w-full flex-1">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>

        <!-- DONUT CHART -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 flex flex-col">
            <div class="mb-4 sm:mb-6">
                <h2 class="text-lg font-bold text-gray-800">Status Pemesanan</h2>
                <p class="text-sm text-gray-500 mt-0.5">Distribusi status keseluruhan</p>
            </div>

            <div class="flex-1 flex flex-col items-center justify-center min-h-[220px]">
                <div class="relative w-40 h-40 sm:w-48 sm:h-48 mb-6">
                    <canvas id="statusChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl sm:text-3xl font-bold text-gray-800">
                            {{ ($confirmed ?? 0) + ($pending ?? 0) + ($completed ?? 0) + ($cancelled ?? 0) }}
                        </span>
                        <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold mt-1">Total</span>
                    </div>
                </div>

                <!-- LEGEND -->
                <div class="w-full space-y-2.5 text-sm mt-auto">
                    <div
                        class="flex justify-between items-center group px-2 py-1 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="flex items-center gap-2.5 text-gray-600 font-medium">
                            <span class="w-3 h-3 bg-green-500 rounded-full shadow-sm"></span>
                            Dikonfirmasi
                        </span>
                        <span class="font-bold text-gray-800">{{ $confirmed ?? 0 }}</span>
                    </div>
                    <div
                        class="flex justify-between items-center group px-2 py-1 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="flex items-center gap-2.5 text-gray-600 font-medium">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full shadow-sm"></span>
                            Menunggu
                        </span>
                        <span class="font-bold text-gray-800">{{ $pending ?? 0 }}</span>
                    </div>
                    <div
                        class="flex justify-between items-center group px-2 py-1 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="flex items-center gap-2.5 text-gray-600 font-medium">
                            <span class="w-3 h-3 bg-blue-500 rounded-full shadow-sm"></span>
                            Selesai
                        </span>
                        <span class="font-bold text-gray-800">{{ $completed ?? 0 }}</span>
                    </div>
                    <div
                        class="flex justify-between items-center group px-2 py-1 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="flex items-center gap-2.5 text-gray-600 font-medium">
                            <span class="w-3 h-3 bg-red-500 rounded-full shadow-sm"></span>
                            Dibatalkan
                        </span>
                        <span class="font-bold text-gray-800">{{ $cancelled ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- TODAY SCHEDULE -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6 lg:col-span-1 h-fit flex flex-col">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold text-gray-800">Jadwal Hari Ini</h2>
                <span
                    class="px-2.5 py-1 bg-yellow-50 text-yellow-700 text-xs font-bold rounded-md border border-yellow-100">
                    {{ now()->format('d M Y') }}
                </span>
            </div>

            <div class="space-y-3 flex-1 overflow-y-auto max-h-[400px] pr-1">
                @if(isset($todaySchedule) && count($todaySchedule) > 0)
                    @foreach($todaySchedule as $item)
                        <div
                            class="flex justify-between items-center p-3 sm:p-4 rounded-xl border border-gray-100 hover:border-yellow-200 hover:shadow-sm transition-all duration-200 bg-white">
                            <div class="flex items-center gap-3.5">
                                <div
                                    class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center shrink-0 text-gray-500 border border-gray-100">
                                    <i data-lucide="clock" class="w-5 h-5"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-800 text-sm truncate">{{ $item->start_time }} -
                                        {{ $item->end_time }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $item->court->name ?? 'Lapangan' }}</p>
                                </div>
                            </div>
                            <!-- CLEAN STATUS -->
                            <span
                                class="px-2.5 py-1 rounded-md text-xs font-bold shrink-0 {{ $item->status_class ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $item->status_label ?? 'Status' }}
                            </span>
                        </div>
                    @endforeach
                @else
                    <div
                        class="py-10 text-center flex flex-col items-center justify-center bg-gray-50/50 rounded-xl border border-dashed border-gray-200 h-full">
                        <div
                            class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-3 shadow-sm border border-gray-100">
                            <i data-lucide="calendar-x" class="w-6 h-6 text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 font-semibold">Belum ada booking</p>
                        <p class="text-xs text-gray-400 mt-1">Jadwal kosong untuk hari ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- RECENT BOOKINGS -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 lg:col-span-2 overflow-hidden flex flex-col">
            <div class="p-5 sm:p-6 border-b border-gray-100 flex justify-between items-center bg-white">
                <h2 class="text-lg font-bold text-gray-800">Pemesanan Terbaru</h2>
                <a href="/admin/bookings"
                    class="text-sm text-yellow-600 hover:text-yellow-700 font-bold flex items-center gap-1 transition-colors group">
                    Lihat Semua <i data-lucide="arrow-right"
                        class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left min-w-[600px]">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 border-b border-gray-100">
                        <tr>
                            <th class="px-5 sm:px-6 py-4 font-bold tracking-wider">Pelanggan</th>
                            <th class="px-5 sm:px-6 py-4 font-bold tracking-wider">Lapangan</th>
                            <th class="px-5 sm:px-6 py-4 font-bold tracking-wider">Waktu</th>
                            <th class="px-5 sm:px-6 py-4 font-bold tracking-wider text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @if(isset($recentBookings) && count($recentBookings) > 0)
                            @foreach($recentBookings as $booking)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold text-xs shrink-0 border border-yellow-200/50">
                                                {{ strtoupper(substr($booking->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div class="font-semibold text-gray-800">{{ $booking->user->name ?? 'User' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-5 sm:px-6 py-4 text-gray-600 whitespace-nowrap font-medium">
                                        {{ $booking->court->name ?? '-' }}
                                    </td>
                                    <td class="px-5 sm:px-6 py-4 text-gray-600 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-800">{{ $booking->date ?? '-' }}</span>
                                            <span class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                                <i data-lucide="clock" class="w-3 h-3"></i> {{ $booking->start_time ?? '' }} -
                                                {{ $booking->end_time ?? '' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-5 sm:px-6 py-4 whitespace-nowrap text-right">
                                        <span
                                            class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-bold {{ $booking->status_class ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ $booking->status_label ?? 'Status' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3 border border-gray-100">
                                            <i data-lucide="inbox" class="w-6 h-6 text-gray-400"></i>
                                        </div>
                                        <p class="text-gray-600 font-semibold">Belum ada pemesanan</p>
                                        <p class="text-sm text-gray-400 mt-1">Transaksi pemesanan terbaru akan muncul di sini.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // DONUT CHART
            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Dikonfirmasi', 'Menunggu', 'Selesai', 'Dibatalkan'],
                        datasets: [{
                            data: [
                                {{ $confirmed ?? 0 }},
                                {{ $pending ?? 0 }},
                                {{ $completed ?? 0 }},
                                {{ $cancelled ?? 0 }}
                            ],
                            backgroundColor: [
                                '#22c55e', // green-500
                                '#eab308', // yellow-500
                                '#3b82f6', // blue-500
                                '#ef4444'  // red-500
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                titleColor: '#1f2937',
                                bodyColor: '#4b5563',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                padding: 10,
                                boxPadding: 4,
                                usePointStyle: true,
                                callbacks: {
                                    label: function (context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed !== null) {
                                            label += context.parsed;
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // LINE CHART
            const bookingCtx = document.getElementById('bookingChart');
            if (bookingCtx) {
                // Add gradient
                const ctx = bookingCtx.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(234, 179, 8, 0.2)'); // yellow-500 with opacity
                gradient.addColorStop(1, 'rgba(234, 179, 8, 0)');

                new Chart(bookingCtx, {
                    type: 'line',
                    data: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        datasets: [{
                            label: 'Pemesanan',
                            // You can inject real data array here later:
                            data: [3, 5, 2, 8, 6, 9, 4],
                            borderColor: '#eab308', // yellow-500
                            backgroundColor: gradient,
                            borderWidth: 2.5,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#eab308',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.4,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                titleColor: '#1f2937',
                                bodyColor: '#4b5563',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                padding: 10,
                                displayColors: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f3f4f6', // gray-100
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: '#6b7280', // gray-500
                                    stepSize: 2,
                                    padding: 10
                                },
                                border: { display: false }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: '#6b7280', // gray-500
                                    padding: 10
                                },
                                border: { display: false }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });
            }

            // ANIMATED COUNTERS
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                if (target === 0) return;

                let count = 0;
                const speed = 25; // animation speed divider

                const updateCount = () => {
                    const increment = Math.ceil(target / speed);

                    if (count < target) {
                        count += increment;
                        counter.innerText = count > target ? target : count;
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };

                // start animation when visible (simple approach)
                setTimeout(updateCount, 100);
            });

        });
    </script>
@endpush