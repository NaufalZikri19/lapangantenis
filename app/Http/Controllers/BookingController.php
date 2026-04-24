<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // FORM BOOKING
    public function create()
    {
        if (auth()->user()->isBiodataIncomplete()) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Lengkapi data diri terlebih dahulu');
        }

        $courts = Court::where('status', 1)->get();
        return view('customer.booking', compact('courts'));
    }

    // STORE BOOKING
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isBiodataIncomplete()) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Lengkapi data diri terlebih dahulu');
        }

        $this->validateRequest($request);

        $slots = json_decode($request->slots, true);

        if (empty($slots)) {
            return back()->with('error', 'Pilih slot terlebih dahulu');
        }

        if (!$this->validateSlots($slots)) {
            return back()->with('error', 'Format slot tidak valid');
        }

        usort($slots, fn($a, $b) => strcmp($a['start'], $b['start']));

        if (!$this->validateSequentialSlots($slots)) {
            return back()->with('error', 'Slot harus berurutan');
        }

        if (!$this->validateOperationalHours($slots)) {
            return back()->with('error', 'Di luar jam operasional atau bukan jam bulat');
        }

        return $this->processBooking($request, $slots);
    }

    // PAYMENT PAGE
    public function payment($id)
    {
        $booking = Booking::with('court')->findOrFail($id);

        if (!$this->authorizeUser($booking)) {
            abort(403);
        }

        if ($this->isExpired($booking)) {
            $booking->update(['status' => 'expired']);

            return redirect()->route('customer.dashboard')
                ->with('error', 'Booking sudah expired');
        }

        if ($booking->payment_status === 'confirmed') {
            return redirect()->route('customer.dashboard')
                ->with('success', 'Booking sudah dikonfirmasi');
        }

        if ($booking->status !== 'pending') {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.payment', compact('booking'));
    }

    // UPLOAD PAYMENT
    public function uploadPayment(Request $request, $id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$this->authorizeUser($booking)) {
            abort(403);
        }

        if ($this->isExpired($booking)) {
            $booking->update(['status' => 'expired']);
            return back()->with('error', 'Booking sudah expired');
        }

        if ($booking->payment_status === 'confirmed') {
            return back()->with('error', 'Pembayaran sudah dikonfirmasi');
        }

        if ($booking->payment_status === 'waiting') {
            return back()->with('error', 'Pembayaran sedang diverifikasi');
        }

        $request->validate([
            'payment_method' => 'required|in:qris,transfer',
            'payment_proof' => 'required|image|max:2048'
        ]);

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
            ->whereIn('status', ['confirmed', 'pending'])
            ->get(['start_time', 'end_time']);

        return response()->json($bookings);
    }

    // PRIVATE METHODS 

    private function validateRequest($request)
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'slots' => 'required'
        ]);
    }

    private function validateSlots($slots)
    {
        if (!$slots || !is_array($slots))
            return false;

        foreach ($slots as $slot) {
            if (!isset($slot['start']) || !isset($slot['end'])) {
                return false;
            }
        }

        return true;
    }

    private function validateSequentialSlots($slots)
    {
        for ($i = 0; $i < count($slots) - 1; $i++) {
            if ($slots[$i]['end'] !== $slots[$i + 1]['start']) {
                return false;
            }
        }
        return true;
    }

    private function validateOperationalHours($slots)
    {
        $open = 8;
        $close = 22;

        foreach ($slots as $slot) {
            $start = strtotime($slot['start']);
            $end = strtotime($slot['end']);

            if ((int) date('H', $start) < $open || (int) date('H', $end) > $close) {
                return false;
            }

            if (date('i', $start) != '00' || date('i', $end) != '00') {
                return false;
            }
        }

        return true;
    }

    private function hasConflict($request, $slot)
    {
        return Booking::where('court_id', $request->court_id)
            ->where('date', $request->booking_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($slot) {
                $query->where('start_time', '<', $slot['end'])
                    ->where('end_time', '>', $slot['start']);
            })
            ->lockForUpdate()
            ->exists();
    }

    private function processBooking($request, $slots)
    {
        DB::beginTransaction();

        try {
            foreach ($slots as $slot) {
                if ($this->hasConflict($request, $slot)) {
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
                'status' => 'pending',
                'expired_at' => now()->addMinutes(1)
            ]);

            DB::commit();

            return redirect()->route('booking.payment', $booking->id)
                ->with('success', 'Booking berhasil! Silakan lakukan pembayaran');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return back()->with('error', 'Terjadi kesalahan, coba lagi');
        }
    }

    private function authorizeUser($booking)
    {
        return $booking->user_id === Auth::id();
    }

    private function isExpired($booking)
    {
        return $booking->status === 'pending'
            && $booking->expired_at
            && now()->gt($booking->expired_at);
    }
}