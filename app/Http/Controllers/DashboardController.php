<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        Booking::syncStatus();

        $search = request('search');
        $now = now();

        $query = Booking::with('court')
            ->where('user_id', Auth::id());

        // SEARCH FILTER
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('court', fn($q2) =>
                    $q2->where('name', 'like', "%{$search}%"))
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%");
            });
        }

        // ACTIVE BOOKINGS (PENDING/CONFIRMED)
        $activeBookings = $query->clone()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($now) {
                $q->where('date', '>', $now->toDateString())
                    ->orWhere(function ($q2) use ($now) {
                        $q2->where('date', $now->toDateString())
                            ->where('end_time', '>', $now->format('H:i:s'));
                    });
            })
            ->latest()
            ->get();

        $activeBooking = $activeBookings->count();

        // PAYMENT DUE (PENDING w/ expired_at)
        $paymentDue = $query->clone()
            ->where('status', 'pending')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', $now)
            ->exists();

        // RECENT BOOKINGS
        $recentBookings = $query->clone()
            ->orderByDesc('date')
            ->orderByDesc('start_time')
            ->take(10)
            ->get();

        $totalBooking = $query->count();
        $courts = Court::where('status', 1)->count();

        return view('customer.dashboard', compact(
            'activeBookings',
            'recentBookings',
            'activeBooking',
            'paymentDue',
            'totalBooking',
            'courts',
            'search'
        ));
    }
}

