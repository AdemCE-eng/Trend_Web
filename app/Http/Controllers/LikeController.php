<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like on a tweet
     */
    public function toggle(Tweet $tweet)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Find the original tweet (in case this is a retweet)
        $originalTweet = $tweet->baseTweet ? $tweet->baseTweet : $tweet;

        $like = Like::where('user_id', $user->getKey())
                   ->where('tweet_id', $originalTweet->id)
                   ->first();

        if ($like) {
            // Unlike the original tweet
            $like->delete();
            $isLiked = false;
        } else {
            // Like the original tweet
            Like::create([
                'user_id' => $user->getKey(),
                'tweet_id' => $originalTweet->id
            ]);
            $isLiked = true;
        }

        // Get updated like count from the original tweet
        $likesCount = $originalTweet->likes()->count();

        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $likesCount
        ]);
    }
}
