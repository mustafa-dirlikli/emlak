<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\PropertyListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PropertyListingController::class, 'home'])->name('home');

Route::get('/satilik', [PropertyListingController::class, 'buy'])->name('buy');
Route::get('/kiralik', [PropertyListingController::class, 'rent'])->name('rent');

Route::get('/ilanlar', [PropertyListingController::class, 'index'])->name('properties');
Route::get('/ilan/{property}', [PropertyListingController::class, 'show'])->name('properties.show');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/hakkimizda', function () {
    return view('about');
})->name('about');

Route::get('/iletisim', function () {
    return view('contact');
})->name('contact');

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/giris', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('/giris', [AuthController::class, 'login'])->name('login.post');
    Route::post('/cikis', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/api/cities', [\App\Http\Controllers\Admin\LocationApiController::class, 'cities'])->name('api.cities');
        Route::get('/api/districts', [\App\Http\Controllers\Admin\LocationApiController::class, 'districts'])->name('api.districts');
        Route::get('/api/neighborhoods', [\App\Http\Controllers\Admin\LocationApiController::class, 'neighborhoods'])->name('api.neighborhoods');
        Route::resource('properties', PropertyController::class)->except(['show']);
    });
});
