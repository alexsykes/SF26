<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route:: get('locate', [ForecastController::class, 'locate'])->middleware(['auth', 'verified'])->name('locate');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Site Controller
Route::get('/site/detail/{id}', [SiteController::class, 'index'])->name('site.detail');
Route::get('/sites', [SiteController::class, 'sites'])->name('sites');
Route::get('/site/edit/{id}', [AdminController::class, 'editSite'])->middleware(['auth', 'verified']);
Route::get('site/update_request/{id}/', [SiteController::class, 'update_request'])->middleware(['auth', 'verified'])->name('site.update_request');

Route::patch('site/update', [SiteController::class, 'update'])->middleware(['auth', 'verified'])->name('site.update');

// Forecast Controller
Route::get('/forecast/{id}', [ForecastController::class, 'index'])->name('forecast.index');

// User Controller
Route::get('/user/favourites', [UserController::class, 'favourites'])->middleware(['auth', 'verified'])->name('favourites');
Route::get('/addFavourite/{id}', [UserController::class, 'addFavourite'])->middleware(['auth', 'verified'])->name('addFavourite');
Route::get('/removeFavourite/{id}', [UserController::class, 'removeFavourite'])->middleware(['auth', 'verified'])->name('removeFavourite');
Route::post('/site_user_update', [SiteController::class, 'site_user_update'])->middleware(['auth', 'verified'])->name('site.user.update');

// AdminController
Route::get('suggestions', [AdminController::class, 'suggestions'])->middleware(['auth', 'verified'])->name('suggestions');


// LocateController
Route::get('nearest', [HomeController::class, 'nearest'])->middleware(['auth', 'verified'])->name('nearest');
require __DIR__ . '/auth.php';
