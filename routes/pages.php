<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'user.active'])->get('/{page}', [AdminController::class, 'index'])->where('page', '.*');
