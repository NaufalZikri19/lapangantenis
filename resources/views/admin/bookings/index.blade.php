@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">
        Booking Management
    </h1>

    <div class="bg-white rounded-xl shadow p-6">

        <table class="w-full text-sm">

            <thead class="border-b text-gray-500">
                <tr>
                    <th>Customer</th>
                    <th>Court</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($bookings as $booking)
                    <tr class="border-b">

                        <td>{{ $booking->user->name }}</td>

                        <td>{{ $booking->court->name }}</td>

                        <td>{{ $booking->date }}</td>

                        <td>
                            {{ $booking->start_time }} - {{ $booking->end_time }}
                        </td>

                        <td>

                            @if ($booking->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                                    Pending
                                </span>
                            @elseif($booking->status == 'confirmed')
                                <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                                    Confirmed
                                </span>
                            @else
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">
                                    Cancelled
                                </span>
                            @endif

                        </td>

                        <td class="space-x-2">

                            <a href="{{ route('booking.confirm', $booking->id) }}" class="text-green-600">
                                Confirm
                            </a>

                            <a href="{{ route('booking.cancel', $booking->id) }}" class="text-red-600">
                                Cancel
                            </a>

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>
@endsection
