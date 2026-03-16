<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    // Menampilkan halaman booking
    public function create()
    {
        $courts = Court::where('status', 1)->get();

        return view('customer.booking', compact('courts'));
    }


    // Menyimpan booking
    public function store(Request $request)
    {

        // Validasi input
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time'
        ]);


        // Cek apakah lapangan sudah dibooking
        $exists = Booking::where('court_id', $request->court_id)
            ->where('date', $request->booking_date)
            ->where(function ($query) use ($request) {

                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();


        if ($exists) {

            return back()->with('error', 'Lapangan sudah dibooking pada jam tersebut.');
        }
        // Simpan booking
        Booking::create([

            'user_id' => Auth::id(),
            'court_id' => $request->court_id,
            'date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'pending'

        ]);


        return redirect()->route('customer.dashboard')
            ->with('success', 'Booking berhasil dibuat!');
    }
}
