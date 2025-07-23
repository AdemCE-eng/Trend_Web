<?php

use App\Models\Tweet;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fix-base-tweet', function () {
    $this->info('Starting to fix base_tweet_id for original tweets...');
    
    $tweetsFixed = 0;
    
    foreach(Tweet::whereNull('base_tweet_id')->get() as $tweet) {
        // For original tweets (not retweets), set base_tweet_id to their own id
        $tweet->base_tweet_id = $tweet->id;
        $tweet->save();
        
        $tweetsFixed++;
        $this->line("Fixed tweet ID: {$tweet->id}");
    }
    
    $this->info("Successfully fixed {$tweetsFixed} tweets.");
})->purpose('Fix base_tweet_id for original tweets by setting it to their own ID');
