<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // LIST + SEARCH + PAGINATION
    public function index(Request $request)
    {
        // AUTO COMPLETE BOOKING
        Booking::autoComplete();

        $query = Booking::with(['user', 'court']);

        //  SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // user name
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })

                // court name
                ->orWhereHas('court', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })

                // date
                ->orWhere('date', 'like', "%{$search}%")

                // status
                ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // 📄 PAGINATION (lebih ringan dari get())
        $bookings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }


    // CONFIRM BOOKING
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);

        // ❗ hanya pending yang boleh diubah
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking tidak bisa diubah');
        }

        $booking->update([
            'status' => 'confirmed'
        ]);

        return back()->with('success', 'Booking berhasil dikonfirmasi');
    }


    // CANCEL BOOKING
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        // ❗ hanya pending yang boleh diubah
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking tidak bisa dibatalkan');
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Booking berhasil dibatalkan');
    }
}
