<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowingUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';


Route::controller(SearchController::class)->group(function () {
    Route::get('search', 'index')->name('search.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::controller(VideoController::class)->group(function () {

        Route::get('/videos', 'index')->name('videos.index');
        Route::post('/videos/toLoad', 'loadVideos')->name('videos.load');

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
    Route::controller(MediaController::class)->group(function () {

        Route::post('{user:username}/media', 'load')->name('media.profile.load');

    });
    Route::controller(PostController::class)->group(function () {

        Route::post('posts/load', 'load')->name('posts.load');

    });

});

