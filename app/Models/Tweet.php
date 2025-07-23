<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Tweet Model for Trends Social Media Application
 * 
 * Represents a tweet/post in the social media platform with support for:
 * - Original tweets with text content
 * - Retweets (sharing other users' tweets)
 * - Reply threads (parent-child tweet relationships)
 * - Social interactions (likes)
 * - Soft deletes for content moderation
 * 
 * @property int $id
 * @property string|null $content Tweet text content (null for pure retweets)
 * @property int|null $parent_tweet_id ID of the tweet being replied to
 * @property int|null $base_tweet_id ID of the original tweet (for retweets)
 * @property int $user_id ID of the user who created this tweet
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class Tweet extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'content',
        'parent_tweet_id',
        'base_tweet_id',
        'user_id'
    ];
    
    /**
     * Get the user that owns the tweet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the base tweet that this tweet is retweeting.
     */
    public function baseTweet()
    {
        return $this->belongsTo(Tweet::class, 'base_tweet_id');
    }
    
    /**
     * Get all retweets of this tweet.
     */
    public function retweets()
    {
        return $this->hasMany(Tweet::class, 'base_tweet_id');
    }
    
    /**
     * Get the parent tweet that this tweet is replying to.
     */
    public function parentTweet()
    {
        return $this->belongsTo(Tweet::class, 'parent_tweet_id');
    }
    
    /**
     * Get all replies to this tweet.
     */
    public function replies()
    {
        return $this->hasMany(Tweet::class, 'parent_tweet_id');
    }

    /**
     * Get all likes for this tweet.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get users who liked this tweet.
     */
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    /**
     * Check if the tweet is liked by a specific user.
     */
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the like count for this tweet.
     */
    public function getLikesCountAttribute()
    {
        // Use the loaded count if available, otherwise count directly
        if (array_key_exists('likes_count', $this->attributes)) {
            return $this->attributes['likes_count'];
        }
        return $this->likes()->count();
    }

    /**
     * Get the retweet count for this tweet.
     */
    public function getRetweetsCountAttribute()
    {
        // Use the loaded count if available, otherwise count directly
        if (array_key_exists('retweets_count', $this->attributes)) {
            return $this->attributes['retweets_count'];
        }
        return $this->retweets()->count();
    }
}
