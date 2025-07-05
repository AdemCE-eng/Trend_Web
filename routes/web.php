<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

Route::get('/',[TestController::class,'index']);
Route::get('/tweet/view',[TweetController::class,'view']);
Route::get('/login',[LoginController::class,'create']);
Route::get('/register',[RegisterController::class,'create']);