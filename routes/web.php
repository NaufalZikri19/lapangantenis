<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\CourtController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

/*
|--------------------------------------------------------------------------
| Models
|--------------------------------------------------------------------------
*/

use App\Models\Court;
use App\Models\Booking;
use App\Models\User;



/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

Route::view('/contact', 'contact')->name('contact');



/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'nocache'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Redirect Dashboard (Role Based)
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    })->middleware(['verified'])->name('dashboard');



    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', function () {

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
                'recentBookings'
            ));
        })->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | COURTS CRUD
        |--------------------------------------------------------------------------
        */

        Route::resource('courts', CourtController::class);


        /*
        |--------------------------------------------------------------------------
        | BOOKING MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/bookings', [AdminBookingController::class, 'index'])
            ->name('admin.bookings');

        Route::get('/bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])
            ->name('booking.confirm');

        Route::get('/bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])
            ->name('booking.cancel');
    });



    /*
    |--------------------------------------------------------------------------
    | CUSTOMER ROUTES
    |--------------------------------------------------------------------------
    */

    Route::prefix('customer')->group(function () {

        Route::get('/dashboard', function () {
            return view('customer.dashboard');
        })->name('customer.dashboard');


        /*
        |--------------------------------------------------------------------------
        | BOOKING COURT
        |--------------------------------------------------------------------------
        */

        Route::get('/booking', [BookingController::class, 'create'])
            ->name('booking.create');

        Route::post('/booking', [BookingController::class, 'store'])
            ->name('booking.store');
    });



    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
