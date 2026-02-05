<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\PropertyListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PropertyListingController::class, 'home'])->name('home');

Route::get('/satilik', function () {
    return view('buy');
})->name('buy');

Route::get('/kiralik', function () {
    return view('rent');
})->name('rent');

Route::get('/ilanlar', [PropertyListingController::class, 'index'])->name('properties');

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
        Route::resource('properties', PropertyController::class)->except(['show']);
    });
});
