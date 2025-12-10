<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsEditor;
use App\Http\Middleware\IsSuperUser;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/credits', [HomeController::class, 'credits'])->name('credits');
Route:: get('locate', [ForecastController::class, 'locate'])->middleware(['auth', 'verified'])->name('locate');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Site Controller
Route::get('/site/detail/{id}', [SiteController::class, 'index'])->name('site.detail');
Route::get('/sites', [SiteController::class, 'sites'])->name('sites');
Route::get('/sites_near', [SiteController::class, 'sites_near'])->name('near.sites');
Route::get('/site/edit/{id}', [AdminController::class, 'editSite'])->middleware([IsEditor::class]);
Route::get('/site/update_request/{id}/', [SiteController::class, 'update_request'])->middleware(['auth', 'verified'])->name('site.update_request');

Route::get('/site/add', [SiteController::class, 'addSite'])->middleware([IsEditor::class])->name('site.add');
Route::post('/site/add', [SiteController::class, 'storeSite'])->middleware([IsEditor::class])->name('site.store');

Route::patch('/site/update', [SiteController::class, 'update'])->middleware(['auth', 'verified'])->name('site.update');

// Forecast Controller
Route::get('/forecast/{id}', [ForecastController::class, 'index'])->name('forecast.index');

// User Controller
Route::get('/user/favourites', [UserController::class, 'favourites'])->middleware(['auth', 'verified'])->name('favourites');
Route::get('/addFavourite/{id}', [UserController::class, 'addFavourite'])->middleware(['auth', 'verified'])->name('addFavourite');
Route::get('/removeFavourite/{id}', [UserController::class, 'removeFavourite'])->middleware(['auth', 'verified'])->name('removeFavourite');
Route::post('/site_user_update', [SiteController::class, 'site_user_update'])->middleware(['auth', 'verified'])->name('site.user.update');

// AdminController
Route::get('/suggestions', [AdminController::class, 'suggestions'])->middleware([IsSuperUser::class])->name('suggestions');
Route::get('sites_approve', [AdminController::class, 'sitesToApprove'])->middleware([IsSuperUser::class])->name('sites.approve');

// LocateController
Route::get('/nearest', [SiteController::class, 'nearest'])->middleware(['auth', 'verified'])->name('nearest');
require __DIR__ . '/auth.php';
