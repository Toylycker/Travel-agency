<?php

use App\Http\Controllers\front\MainFrontController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainFrontController::class, 'index'])->name('home');
Route::get('/places', [MainFrontController::class, 'places'])->name('places');
Route::get('/tours', [MainFrontController::class, 'tours'])->name('tours');
Route::get('/blog', [MainFrontController::class, 'blog'])->name('blog');
Route::get('/hotels', [MainFrontController::class, 'hotels'])->name('hotels');
Route::get('/contact', [MainFrontController::class, 'contact'])->name('contact');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
