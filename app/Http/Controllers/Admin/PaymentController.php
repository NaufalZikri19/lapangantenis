<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    // LIST PAYMENT
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'court'])
            ->whereNotNull('payment_proof');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%");
                })->orWhereHas('court', function ($qc) use ($search) {
                    $qc->where('name', 'like', "%{$search}%");
                })->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhere('paid_at', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

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
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Payment rejected');
    }
}
