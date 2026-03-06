<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
});

Route::view('/contact', 'contact')->name('contact');



Route::middleware('auth', 'nocache')->group(function () {

    Route::get('/dashboard', function () {

        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/customer/dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');

    Route::get('/dashboard/booking', function () {
        return view('booking');
    })->name('booking');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
