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
        // ✅ VALIDASI INPUT
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time'
        ]);

        if (!$request->start_time || !$request->end_time) {
            return back()->with('error', 'Pilih slot terlebih dahulu');
        }
        
        // ❗ Tidak boleh booking tanggal lalu
        if ($request->booking_date < now()->toDateString()) {
            return back()->with('error', 'Tidak bisa booking di tanggal yang sudah lewat');
        }

        //CEK JAM TERSEDIA
        $isConflict = Booking::where('court_id', $request->court_id)
            ->where('date', $request->booking_date)
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($isConflict) {
            return back()->with('error', 'Jam sudah dibooking, pilih waktu lain!');
        }

        // ✅ SIMPAN DATA
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

    public function checkAvailability(Request $request)
    {
        $bookings = Booking::where('court_id', $request->court_id)
            ->where('date', $request->date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['start_time', 'end_time']);

        return response()->json($bookings);
    }
}
