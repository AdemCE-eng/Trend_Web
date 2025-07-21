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
        $tweets = Tweet::query()
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
        return view('index', compact('tweets'));
    }

    function view(Tweet $tweet)
    {
        return view("tweet.view", compact("tweet"));
    }

    function store(StoreTweetRequest $request)
    {
        Auth::user()->tweets()->create($request->validated());
        return redirect()->back();
    }
}
