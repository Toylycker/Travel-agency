<?php

use App\Http\Controllers\admin\ApplicationController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\HotelController;
use App\Http\Controllers\admin\NoteController;
use App\Http\Controllers\admin\PlaceController;
use App\Http\Controllers\admin\TextController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\ReceivedMessageController;
use App\Http\Controllers\admin\SubjectController;
use App\Http\Controllers\admin\TourController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CustomTourController;
use App\Models\Text;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
// ->middleware(['auth', 'admin'])
->name('admin.')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/download_visitors_log', [DashboardController::class, 'downloadVisitorsLog'])->name('download_visitors_log');
    Route::get('/delete_visitors_log', [DashboardController::class, 'deleteVisitorsLog'])->name('delete_visitors_log');

    Route::put('/tours/{id}/edit/name', [TourController::class, 'putName'])->name('tours.edit.name');
    Route::put('/tours/{id}/edit/name_cn', [TourController::class, 'putName_cn'])->name('tours.edit.name_cn');
    Route::put('/tours/{id}/edit/body', [TourController::class, 'putBody'])->name('tours.edit.body');
    Route::put('/tours/{id}/edit/body_cn', [TourController::class, 'putBody_cn'])->name('tours.edit.body_cn');
    Route::put('/tours/{id}/edit/map', [TourController::class, 'putMap'])->name('tours.edit.map');
    Route::post('/tours/{id}/edit/main_image', [TourController::class, 'putMainImage'])->name('tours.edit.main_image');
    Route::put('/tours/{id}/edit/total_days', [TourController::class, 'putTotalDays'])->name('tours.edit.total_days');
    Route::put('/tours/{id}/edit/tour_prices', [TourController::class, 'putTourPrices'])->name('tours.edit.tour_prices');
    Route::put('/tours/{id}/edit/viewed', [TourController::class, 'putViewed'])->name('tours.edit.viewed');
    Route::put('/tours/{id}/edit/recommended', [TourController::class, 'putRecommended'])->name('tours.edit.recommended');
    Route::post('/tours/{id}/edit/images', [TourController::class, 'putImages'])->name('tours.edit.images');
    Route::put('/tours/{id}/edit/notes', [TourController::class, 'putNotes'])->name('tours.edit.notes');
    Route::put('/tours/{id}/edit/prices', [TourController::class, 'putPrices'])->name('tours.edit.prices');
    Route::put('/tours/{id}/edit/days', [TourController::class, 'putDays'])->name('tours.edit.days');

    Route::delete('/texts/destroy/{text:textable_id}', [TextController::class, 'destroy'])->name('texts.destroy');
    Route::post('/texts/update/{text:textable_id}', [TextController::class, 'update'])->name('texts.update');
    Route::post('/texts/create', [TextController::class, 'store'])->name('texts.store');

    Route::post('/places/update/{place}', [PlaceController::class, 'update'])->name('places.update.this');
    Route::resources([
    'places'=> PlaceController::class,
    'tours'=> TourController::class,
    'posts'=> PostController::class,
    'hotels'=> HotelController::class,
    'users'=> UserController::class]);
    Route::get('/applications/index', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/customTour/index', [CustomTourController::class, 'index'])->name('customTour.index');
    Route::get('/messages/index', [ReceivedMessageController::class, 'index'])->name('messages.index');

    Route::get('/subjects/index', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('/subjects/store', [SubjectController::class, 'store'])->name('subjects.store');
    Route::put('/subjects/update/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/destroy/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

    Route::get('/categories/index', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/destroy/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/notes/index', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes/store', [NoteController::class, 'store'])->name('notes.store');
    Route::put('/notes/update/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/destroy/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
});