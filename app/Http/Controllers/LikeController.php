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

        $like = Like::where('user_id', $user->getKey())
                   ->where('tweet_id', $tweet->id)
                   ->first();

        if ($like) {
            // Unlike the tweet
            $like->delete();
            $isLiked = false;
        } else {
            // Like the tweet
            Like::create([
                'user_id' => $user->getKey(),
                'tweet_id' => $tweet->id
            ]);
            $isLiked = true;
        }

        // Get updated like count
        $likesCount = $tweet->likes()->count();

        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $likesCount
        ]);
    }
}
