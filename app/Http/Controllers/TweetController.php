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
            ->whereNull("parent_tweet_id")
            ->with(['user', 'likes', 'retweets', 'baseTweet.user'])
            ->withCount(['likes', 'retweets'])
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
        return view('index', compact('tweets'));
    }

    function view(Tweet $tweet)
    {
        $tweet->load(['user', 'likes', 'retweets', 'replies.user', 'replies.likes', 'replies.retweets', 'baseTweet.user'])
               ->loadCount(['likes', 'retweets']);
        
        return view("tweet.view", compact("tweet"));
    }

    function store(StoreTweetRequest $request)
    {
        $tweet = Auth::user()->tweets()->create($request->validated());
        if ($tweet->baseTweet()->exists()) {
            $tweet->baseTweet()->associate($tweet->parentTweet->baseTweet->getKey())->save();
        } else {
            $tweet->baseTweet()->associate($tweet)->save();
        }
        return redirect()->back();
    }

    /**
     * Retweet a tweet
     */
    public function retweet(Tweet $tweet)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Optional: Prevent self-retweets (remove these lines if you want to allow self-retweets like Twitter)
            // if ($user->getKey() === $tweet->user->getKey()) {
            //     return response()->json(['error' => 'Cannot retweet your own tweet'], 400);
            // }

            // Find the original tweet (in case this is a retweet of a retweet)
            $originalTweet = $tweet->baseTweet ? $tweet->baseTweet : $tweet;
            
            // Check if user already retweeted the ORIGINAL tweet
            $existingRetweet = Tweet::where('user_id', $user->getKey())
                                    ->where('base_tweet_id', $originalTweet->getKey())
                                    ->whereNull('content')
                                    ->first();

            if ($existingRetweet) {
                // Remove retweet
                $existingRetweet->delete();
                $isRetweeted = false;
            } else {
                // Create retweet pointing to the ORIGINAL tweet
                Tweet::create([
                    'user_id' => $user->getKey(),
                    'base_tweet_id' => $originalTweet->getKey(),
                    'content' => null // Null content for pure retweets
                ]);
                $isRetweeted = true;
            }

            // Get updated retweet count from the original tweet
            $retweetsCount = $originalTweet->retweets()->count();

            return response()->json([
                'success' => true,
                'is_retweeted' => $isRetweeted,
                'retweets_count' => $retweetsCount
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
