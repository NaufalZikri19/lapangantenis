<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/*
| Controllers
*/

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Admin\CourtController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\DashboardController as DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NotificationController;

/*
| Models
*/

use App\Models\Court;
use App\Models\Booking;
use App\Models\User;
use App\Models\Regency;
use App\Models\Province;



/*
| Public Routes
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('home');
});

Route::get('/terms', function () {
    return view('terms');
})->name('terms');




/*
| Authenticated Routes
*/

Route::middleware(['auth', 'nocache'])->group(function () {

    /*

    | Redirect Dashboard (Role Based)

    */

    Route::get('/dashboard', function () {

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    })->middleware(['verified'])->name('dashboard');



    /*

    | ADMIN ROUTES

    */

    Route::prefix('admin')
        ->middleware('is_admin')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('admin.dashboard');

            Route::resource('courts', CourtController::class);
            Route::get('/bookings', [AdminBookingController::class, 'index'])
                ->name('admin.bookings');

            Route::get('/bookings/create', [AdminBookingController::class, 'create'])
                ->name('admin.bookings.create');

            Route::post('/bookings', [AdminBookingController::class, 'store'])
                ->name('admin.bookings.store');

            Route::get('/bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])
                ->name('booking.confirm');

            Route::get('/bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])
                ->name('booking.cancel');

            Route::get('/payments', [PaymentController::class, 'index'])
                ->name('admin.payments');

            Route::get('/payments/{id}/approve', [PaymentController::class, 'approve'])
                ->name('admin.payments.approve');

            Route::post('/payments/{id}/reject', [PaymentController::class, 'reject'])
                ->name('admin.payments.reject');

            Route::get('/payments/{id}/claim', [PaymentController::class, 'claim'])
                ->name('admin.payments.claim');

            Route::get('/users', [UserController::class, 'index'])
                ->name('admin.users');

            Route::get('/users/{id}', [UserController::class, 'show'])
                ->name('admin.users.show');

            Route::get('/users/{id}/edit', [UserController::class, 'edit'])
                ->name('admin.users.edit');

            Route::put('/users/{id}', [UserController::class, 'update'])
                ->name('admin.users.update');

            Route::delete('/users/{id}', [UserController::class, 'destroy'])
                ->name('admin.users.delete');

            Route::get('/users/{id}/export/bookings', [UserController::class, 'exportBookingPdf'])
                ->name('admin.users.export.bookings');
        });





    /*

    | CUSTOMER ROUTES

    */

    Route::prefix('customer')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('customer.dashboard');

        Route::middleware(['profile.complete'])->group(function () {

            Route::get('/booking', [BookingController::class, 'create'])
                ->name('booking.create');

            Route::post('/booking', [BookingController::class, 'store'])
                ->name('booking.store');

            Route::get('/payment/{id}', [BookingController::class, 'payment'])
                ->name('booking.payment');

            Route::post('/payment/{id}', [BookingController::class, 'uploadPayment'])
                ->name('booking.uploadPayment');

            Route::get('/receipt/{id}', [BookingController::class, 'receipt'])
                ->name('booking.receipt');
        });

        Route::get('/check-availability', [BookingController::class, 'checkAvailability'])
            ->name('booking.check');
    });

    /*

    | CHATBOT ROUTE

    */
    Route::post('/chatbot', [ChatbotController::class, 'handleChat'])->name('chatbot.handle');

    /*

    | PROFILE

    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/biodata', [ProfileController::class, 'updateBiodata'])
        ->name('profile.biodata.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | NOTIFICATIONS
    */
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/all', [NotificationController::class, 'all'])->name('notifications.all');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});



require __DIR__ . '/auth.php';
