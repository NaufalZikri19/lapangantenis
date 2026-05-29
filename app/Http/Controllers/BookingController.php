<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BookingRequest;
use App\Services\BookingService;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }
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
    public function store(BookingRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isBiodataIncomplete()) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Lengkapi data diri terlebih dahulu');
        }

        $slots = json_decode($request->slots, true);

        try {
            $booking = $this->bookingService->processBooking(
                Auth::id(),
                $request->court_id,
                $request->booking_date,
                $slots,
                $request->voucher_code
            );

            Auth::user()->notify(new \App\Notifications\BookingCreatedNotification($booking));

            if ($booking->status === 'confirmed') {
                return redirect()->route('booking.receipt', $booking->id)
                    ->with('success', 'Booking berhasil! Pembayaran tertutup oleh Voucher.');
            }

            return redirect()->route('booking.payment', $booking->id)
                ->with('success', 'Booking berhasil! Silakan lakukan pembayaran');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
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

        if ($booking->status === 'confirmed') {
            return redirect()->route('customer.dashboard')
                ->with('success', 'Booking sudah dikonfirmasi');
        }

        if ($booking->status !== 'pending_payment') {
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

        if ($booking->status === 'confirmed') {
            return back()->with('error', 'Pembayaran sudah dikonfirmasi');
        }

        if ($booking->status === 'pending_verification') {
            return back()->with('error', 'Pembayaran sedang diverifikasi');
        }

        $request->validate([
            'payment_method' => 'required|in:qris,transfer',
            'payment_proof' => 'required|image|max:2048',
            'agree_terms' => 'required'
        ], [
            'agree_terms.required' => 'Anda harus menyetujui Syarat & Ketentuan.'
        ]);

        $file = $request->file('payment_proof')->store('payments', 'public');

        $booking->update([
            'payment_method' => $request->payment_method,
            'payment_proof' => $file,
            'status' => 'pending_verification',
            'payment_status' => 'waiting', // Kept for backwards compatibility just in case, though status is now the source of truth
            'paid_at' => now()
        ]);

        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\PaymentUploadedNotification($booking));

        return redirect()->route('booking.receipt', $booking->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim');
    }

    // RECEIPT PAGE
    public function receipt($id)
    {
        $booking = Booking::with('court')->findOrFail($id);

        if (!$this->authorizeUser($booking)) {
            abort(403);
        }

        return view('customer.receipt', compact('booking'));
    }

    // CANCEL WITH VOUCHER
    public function cancelWithVoucher($id)
    {
        $booking = Booking::findOrFail($id);

        try {
            $voucher = $this->bookingService->cancelAndGenerateVoucher($booking, Auth::user());
            
            if ($voucher) {
                return back()->with('success', "Pesanan dibatalkan. Anda mendapatkan Voucher: {$voucher->code} senilai Rp " . number_format($voucher->amount, 0, ',', '.'));
            }
            
            return back()->with('success', "Pesanan berhasil dibatalkan.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // VOUCHERS PAGE
    public function vouchers()
    {
        $vouchers = \App\Models\Voucher::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('customer.vouchers', compact('vouchers'));
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
            ->whereIn('status', ['confirmed', 'pending_payment', 'pending_verification'])
            ->get(['start_time', 'end_time']);

        return response()->json($bookings);
    }



    private function authorizeUser($booking)
    {
        return $booking->user_id === Auth::id();
    }

    private function isExpired($booking)
    {
        return $booking->status === 'pending_payment'
            && $booking->expired_at
            && now()->gt($booking->expired_at);
    }
}