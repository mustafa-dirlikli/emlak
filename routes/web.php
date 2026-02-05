<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/satilik', function () {
    return view('buy');
})->name('buy');

Route::get('/kiralik', function () {
    return view('rent');
})->name('rent');

Route::get('/ilanlar', function () {
    return view('properties');
})->name('properties');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/hakkimizda', function () {
    return view('about');
})->name('about');

Route::get('/iletisim', function () {
    return view('contact');
})->name('contact');
