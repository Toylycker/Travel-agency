<?php

use App\Http\Controllers\front\MainFrontController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [MainFrontController::class, 'index'])->name('home');
// these are what you see on navbar(start)
Route::get('/places', [MainFrontController::class, 'places'])->name('places');
Route::get('/tours', [MainFrontController::class, 'tours'])->name('tours');
Route::get('/blog', [MainFrontController::class, 'blog'])->name('blog');
Route::get('/hotels', [MainFrontController::class, 'hotels'])->name('hotels');
Route::get('/contact', [MainFrontController::class, 'contact'])->name('contact');
// these are what you see on navbar(end)

Route::get('/tours/show/{id}', [MainFrontController::class, 'showtour'])->name('tour.show');
Route::get('/places/show/{id}', [MainFrontController::class, 'showplace'])->name('place.show');



Route::get('/places/resultlength', [MainFrontController::class, 'resultlength'])->name('resultlength');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');