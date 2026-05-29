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
        Booking::syncStatus();

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
                    ->orWhere('date', 'like', "%{$search}%")
                    ->orWhere('guest_name', 'like', "%{$search}%");

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

        if ($request->filter === 'next_month') {
            $query->whereMonth('date', Carbon::now()->addMonth()->month)
                ->whereYear('date', Carbon::now()->addMonth()->year);
        }

        if ($request->filter === 'year') {
            $query->whereYear('date', Carbon::now()->year);
        }

        // PAGINATION
        $bookings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $courts = \App\Models\Court::all();
        $users = \App\Models\User::where('role', 'customer')->get();
        return view('admin.bookings.create', compact('courts', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_type' => 'required|in:offline,block',
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // Check availability
        $isBooked = Booking::where('court_id', $request->court_id)
            ->where('date', $request->date)
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->whereNotIn('status', ['cancelled', 'expired', 'rejected'])
            ->exists();

        if ($isBooked) {
            return back()->with('error', 'Jadwal tersebut sudah dibooking/diblokir.');
        }

        $court = \App\Models\Court::findOrFail($request->court_id);

        // Calculate total price based on hours if offline
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $hours = $start->diffInHours($end) ?: 1;
        $totalPrice = $request->booking_type === 'block' ? 0 : ($court->price * $hours);

        $booking = new Booking();
        $booking->court_id = $request->court_id;
        $booking->date = $request->date;
        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        $booking->booking_type = $request->booking_type;
        $booking->total_price = $totalPrice;
        $booking->handled_by = auth()->id();

        if ($request->booking_type === 'offline') {
            if ($request->filled('user_id')) {
                $booking->user_id = $request->user_id;
            } else {
                $booking->guest_name = $request->guest_name ?? 'Tamu Offline';
            }
            $booking->status = 'confirmed';
            $booking->payment_status = 'confirmed';
            $booking->payment_method = 'cash';
            $booking->paid_at = now();
        } else {
            // Block type
            $booking->status = 'confirmed';
            $booking->payment_status = 'confirmed'; // to show in index
        }

        $booking->save();

        $msg = $request->booking_type === 'block' ? 'Jadwal berhasil diblokir.' : 'Pemesanan offline berhasil ditambahkan.';
        return redirect()->route('admin.bookings')->with('success', $msg);
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

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return back()->with('success', 'Booking berhasil dihapus');
    }
}
