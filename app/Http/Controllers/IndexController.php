<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    function index()
    {
        return view('index');
    }
}
