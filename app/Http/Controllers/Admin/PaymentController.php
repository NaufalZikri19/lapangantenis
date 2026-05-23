<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Services\BookingService;
use Exception;
class PaymentController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    // LIST PAYMENT
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'court', 'handler'])
            ->whereNotNull('payment_proof');

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

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

    // CLAIM
    public function claim($id)
    {
        $booking = Booking::findOrFail($id);

        try {
            $this->bookingService->claimVerification($booking, auth()->user());
            return back()->with('success', 'Booking berhasil diambil alih untuk diverifikasi.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // APPROVE
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        try {
            $this->bookingService->approvePayment($booking, auth()->user());
            return back()->with('success', 'Payment approved');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // REJECT
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $booking = Booking::findOrFail($id);

        try {
            $this->bookingService->rejectPayment($booking, auth()->user(), $request->rejection_reason);
            return back()->with('success', 'Payment rejected');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
