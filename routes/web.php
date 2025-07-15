<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])
    ->name('home');

Route::get('/tweet/view', [TweetController::class, 'view'])
    ->name('tweet.view');

Route::get('/login', [LoginController::class, 'create'])
    ->name('login');

Route::get('/register', [RegisterController::class, 'create'])
    ->name('register');