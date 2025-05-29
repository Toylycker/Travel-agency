<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PrivateTourController;

Route::middleware(['auth:sanctum', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('private_tours/create', [PrivateTourController::class, 'create'])->name('private_tours.create');
        Route::post('private_tours', [PrivateTourController::class, 'store'])->name('private_tours.store');
        Route::get('private_tours/{tour}/edit', [PrivateTourController::class, 'edit'])->name('private_tours.edit');
        Route::resource('private_tours', PrivateTourController::class)->only(['update']);
        Route::post('private_tours/{tour}/update', [PrivateTourController::class, 'update'])->name('private_tours.update');
    }); 