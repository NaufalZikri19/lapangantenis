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
        // ✅ VALIDASI DASAR
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date',
            'slots' => 'required'
        ]);

        // ❗ Decode slots dari frontend
        $slots = json_decode($request->slots, true);

        if (!$slots || count($slots) === 0) {
            return back()->with('error', 'Pilih minimal 1 slot');
        }

        // ❗ Tidak boleh booking tanggal lalu
        if ($request->booking_date < now()->toDateString()) {
            return back()->with('error', 'Tidak bisa booking di tanggal yang sudah lewat');
        }

        // 🔥 SORT SLOT
        usort($slots, function ($a, $b) {
            return strcmp($a['start'], $b['start']);
        });

        // 🔥 VALIDASI SLOT BERURUTAN
        for ($i = 0; $i < count($slots) - 1; $i++) {
            if ($slots[$i]['end'] !== $slots[$i + 1]['start']) {
                return back()->with('error', 'Slot harus berurutan (tidak boleh loncat)');
            }
        }

        // 🔥 VALIDASI JAM OPERASIONAL
        $open = 8;
        $close = 22;

        foreach ($slots as $slot) {

            $start = strtotime($slot['start']);
            $end = strtotime($slot['end']);

            $startHour = (int) date('H', $start);
            $endHour = (int) date('H', $end);

            if ($startHour < $open || $endHour > $close) {
                return back()->with('error', 'Di luar jam operasional');
            }

            // 🔥 CEK FORMAT SLOT HARUS JAM BULAT
            if (date('i', $start) != '00' || date('i', $end) != '00') {
                return back()->with('error', 'Slot harus sesuai jam yang tersedia');
            }

            // 🔥 CEK BENTROK PER SLOT (INI YANG PENTING!)
            $isConflict = Booking::where('court_id', $request->court_id)
                ->where('date', $request->booking_date)
                ->where(function ($query) use ($slot) {
                    $query->where('start_time', '<', $slot['end'])
                        ->where('end_time', '>', $slot['start']);
                })
                ->exists();

            if ($isConflict) {
                return back()->with('error', 'Salah satu jam sudah dibooking!');
            }
        }

        // 🔥 AMBIL RANGE FINAL (DIGABUNG)
        $start_time = $slots[0]['start'];
        $end_time = $slots[count($slots) - 1]['end'];

        // ✅ SIMPAN (1 ROW DIGABUNG)
        Booking::create([
            'user_id' => Auth::id(),
            'court_id' => $request->court_id,
            'date' => $request->booking_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
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
