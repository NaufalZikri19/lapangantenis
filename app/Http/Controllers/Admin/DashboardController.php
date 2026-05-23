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
            ->whereIn('status', ['pending_payment', 'pending_verification', 'confirmed'])
            ->orderBy('start_time')
            ->get();

        $confirmed = Booking::where('status', 'confirmed')->count();
        $pending = Booking::whereIn('status', ['pending_payment', 'pending_verification'])->count();
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

        // Revenue Logic
        $validBookings = Booking::where('payment_status', 'confirmed')
            ->where('status', '!=', 'cancelled');

        $totalRevenue = (clone $validBookings)->sum('total_price');
        $todayRevenue = (clone $validBookings)
            ->whereDate('paid_at', today())
            ->sum('total_price');
        $monthlyRevenue = (clone $validBookings)
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('total_price');

        $chartData = (clone $validBookings)
            ->where('paid_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(paid_at) as date, SUM(total_price) as total')
            ->groupByRaw('DATE(paid_at)')
            ->orderBy('date')
            ->pluck('total', 'date');

        $revenueChartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateStr = now()->subDays($i)->format('Y-m-d');
            $revenueChartData[$dateStr] = (float) $chartData->get($dateStr, 0);
        }

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
            'recentBookings',
            'totalRevenue',
            'todayRevenue',
            'monthlyRevenue',
            'revenueChartData'
        ));
    }
}