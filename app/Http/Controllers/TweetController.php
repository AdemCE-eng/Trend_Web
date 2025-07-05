<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TweetController extends Controller
{
    function view(){
        return view("/tweet/view");
    }
}
