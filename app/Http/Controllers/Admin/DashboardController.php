<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        Booking::syncStatus();

        $today = Carbon::today();

        $todaySchedule = Booking::with('court')
            ->whereDate('date', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('start_time')
            ->get();

        $confirmed = Booking::where('status', 'confirmed')->count();
        $pending = Booking::where('status', 'pending')->count();
        $completed = Booking::where('status', 'completed')->count();
        $cancelled = Booking::where('status', 'cancelled')->count();
        $expired = Booking::where('status', 'expired')->count();

        $totalCourts = Court::count();
        $todayBookings = Booking::whereDate('date', $today)->count();
        $totalCustomers = User::where('role', 'customer')->count();

        $recentBookings = Booking::with(['user', 'court'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCourts',
            'todayBookings',
            'totalCustomers',
            'todaySchedule',
            'confirmed',
            'pending',
            'completed',
            'cancelled',
            'expired',
            'recentBookings'
        ));
    }
}