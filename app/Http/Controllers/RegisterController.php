<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    function create(){
        return view("register.create");
    }
    function store(RegisterRequest $request){
        $user = User::create($request->validated());
        Auth::login($user, true);
        return redirect()->route('home');
    }
}

