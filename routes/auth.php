<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;

// الصفحة الرئيسية وتوجيهات المصادقة
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return view('auth.login');
});

Auth::routes();
Auth::routes(['register' => false]); // يمكن تفعيلها لتعطيل التسجيل

Route::middleware(['auth', 'user.active'])->group(function () {
    // الصفحة الرئيسية
    Route::get('/home', [HomeController::class, 'index'])->name('home');

        // البحث المتقدم
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    // حجز الفعالية
    Route::get('/events/{event}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/events/{event}/book', [BookingController::class, 'store'])->name('bookings.store');

    // إدارة الحجوزات
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::delete('/my-bookings/{booking}', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/user/home', [HomeController::class, 'homePage'])->name('user.home');
});
