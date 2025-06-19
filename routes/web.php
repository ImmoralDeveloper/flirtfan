<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowingUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;




Route::controller(SearchController::class)->group(function () {
    Route::get('search', 'index')->name('search.index');
});

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

    Route::controller(VideoController::class)->group(function () {

        Route::get('/videos', 'index')->name('videos.index');

    });
    Route::controller(FollowingUserController::class)->group(function () {

        Route::get('/following', 'index')->name('following.index');

    });

    Route::controller(FavoriteController::class)->group(function () {

        Route::get('/favorites', 'index')->name('favorites.index');

    });

    Route::controller(MessagesController::class)->group(function () {

        Route::get('messages', 'index')->name('messages.index');

    });

    Route::controller(ProfileController::class)->group(function () {

        Route::get('{user:username}', 'index')->name('profile.index');
        Route::get('{user:username}/media', 'media')->name('profile.media');

    });

});
