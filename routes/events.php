<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::middleware(['auth', 'user.active'])->prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::get('/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/', [EventController::class, 'store'])->name('events.store');
    Route::get('/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/upcoming/list', [EventController::class, 'upcoming'])->name('events.upcoming');
    Route::get('/past/list', [EventController::class, 'past'])->name('events.past');
    Route::get('/featured/list', [EventController::class, 'featured'])->name('events.featured');
    Route::get('/{event}/print', [EventController::class, 'print'])->name('events.print');
    Route::get('/export/excel', [EventController::class, 'export'])->name('events.export');
    Route::get('/events', [EventController::class, 'sortDate'])->name('sortDate');
});
