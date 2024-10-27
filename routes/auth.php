<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;


Route::post('/', [AuthenticatedSessionController::class, 'store'])->name('store');