<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    // LIST + SEARCH + PAGINATION
    public function index(Request $request)
    {
        // AUTO COMPLETE BOOKING
        Booking::autoComplete();

        $query = Booking::with(['user', 'court']);

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // NORMAL SEARCH

                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('court', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%");

                // MONTH SEARCH

                try {
                    $month = Carbon::parse($search)->month;

                    $q->orWhereMonth('date', $month);
                } catch (\Exception $e) {
                    // ignore kalau bukan format tanggal
                }

                // YEAR SEARCH

                if (is_numeric($search) && strlen($search) == 4) {
                    $q->orWhereYear('date', $search);
                }
            });
        }

        // FILTER BARU
        if ($request->filter === 'month') {
            $query->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year);
        }

        if ($request->filter === 'year') {
            $query->whereYear('date', Carbon::now()->year);
        }

        // PAGINATION (lebih ringan dari get())
        $bookings = $query->where('payment_status', 'confirmed')->latest()->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
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
