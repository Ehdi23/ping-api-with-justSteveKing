<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Services;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\CacheResponse;

Route::post('/', Services\StoreController::class)->name('store');

Route::middleware([CacheResponse::class])->group(static function (): void {
    Route::get('/', Services\IndexController::class)->name('index');
    Route::get('{ulid}', Services\ShowController::class)->name('show');
});

Route::put('{services}', Services\UpdateController::class)->name('update');
Route::delete('{services}', Services\DeleteController::class)->name('delete');