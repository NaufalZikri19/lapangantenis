<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/*
| Controllers
*/

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\CourtController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

/*
| Models
*/

use App\Models\Court;
use App\Models\Booking;
use App\Models\User;



/*
| Public Routes
*/

Route::get('/', function () {
    return view('home');
});


/*
| Authenticated Routes
*/

Route::middleware(['auth', 'nocache'])->group(function () {

    /*

    | Redirect Dashboard (Role Based)

    */

    Route::get('/dashboard', function () {

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    })->middleware(['verified'])->name('dashboard');



    /*

    | ADMIN ROUTES

    */

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', function () {

            $today = Carbon::today();
            $todaySchedule = Booking::with('court')
                ->whereDate('date', $today)
                ->orderBy('start_time')
                ->get();

            $confirmed = Booking::where('status', 'confirmed')->count();
            $pending = Booking::where('status', 'pending')->count();
            $cancelled = Booking::where('status', 'cancelled')->count();

            $totalCourts = Court::count();

            $todayBookings = Booking::whereDate('date', Carbon::today())->count();

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
                'cancelled',
                'recentBookings'
            ));
        })->name('admin.dashboard');


        /*
    
        | COURTS CRUD
    
        */

        Route::resource('courts', CourtController::class);


        /*
    
        | BOOKING MANAGEMENT
    
        */

        Route::get('/bookings', [AdminBookingController::class, 'index'])
            ->name('admin.bookings');

        Route::get('/bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])
            ->name('booking.confirm');

        Route::get('/bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])
            ->name('booking.cancel');
    });



    /*

    | CUSTOMER ROUTES

    */

    Route::prefix('customer')->group(function () {

        Route::get('/dashboard', function () {
            $activeBookings = Booking::with('court')
                ->where('user_id', Auth::id())
                ->whereIn('status', ['pending', 'confirmed'])
                ->get();
            $recentBookings = Booking::with('court')
                ->where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();
            $activeBooking = $activeBookings->count();

            $totalBooking = Booking::where('user_id', Auth::id())->count();

            $courts = Court::where('status', 1)->count();

            return view('customer.dashboard', compact(
                'activeBookings',
                'recentBookings',
                'activeBooking',
                'totalBooking',
                'courts'
            ));
        })->name('customer.dashboard');

        /*
    
        | BOOKING COURT
    
        */

        Route::get('/booking', [BookingController::class, 'create'])
            ->name('booking.create');

        Route::post('/booking', [BookingController::class, 'store'])
            ->name('booking.store');

        Route::get('/check-availability', [BookingController::class, 'checkAvailability'])
            ->name('booking.check');
    });



    /*

    | PROFILE

    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
