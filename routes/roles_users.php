<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'user.active'])->prefix('roles')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', AdminController::class);
});
 
