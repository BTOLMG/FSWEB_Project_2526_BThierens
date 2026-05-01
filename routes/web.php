<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KaartController;

Route::get('/', function () {
    return view('index');
})->name('index');


Route::get('/api/keywords', [SearchController::class, 'keywords'])->name('keywords');
Route::get('/api/actoren', [SearchController::class, 'getActorsByIds'])->name('getActorsByIds');


Route::get('/search', [SearchController::class, 'index'])->name('search');


Route::get('/api/getAllActoren', [KaartController::class, 'getActoren'])->name('getAllActoren');

Route::get('/kaart', function () {
    return view('kaart');
})->name('kaart');

Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');


Route::get('/details/{id}', [SearchController::class, 'getAll'])->name('details');


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
