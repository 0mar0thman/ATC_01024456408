<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingUserController;

Route::middleware(['auth', 'user.active'])->group(function () {
    Route::resource('bookings', BookingController::class)->except(['create', 'store']);
    // حجوزات المشرف / الأدمن (التحكم الكامل) 
    Route::get('/bookings/create/{event_id}', [BookingController::class, 'create'])->name('bookings.create.event');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/users/{user_id}/bookings', [BookingController::class, 'userBookings'])->name('bookings.user');
    Route::post('/bookings/{id}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::get('export_bookings', [BookingController::class, 'export'])->name('bookings.export');

    // حجوزات المستخدم (واجهة المستخدم)
    Route::get('user/bookings', [BookingUserController::class, 'index'])->name('user.bookings.index'); // عرض حجوزات المستخدم
    Route::get('user/bookings/create/{create}', [BookingUserController::class, 'create'])->name('user.bookings.create'); // حجز فعالية
    Route::post('user/bookings/{event}', [BookingUserController::class, 'store'])->name('user.bookings.store'); // حفظ الحجز
    Route::get('user/bookings/show/{booking}', [BookingUserController::class, 'show'])->name('user.bookings.show'); // عرض تفاصيل الحجز
    Route::post('user/bookings/cancel/{booking}', [BookingUserController::class, 'cancel'])->name('user.bookings.cancel'); // إلغاء الحجز
    Route::get('/bookings/{booking}/download', [BookingUserController::class, 'download'])
        ->name('bookings.download');


});
