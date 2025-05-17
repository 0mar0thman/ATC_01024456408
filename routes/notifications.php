<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BookingController;

Route::middleware(['auth', 'user.active'])->group(function () {
    Route::post('/notifications/mark-all-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllAsRead');

    Route::get('/read-notification/{id}', [NotificationController::class, 'read'])->name('read_notification');
    Route::get('/mark-all-as-read', [NotificationController::class, 'markAll'])->name('mark_all_notifications');

    Route::get('/notification/{id}', [BookingController::class, 'show'])->name('booking.details');
});
