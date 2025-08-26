<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Front
use App\Http\Controllers\Front\SeriesController as FrontSeries;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

// Admin
use App\Http\Controllers\Admin\SeriesController as AdminSeries;
use App\Http\Controllers\Admin\EpisodeController as AdminEpisode;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Front pages
Route::get('/', [FrontSeries::class, 'index'])->name('front.series.index');
Route::get('/series/{series}', [FrontSeries::class, 'show'])->name('front.series.show');

Route::middleware('auth')->group(function () {

    // Favorites
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{series}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'readOne'])->name('notifications.readOne'); // ← أضف هذا

    // Admin-only: Series & Categories
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('series', AdminSeries::class);
        Route::resource('categories', AdminCategory::class)->except(['show']);
    });

    // Admin + Employee: Episodes
    Route::middleware('role:admin,employee')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('episodes', AdminEpisode::class)->except(['show']);
    });

    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
