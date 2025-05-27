<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PrivateTourController;

Route::middleware(['auth:sanctum', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('private_tours', PrivateTourController::class)->only(['create', 'store']);
        Route::get('private_tours/{tour}/edit', [PrivateTourController::class, 'edit'])->name('private_tours.edit');
        // Placeholder for update route, will be GET for now, change to PUT/PATCH later
        // Route::put('private_tours/{tour}', [PrivateTourController::class, 'update'])->name('private_tours.update'); 
    }); 