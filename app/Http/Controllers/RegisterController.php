<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    function create(){
        return view("register.create");
    }
    function store(){
        return "saved successfully!";
    }
}

