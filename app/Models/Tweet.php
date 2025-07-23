<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tweet extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'content',
        'parent_tweet_id'
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
}
