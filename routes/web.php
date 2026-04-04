<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/search', function (Request $data) {
    return view('search', ['data' => $data->get('data')]);
})->name('search');

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
