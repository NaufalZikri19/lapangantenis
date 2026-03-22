@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">
            Booking Management
        </h1>
    </div>


    <div class="bg-white rounded-2xl shadow-md p-6">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                    <tr class="text-left text-gray-400 border-b">
                        <th class="py-3">Customer</th>
                        <th>Court</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <!-- CUSTOMER -->
                            <td class="py-4 font-medium">
                                {{ $booking->user->name }}
                            </td>

                            <!-- COURT -->
                            <td>
                                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs">
                                    {{ $booking->court->name }}
                                </span>
                            </td>

                            <!-- DATE -->
                            <td>
                                {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                            </td>

                            <!-- TIME -->
                            <td class="text-gray-600">
                                {{ $booking->start_time }} - {{ $booking->end_time }}
                            </td>

                            <!-- STATUS -->
                            <td>
                                @if ($booking->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs">
                                        Pending
                                    </span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">
                                        Confirmed
                                    </span>
                                @elseif ($booking->status == 'completed')
                                    <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">
                                        Completed
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs">
                                        Cancelled
                                    </span>
                                @endif
                            </td>

                            <!-- ACTION -->
                            <td class="text-right space-x-2">

                                @if ($booking->status == 'pending')
                                    <a href="{{ route('booking.confirm', $booking->id) }}"
                                        class="text-green-600 hover:underline font-medium">
                                        Confirm
                                    </a>

                                    <a href="{{ route('booking.cancel', $booking->id) }}"
                                        class="text-red-500 hover:underline font-medium">
                                        Cancel
                                    </a>
                                @elseif ($booking->status == 'confirmed')
                                    <span class="text-gray-400 text-sm">Waiting</span>
                                @elseif ($booking->status == 'completed')
                                    <span class="text-gray-400 text-sm">Finished</span>
                                @else
                                    <span class="text-gray-400 text-sm">No Action</span>
                                @endif

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-400">
                                Belum ada booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
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
