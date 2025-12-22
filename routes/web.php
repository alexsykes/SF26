<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubmailController;
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
Route:: get('/locate', [ForecastController::class, 'locate'])->middleware(['auth', 'verified'])->name('locate');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Site Controller
Route::get('/sites', [SiteController::class, 'index'])->middleware([IsSuperUser::class])->name('sites');
Route::get('/site/detail/{id}', [SiteController::class, 'detail'])->middleware('auth', 'verified')->name('site.detail');
Route::get('/sitelist', [SiteController::class, 'siteList'])->middleware(['auth', 'verified'])->name('sitelist');
Route::get('/sites_near', [SiteController::class, 'sites_near'])->middleware(['auth', 'verified'])->name('near.sites');
Route::get('/site/edit/{id}', [AdminController::class, 'editSite'])->middleware([IsEditor::class]);
Route::get('/site/update_request/{id}/', [SiteController::class, 'update_request'])->middleware(['auth', 'verified'])->name('site.update_request');
Route::put('/sites/direction', [SiteController::class, 'direction'])->middleware(['auth', 'verified'])->name('site.direction');

Route::get('/site/add', [SiteController::class, 'addSite'])->middleware([IsEditor::class])->name('site.add');
Route::post('/site/add', [SiteController::class, 'storeSite'])->middleware([IsEditor::class])->name('site.store');
Route::patch('/site/publish', [SiteController::class, 'publishSite'])->middleware([IsEditor::class])->name('site.publish');

Route::patch('/site/update', [SiteController::class, 'update'])->middleware(['auth', 'verified'])->name('site.update');

Route::get('/sitemap', [SiteController::class, 'sitemap'])->middleware(['auth', 'verified'])->name('sitemap');
Route::put('/sitemap', [SiteController::class, 'sitemap'])->middleware(['auth', 'verified'])->name('sitemap_with_direction');

// Forecast Controller
Route::get('/forecast/{id}', [ForecastController::class, 'index'])->middleware(['auth', 'verified'])->name('forecast.index');

// User Controller

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/user/favourites', [UserController::class, 'favourites'])->middleware(['auth', 'verified'])->name('favourites');
Route::get('/addFavourite/{id}', [UserController::class, 'addFavourite'])->middleware(['auth', 'verified'])->name('addFavourite');
Route::get('/removeFavourite/{id}', [UserController::class, 'removeFavourite'])->middleware(['auth', 'verified'])->name('removeFavourite');
Route::post('/site_user_update', [SiteController::class, 'site_user_update'])->middleware(['auth', 'verified'])->name('site.user.update');


// AdminController
Route::get('/admin', [AdminController::class, 'index'])->middleware(IsSuperUser::class)->name('admin.index');
Route::get('/suggestions', [AdminController::class, 'suggestions'])->middleware([IsSuperUser::class])->name('suggestions');
Route::get('/sites_approve', [AdminController::class, 'sitesToApprove'])->middleware([IsSuperUser::class])->name('sites.approve');

Route::get('/contact', [AdminController::class, 'contact'])->name('contact');
Route::post('/contact', [AdminController::class, 'sendMail'])->name('sendMail');

// LocateController
Route::get('/nearest', [SiteController::class, 'nearest'])->middleware(['auth', 'verified'])->name('nearest');
require __DIR__ . '/auth.php';
Route::put('/nearest', [SiteController::class, 'nearest'])->middleware(['auth', 'verified'])->name('nearest_with_direction');
require __DIR__ . '/auth.php';


// ProfileController
Route::patch('/profile/unsubscribe', [ProfileController::class, 'unsubscribe'])->middleware('auth', 'verified')->name('profile.unsubscribe');

// ClubmailController
Route::get('/mails', [ClubmailController::class, 'index'])->name('mails');
Route::get('/mail/compose', [ClubmailController::class, 'compose'])->name('compose');
Route::post('/mail/store', [ClubmailController::class, 'store'])->name('storeMail');
Route::get('/mail/edit/{id}', [ClubmailController::class, 'edit'])->name('editMail');
Route::patch('/mail/update', [ClubmailController::class, 'update'])->name('updateMail');
Route::post('/clubmails/post', [ClubmailController::class, 'sendMail'])->name('sendClubMail');

// ClubController
Route::get('/clubs', [ClubController::class, 'index'])->name('clubs');