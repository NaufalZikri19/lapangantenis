<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{

    // FORM BOOKING
    public function create()
    {
        $courts = Court::where('status', 1)->get();

        return view('customer.booking', compact('courts'));
    }


    // STORE BOOKING
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'slots' => 'required'
        ]);

        $slots = json_decode($request->slots, true);

        if (!$slots || !is_array($slots)) {
            return back()->with('error', 'Format slot tidak valid');
        }

        foreach ($slots as $slot) {
            if (!isset($slot['start']) || !isset($slot['end'])) {
                return back()->with('error', 'Format slot tidak valid');
            }
        }

        usort($slots, fn($a, $b) => strcmp($a['start'], $b['start']));

        // VALIDASI BERURUTAN
        for ($i = 0; $i < count($slots) - 1; $i++) {
            if ($slots[$i]['end'] !== $slots[$i + 1]['start']) {
                return back()->with('error', 'Slot harus berurutan');
            }
        }

        // VALIDASI JAM OPERASIONAL
        $open = 8;
        $close = 22;

        foreach ($slots as $slot) {

            $start = strtotime($slot['start']);
            $end = strtotime($slot['end']);

            if ((int)date('H', $start) < $open || (int)date('H', $end) > $close) {
                return back()->with('error', 'Di luar jam operasional');
            }

            if (date('i', $start) != '00' || date('i', $end) != '00') {
                return back()->with('error', 'Slot harus jam bulat');
            }
        }

        DB::beginTransaction();

        try {

            foreach ($slots as $slot) {

                $isConflict = Booking::where('court_id', $request->court_id)
                    ->where('date', $request->booking_date)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->lockForUpdate()
                    ->where(function ($query) use ($slot) {
                        $query->where('start_time', '<', $slot['end'])
                            ->where('end_time', '>', $slot['start']);
                    })
                    ->exists();

                if ($isConflict) {
                    DB::rollBack();
                    return back()->with('error', 'Slot sudah dibooking orang lain!');
                }
            }

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'court_id' => $request->court_id,
                'date' => $request->booking_date,
                'start_time' => $slots[0]['start'],
                'end_time' => $slots[count($slots) - 1]['end'],
                'status' => 'pending'
            ]);

            DB::commit();

            return redirect()->route('booking.payment', $booking->id)
                ->with('success', 'Booking berhasil! Silakan lakukan pembayaran');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan, coba lagi');
        }
    }


    // HALAMAN PAYMENT
    public function payment($id)
    {
        $booking = Booking::with('court')->findOrFail($id);

        // SECURITY
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // JIKA SUDAH DIBAYAR
        if ($booking->payment_status === 'confirmed') {
            return redirect()->route('customer.dashboard')
                ->with('success', 'Booking sudah dikonfirmasi');
        }

        return view('customer.payment', compact('booking'));
    }


    // UPLOAD PAYMENT
    public function uploadPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,transfer',
            'payment_proof' => 'required|image|max:2048'
        ]);

        $booking = Booking::findOrFail($id);

        // SECURITY
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // SUDAH DIBAYAR
        if ($booking->payment_status === 'confirmed') {
            return back()->with('error', 'Pembayaran sudah dikonfirmasi');
        }

        // SEDANG DIPROSES
        if ($booking->payment_status === 'waiting') {
            return back()->with('error', 'Pembayaran sedang diverifikasi');
        }

        $file = $request->file('payment_proof')->store('payments', 'public');

        $booking->update([
            'payment_method' => $request->payment_method,
            'payment_proof' => $file,
            'payment_status' => 'waiting',
            'paid_at' => now()
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Bukti pembayaran berhasil dikirim');
    }


    // CHECK AVAILABILITY
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date'
        ]);

        $bookings = Booking::where('court_id', $request->court_id)
            ->where('date', $request->date)
            ->whereIn('status', ['confirmed', 'ongoing'])
            ->get(['start_time', 'end_time']);

        return response()->json($bookings);
    }
}
