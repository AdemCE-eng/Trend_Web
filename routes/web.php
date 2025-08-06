<?php

/**
 * Web Routes for Trends Social Media Application
 * 
 * This file defines all HTTP routes for the web interface including:
 * - Public routes (home, tweet view, auth pages)
 * - Protected routes (tweet creation, profile management, social interactions)
 * - Rate limiting for API-like endpoints
 * 
 * Route Organization:
 * - Guest routes: Authentication pages
 * - Public routes: Home timeline, individual tweet view
 * - Authenticated routes: Tweet CRUD, social features, profile management
 */

use App\Http\Controllers\FollowController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
| These routes are accessible to all users, including guests
*/

// Home timeline - shows all tweets
Route::get('/', [TweetController::class, 'index'])
    ->name('home');

// Individual tweet view with replies
Route::get('/tweet/{tweet}', [TweetController::class, 'view'])
    ->name('tweet.view');

/*
|--------------------------------------------------------------------------
| Authenticated Routes with Rate Limiting
|--------------------------------------------------------------------------
| These routes require user authentication and have rate limiting applied
*/

Route::middleware(['auth', 'throttle:30,1'])->group(function () {
    Route::post('/tweet/create', [TweetController::class, 'store'])
        ->name('tweet.create');

    Route::post('/tweet/{tweet}/like', [LikeController::class, 'toggle'])
        ->name('tweet.like');

    Route::post('/tweet/{tweet}/retweet', [TweetController::class, 'retweet'])
        ->name('tweet.retweet');

    Route::post('/user/{user}/follow', [FollowController::class, 'toggle'])
        ->name('user.follow');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return redirect()->route('profile.show', auth()->user());
    })->name('profile');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/edit', 'edit')
            ->name('profile.edit');

        Route::patch('/profile',  'update')
            ->name('profile.update');

        Route::patch('/profile/password', 'updatePassword')
            ->name('profile.password.update');
    });
});

Route::get('/profile/{user}', [ProfileController::class, 'show'])
    ->name('profile.show');

Route::get('/register', [RegisterController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/privacy-terms', function () {
    return view('legal.privacy_terms');
})->name('privacy.terms');

Route::get('/login', [LoginController::class, 'create'])
    ->name('login');
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('login.store');

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('throttle:3,1');

Route::post('/logout', LogoutController::class)
    ->name('logout');
