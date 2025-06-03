<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessagesController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::controller(LoginController::class)->group(function () {

        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');

    });

    Route::controller(RegisterController::class)->group(function () {

        Route::get('register', 'create')->name('register');
        Route::post('register', 'store');

    });

});
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', HomeController::class)->name('home');

    Route::controller(MessagesController::class)->group(function () {

        Route::get('messages', 'show')->name('messages.show');

    });

    Route::controller(ProfileController::class)->group(function () {

        Route::get('{user:username}', 'index')->name('profile.index');
        Route::get('{user:username}/media', 'media')->name('profile.media');

    });

});


