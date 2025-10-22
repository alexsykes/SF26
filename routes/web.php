<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Site Controller
Route::get('/site/detail/{id}', [SiteController::class, 'index'])->name('site.detail');
Route::get('/sites', [SiteController::class, 'sites'])->name('sites');

// Forecast Controller
Route::get('/forecast/{id}', [\App\Http\Controllers\ForecastController::class, 'index'])->name('forecast.index');


require __DIR__ . '/auth.php';
