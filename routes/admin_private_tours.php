<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PrivateTourController;

Route::middleware(['auth:sanctum', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('private_tours', PrivateTourController::class)->only(['create', 'store']);
    }); 