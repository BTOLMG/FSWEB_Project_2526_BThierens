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

