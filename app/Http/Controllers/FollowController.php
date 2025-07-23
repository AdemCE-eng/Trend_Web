<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    /**
     * Toggle follow on a user
     */
    public function toggle(User $user)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($currentUser->getKey() === $user->getKey()) {
            return response()->json(['error' => 'Cannot follow yourself'], 400);
        }

        $isFollowing = $currentUser->isFollowing($user);

        if ($isFollowing) {
            // Unfollow the user
            DB::table('follows')
                ->where('follower_id', $currentUser->getKey())
                ->where('followee_id', $user->getKey())
                ->delete();
            $isFollowing = false;
        } else {
            // Follow the user
            DB::table('follows')->insert([
                'follower_id' => $currentUser->getKey(),
                'followee_id' => $user->getKey(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $isFollowing = true;
        }

        // Get updated follower count
        $followersCount = $user->followers()->count();

        return response()->json([
            'success' => true,
            'is_following' => $isFollowing,
            'followers_count' => $followersCount
        ]);
    }
}
