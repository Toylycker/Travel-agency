<?php

use App\Http\Controllers\front\MainFrontController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::post('/places', [MainFrontController::class, 'resultlength'])->name('resultlength')->middleware('track.visits');
Route::post('/contact', [MainFrontController::class, 'storeContact'])->name('storeContact')->middleware('track.visits');
Route::get('/', [MainFrontController::class, 'index'])->name('home')->middleware('track.visits');
Route::get('/places', [MainFrontController::class, 'places'])->name('places')->middleware('track.visits');
Route::get('/tours', [MainFrontController::class, 'tours'])->name('tours')->middleware('track.visits');
Route::get('/hotels', [MainFrontController::class, 'hotels'])->name('hotels')->middleware('track.visits');
Route::get('/contact', [MainFrontController::class, 'contact'])->name('contact')->middleware('track.visits');
Route::get('/tours/show/{id}', [MainFrontController::class, 'showtour'])->name('tour.show')->middleware('track.visits');
Route::get('/places/show/{id}', [MainFrontController::class, 'showplace'])->name('place.show')->middleware('track.visits');
Route::post('/application/store', [MainFrontController::class, 'storeApplication'])->name('application.store')->middleware('track.visits');
Route::post('/custom-tour/store', [MainFrontController::class, 'customTour'])->name('customTour.store')->middleware('track.visits');
Route::post('/welcome-page-request', [MainFrontController::class, 'submitWelcomePageRequest'])->name('welcomePageRequest');