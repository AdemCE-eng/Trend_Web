<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TweetController::class, 'index'])
    ->name('home');

Route::get('/tweet/{tweet}', [TweetController::class, 'view'])
    ->name('tweet.view');

// Tweet interactions (require authentication)
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

// Profile routes - Auth routes must come before the dynamic route
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return redirect()->route('profile.show', auth()->user());
    })->name('profile');
    
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});

// This dynamic route must come after the specific routes above
Route::get('/profile/{user}', [ProfileController::class, 'show'])
    ->name('profile.show');

Route::get('/register', [RegisterController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'create'])
    ->name('login');
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('login.store');

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('throttle:3,1');

Route::post('/logout', LogoutController::class)
    ->name('logout');
