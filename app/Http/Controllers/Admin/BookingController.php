<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'court'])
            ->latest()
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);

        // hanya bisa confirm kalau masih pending
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking tidak bisa diubah');
        }

        $booking->update([
            'status' => 'confirmed'
        ]);

        return back()->with('success', 'Booking berhasil dikonfirmasi');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        // hanya bisa cancel kalau masih pending
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking tidak bisa dibatalkan');
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Booking berhasil dibatalkan');
    }
}
