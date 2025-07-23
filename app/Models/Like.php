<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Like Model for Trends Social Media Application
 * 
 * Represents a like relationship between a user and a tweet.
 * Uses a pivot table to track social engagement interactions.
 * 
 * Features:
 * - Prevents duplicate likes (enforced by unique constraint)
 * - Tracks like timestamps for analytics
 * - Supports unlike functionality via model deletion
 * 
 * @property int $id
 * @property int $user_id ID of the user who liked
 * @property int $tweet_id ID of the liked tweet
 * @property \Carbon\Carbon $created_at When the like was created
 * @property \Carbon\Carbon $updated_at When the like was last updated
 */
class Like extends Model
{
    protected $fillable = [
        'user_id',
        'tweet_id'
    ];

    /**
     * Get the user that owns the like.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tweet that was liked.
     */
    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
}
