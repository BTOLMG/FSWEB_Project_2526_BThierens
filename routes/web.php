<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', function () {
    return view('index');
});

Route::get('/search', function (Request $data) {
    return view('search', ['data' => $data->get('data')]);
})->name('search');

