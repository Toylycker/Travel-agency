<?php

use App\Http\Controllers\front\MainFrontController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::post('/places', [MainFrontController::class, 'resultlength'])->name('resultlength')->middleware('track.visits');
Route::post('/contact', [MainFrontController::class, 'storeContact'])->name('storeContact')->middleware('track.visits');

Route::get('/', [MainFrontController::class, 'index'])->name('home')->middleware('track.visits');
// these are what you see on navbar(start)
Route::get('/places', [MainFrontController::class, 'places'])->name('places')->middleware('track.visits');
Route::get('/tours', [MainFrontController::class, 'tours'])->name('tours')->middleware('track.visits');
// Route::get('/blog', [MainFrontController::class, 'blog'])->name('blog');
Route::get('/hotels', [MainFrontController::class, 'hotels'])->name('hotels')->middleware('track.visits');
Route::get('/contact', [MainFrontController::class, 'contact'])->name('contact')->middleware('track.visits');
// these are what you see on navbar(end)

Route::get('/tours/show/{id}', [MainFrontController::class, 'showtour'])->name('tour.show')->middleware('track.visits');
Route::get('/places/show/{id}', [MainFrontController::class, 'showplace'])->name('place.show')->middleware('track.visits');
// Route::get('/blog/show/{id}', [MainFrontController::class, 'showpost'])->name('blog.show');

Route::post('/application/store', [MainFrontController::class, 'storeApplication'])->name('application.store')->middleware('track.visits');
Route::post('/customTour/store', [MainFrontController::class, 'customTour'])->name('customTour.store')->middleware('track.visits');
// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');