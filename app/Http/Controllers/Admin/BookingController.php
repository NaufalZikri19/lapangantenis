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

        $booking->status = 'confirmed';
        $booking->save();

        return back()->with('success', 'Booking confirmed');
    }


    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'cancelled';
        $booking->save();

        return back()->with('success', 'Booking cancelled');
    }
}
