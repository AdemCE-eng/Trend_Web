<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTweetRequest;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    function index()
    {
        $tweets = Tweet::all();
        return view('index', compact('tweets'));
    }

    function view()
    {
        return view("/tweet/view");
    }

    function store(StoreTweetRequest $request)
    {
        Auth::user()->tweets()->create($request->validated());
        return redirect()->back();
    }
}
