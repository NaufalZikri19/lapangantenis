@extends('layouts.admin')

@section('content')
    <div class="w-full space-y-6">

        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="p-2.5 bg-yellow-50 dark:bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 rounded-xl border border-yellow-100 dark:border-yellow-500/20">
                    <i data-lucide="table" class="w-7 h-7 text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-semibold text-gray-800 dark:text-gray-100">Data Pemesanan</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan monitor semua aktivitas pemesanan</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <a href="{{ route('admin.bookings.create') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 text-sm font-bold rounded-xl transition-all shadow-sm shrink-0">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Booking
                </a>
                <!-- SEARCH -->

                <form method="GET" class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pemesanan..."
                        class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-colors">
                    <i data-lucide="search"
                        class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                </form>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div
            class="flex flex-wrap items-center justify-between gap-3 bg-white dark:bg-gray-800 p-2 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <!-- SEGMENTED FILTER -->
            <div
                class="flex bg-gray-50 dark:bg-gray-900 p-1 rounded-lg text-sm border border-gray-100 dark:border-gray-700">
                <a href="{{ route('admin.bookings') }}"
                    class="px-4 py-1.5 rounded-md transition duration-200 font-medium
                                                {{ !request('filter') ? 'bg-white dark:bg-gray-700 shadow-sm text-gray-800 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100/50 dark:hover:bg-gray-700/50' }}">
                    Semua
                </a>
                <a href="{{ route('admin.bookings', ['filter' => 'month']) }}"
                    class="px-4 py-1.5 rounded-md transition duration-200 font-medium
                                                {{ request('filter') == 'month' ? 'bg-white dark:bg-gray-700 shadow-sm text-gray-800 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100/50 dark:hover:bg-gray-700/50' }}">
                    Bulan Ini
                </a>
                <a href="{{ route('admin.bookings', ['filter' => 'next_month']) }}"
                    class="px-4 py-1.5 rounded-md transition duration-200 font-medium
                                                {{ request('filter') == 'next_month' ? 'bg-white dark:bg-gray-700 shadow-sm text-gray-800 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100/50 dark:hover:bg-gray-700/50' }}">
                    Bulan Depan
                </a>
                <a href="{{ route('admin.bookings', ['filter' => 'year']) }}"
                    class="px-4 py-1.5 rounded-md transition duration-200 font-medium
                                                {{ request('filter') == 'year' ? 'bg-white dark:bg-gray-700 shadow-sm text-gray-800 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100/50 dark:hover:bg-gray-700/50' }}">
                    Tahun Ini
                </a>
            </div>

            <!-- COUNT -->
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 px-2">
                Total: <span class="text-gray-800 dark:text-gray-100">{{ $bookings->total() }}</span> Pemesanan
            </div>
        </div>

        <!-- TABLE CARD -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-sm text-left">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Jadwal & Lapangan</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Pembayaran</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 
                                                                                            {{ $booking->booking_type === 'online' ? 'bg-blue-100 text-blue-600' : ($booking->booking_type === 'block' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600') }}">
                                            {{ strtoupper(substr($booking->customer_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-100">
                                                {{ $booking->customer_name }}
                                                @if($booking->booking_type === 'offline')
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 ml-1">Walk-in</span>
                                                @elseif($booking->booking_type === 'block')
                                                    <span
                                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-600 ml-1">Blocked</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="font-semibold text-gray-800 dark:text-gray-100">{{ $booking->court->name }}</span>
                                            <span
                                                class="font-medium text-gray-700 dark:text-gray-200 text-sm">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</span>
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                                - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $booking->status_class }}">
                                        {{ $booking->status_label ?? ucfirst($booking->status) }}
                                    </span>
                                    @if($booking->voucher_id)
                                        <span
                                            class="inline-flex items-center gap-1 ml-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-500 px-2 py-0.5 rounded text-[10px] font-bold border border-yellow-200 dark:border-yellow-700/50"
                                            title="Menggunakan Voucher">
                                            <i data-lucide="ticket" class="w-3 h-3"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold border border-transparent
                                                                                                    {{ $booking->payment_status == 'waiting' ? 'bg-yellow-100 dark:bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 border-yellow-200 dark:border-yellow-500/20' : '' }}
                                                                                                    {{ $booking->payment_status == 'confirmed' ? 'bg-green-100 dark:bg-green-500/10 text-green-600 dark:text-green-400 border-green-200 dark:border-green-500/20' : '' }}
                                                                                                    {{ $booking->payment_status == 'rejected' ? 'bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 border-red-200 dark:border-red-500/20' : '' }}
                                                                                                    {{ !$booking->payment_status ? 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300' : '' }}">
                                        {{ $booking->payment_status ? ucfirst($booking->payment_status) : 'Unpaid' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($booking->status == 'pending_payment' || $booking->status == 'pending_verification')
                                            <button onclick="cancelBooking('{{ route('booking.cancel', $booking->id) }}')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-transparent dark:border-red-500/20 hover:bg-red-200 dark:hover:bg-red-500/20 transition duration-200">
                                                <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Batal
                                            </button>
                                        @elseif ($booking->status == 'confirmed')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-500/10 rounded-full border border-green-100 dark:border-green-500/20">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Aktif
                                            </span>
                                        @elseif ($booking->status == 'completed')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 rounded-full border border-blue-100 dark:border-blue-500/20">
                                                <i data-lucide="check-square" class="w-3.5 h-3.5"></i> Selesai
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500 italic">Tidak ada aksi</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-12 h-12 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3 border border-gray-100 dark:border-gray-600">
                                            <i data-lucide="inbox" class="w-6 h-6 text-gray-400 dark:text-gray-500"></i>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Belum ada pemesanan</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Data pemesanan akan muncul di
                                            sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION (If applicable) -->
            @if(method_exists($bookings, 'links'))
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmBooking(url) {
                Swal.fire({
                    title: 'Konfirmasi Booking?',
                    text: 'Booking akan disetujui',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Ya, Confirm',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'rounded-lg',
                        cancelButton: 'rounded-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }

            function cancelBooking(url) {
                Swal.fire({
                    title: 'Batalkan Booking?',
                    text: 'Booking akan dibatalkan secara permanen',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Ya, Cancel',
                    cancelButtonText: 'Kembali',
                    customClass: {
                        confirmButton: 'rounded-lg',
                        cancelButton: 'rounded-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }
        </script>
    @endpush
@endsection