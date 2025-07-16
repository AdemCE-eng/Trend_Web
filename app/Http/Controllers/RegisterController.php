<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    function create(){
        return view("register.create");
    }
    function store(RegisterRequest $request){
        return $request->validated();
    }
}

