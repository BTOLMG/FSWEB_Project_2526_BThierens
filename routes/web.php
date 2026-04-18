<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('index');
})->name('index');


// Route::get('/api/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
Route::get('/api/keywords', [SearchController::class, 'keywords'])->name('keywords');

Route::get('/search', [SearchController::class, 'index'])->name('search');


Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/info_privacy#cookies', function () {
    return view('info_privacy');
})->name('cookies');

Route::get('/info_privacy#toegankelijkheid', function () {
    return view('info_privacy');
})->name('toegankelijkheid');

Route::get('/info_privacy#privacy', function () {
    return view('info_privacy');
})->name('privacy');

Route::get('/info_privacy', function () {
    return view('info_privacy');
})->name('info_privacy');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
