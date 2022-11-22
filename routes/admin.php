<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\HotelController;
use App\Http\Controllers\admin\PlaceController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\TourController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resources(['places'=> PlaceController::class,
    'tours'=> TourController::class,
    'posts'=> PostController::class,
    'hotels'=> HotelController::class,
    'users'=> UserController::class]);
});