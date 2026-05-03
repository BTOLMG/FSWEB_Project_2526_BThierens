<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KaartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActorBeheerController;
use App\Http\Controllers\ContactController;


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
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/login', function () { return view('login'); })->name('login');

Route::post('/login-user', [UserController::class, "login"])->name('login.post');
Route::post('/logout', [UserController::class, "logout"])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/create-actor', [AdminController::class, 'store'])->name('admin.create_actor');

    Route::get('/admin/overzicht', [AdminController::class, 'overzicht'])->name('admin.overzicht');

    Route::delete('/admin/actor/{actor}', [AdminController::class, 'destroyActor'])->name('admin.actor.destroy');
    Route::delete('/admin/user/{user}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');


    Route::get('/account', [ActorBeheerController::class, 'index'])->name('account.index');

    Route::get('/account/{actor}/edit', [ActorBeheerController::class, 'edit'])->name('account.edit');

    Route::post('/account/{actor}/update', [ActorBeheerController::class, 'update'])->name('account.update');

    Route::post('/account/create-actor', [ActorBeheerController::class, 'store'])->name('account.create_actor');
    Route::delete('/account/actor/{actor}', [ActorBeheerController::class, 'destroy'])->name('account.actor.destroy');
});
