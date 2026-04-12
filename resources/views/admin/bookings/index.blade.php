@extends('layouts.admin')

@section('content')
    <div class="bg-white border rounded-2xl shadow-sm p-5 mb-6">

        <!-- TOP -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <!-- TITLE -->
            <div class="flex items-center gap-3">

                <div class="p-2 bg-gray-100 text-gray-600 rounded-lg">
                    <i data-lucide="table" class="w-5 h-5"></i>
                </div>

                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">
                        Booking Management
                    </h1>
                    <p class="text-sm text-gray-500">
                        Manage and monitor all booking activities
                    </p>
                </div>

            </div>

            <!-- SEARCH -->
            <form method="GET" class="relative w-full md:w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Data Booking..."
                    class="w-full pl-10 pr-3 py-2 text-sm border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-2.5 text-gray-400"></i>
            </form>

        </div>

        <!-- FILTER BAR -->
        <div class="flex flex-wrap items-center justify-between mt-5 gap-3">

            <!-- SEGMENTED FILTER -->
            <div class="flex bg-gray-100 p-1 rounded-lg text-sm">

                <a href="{{ route('admin.bookings') }}"
                    class="px-4 py-1.5 rounded-md transition
                {{ !request('filter') ? 'bg-white shadow text-gray-900' : 'text-gray-500' }}">
                    View all
                </a>

                <a href="{{ route('admin.bookings', ['filter' => 'month']) }}"
                    class="px-4 py-1.5 rounded-md transition
                {{ request('filter') == 'month' ? 'bg-white shadow text-gray-900' : 'text-gray-500' }}">
                    This Month
                </a>

                <a href="{{ route('admin.bookings', ['filter' => 'year']) }}"
                    class="px-4 py-1.5 rounded-md transition
                {{ request('filter') == 'year' ? 'bg-white shadow text-gray-900' : 'text-gray-500' }}">
                    This Year
                </a>

            </div>

            <!-- COUNT -->
            <div class="text-sm text-gray-500">
                {{ $bookings->total() }} bookings
            </div>

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow border overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="p-4 text-left">Customer</th>
                        <th class="p-4 text-left">Court</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Time</th>
                        <th class="p-4">Booking</th>
                        <th class="p-4">Payment</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">

                            <!-- CUSTOMER -->
                            <td class="p-4 font-medium text-gray-700">
                                {{ $booking->user->name }}
                            </td>

                            <!-- COURT -->
                            <td class="p-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                                    {{ $booking->court->name }}
                                </span>
                            </td>

                            <!-- DATE -->
                            <td class="p-4 text-gray-600">
                                {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                            </td>

                            <!-- TIME -->
                            <td class="p-4 text-gray-600">
                                {{ $booking->start_time }} - {{ $booking->end_time }}
                            </td>

                            <!-- BOOKING STATUS -->
                            <td class="p-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                    {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-600' : '' }}
                                    {{ $booking->status == 'completed' ? 'bg-gray-200 text-gray-600' : '' }}
                                    {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-600' : '' }}
                                ">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>

                            <!-- PAYMENT STATUS -->
                            <td class="p-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $booking->payment_status == 'waiting' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                    {{ $booking->payment_status == 'confirmed' ? 'bg-green-100 text-green-600' : '' }}
                                    {{ $booking->payment_status == 'rejected' ? 'bg-red-100 text-red-600' : '' }}
                                    {{ !$booking->payment_status ? 'bg-gray-100 text-gray-400' : '' }}
                                ">
                                    {{ $booking->payment_status ?? 'Not Paid' }}
                                </span>
                            </td>

                            <!-- ACTION -->
                            <td class="p-4 text-right space-x-2">

                                @if ($booking->status == 'pending')
                                    <button onclick="cancelBooking('{{ route('booking.cancel', $booking->id) }}')"
                                        class="px-3 py-1 text-xs rounded-lg bg-red-500 text-white hover:bg-red-400">
                                        Cancel
                                    </button>
                                @elseif ($booking->status == 'confirmed')
                                    <span class="text-xs text-gray-400">Active</span>
                                @elseif ($booking->status == 'completed')
                                    <span class="text-xs text-gray-400">Finished</span>
                                @else
                                    <span class="text-xs text-gray-400">No Action</span>
                                @endif

                                <!-- VIEW PAYMENT -->
                                @if ($booking->payment_proof)
                                    <a href="{{ route('admin.payments') }}" class="text-xs text-blue-500 hover:underline">
                                        Payment
                                    </a>
                                @endif

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-400">
                                Belum ada booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    <!-- SWEET ALERT -->
    <script>
        function confirmBooking(url) {
            Swal.fire({
                title: 'Konfirmasi Booking?',
                text: 'Booking akan disetujui',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Confirm',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        function cancelBooking(url) {
            Swal.fire({
                title: 'Batalkan Booking?',
                text: 'Booking akan dibatalkan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Cancel',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection
