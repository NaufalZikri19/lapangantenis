<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    // LIST PAYMENT
    public function index()
    {
        $bookings = Booking::with(['user', 'court'])
            ->whereNotNull('payment_proof')
            ->latest()
            ->get();

        return view('admin.payments', compact('bookings'));
    }

    // APPROVE
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'payment_status' => 'confirmed',
            'status' => 'confirmed'
        ]);

        return back()->with('success', 'Payment approved');
    }

    // REJECT
    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'payment_status' => 'rejected',
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Payment rejected');
    }
}
