<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTweetRequest;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Tweet Controller - Handles Tweet CRUD Operations
 * 
 * Manages all tweet-related functionality for the Trends social media platform:
 * - Display public timeline with recent tweets
 * - Show individual tweets with reply threads
 * - Create new tweets and replies
 * - Handle retweets and quote tweets
 * 
 * Features:
 * - Optimized database queries with eager loading
 * - Real-time like and retweet counts
 * - Nested reply support with proper threading
 * - Rate limiting for tweet creation
 * - Authentication-aware content display
 */
class TweetController extends Controller
{
    /**
     * Display the public timeline with latest tweets
     * 
     * Shows only top-level tweets (no replies) with their engagement metrics.
     * Includes support for retweets by loading the original tweet data.
     * 
     * @return \Illuminate\View\View
     */
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

    /**
     * Display a specific tweet with its reply thread
     * 
     * Shows the tweet details along with all nested replies.
     * Loads all necessary relationships for full thread display.
     * 
     * @param Tweet $tweet The tweet to display
     * @return \Illuminate\View\View
     */
    function view(Tweet $tweet)
    {
        $tweet->load(['user', 'likes', 'retweets', 'replies.user', 'replies.likes', 'replies.retweets', 'baseTweet.user'])
               ->loadCount(['likes', 'retweets']);
        
        return view("tweet.view", compact("tweet"));
    }

    function store(StoreTweetRequest $request)
    {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('tweets', $imageName, 'public');
            $data['image_path'] = $imagePath;
        }
        
        $tweet = Auth::user()->tweets()->create($data);
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
