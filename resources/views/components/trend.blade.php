{{--
/**
 * Tweet Component - Trends Social Media Application
 * 
 * A reusable Blade component that renders individual tweets with full social media functionality.
 * 
 * Features:
 * - Support for original tweets, retweets, and replies
 * - Interactive like, retweet, and share buttons
 * - Nested reply threads with depth control
 * - User avatar and profile linking
 * - Responsive design with hover animations
 * - Time display (relative and absolute)
 * - Visual indicators for retweets and replies
 * 
 * Props:
 * @param Tweet $tweet - The tweet model instance to display
 * @param int $depth - Current nesting depth for replies (default: 0)
 * @param int $maxDepth - Maximum allowed nesting depth (default: 3)
 * 
 * Dependencies:
 * - tweet-interactions.js for client-side functionality
 * - User and Tweet models with proper relationships
 * - Authentication system for interaction permissions
 */
--}}

@props([
    'tweet', 
    'depth' => 0,
    'maxDepth' => 3
])
<div class="group relative transition-all duration-200 hover:scale-[1.01] hover:shadow-lg">
    <div class="card card-border shadow-sm mt-4 bg-base-100 backdrop-blur-sm border border-gray-200/50 rounded-xl overflow-hidden hover:border-primary/30 transition-all duration-300">
        <div class="card-body p-5">
            <div class="flex gap-3">
                <div class="flex-shrink-0">
                    <div class="relative">
                        <div class="size-12 rounded-full ring-2 ring-gray-100 overflow-hidden shadow-sm">
                            @if($tweet->content === null && $tweet->baseTweet)
                                <!-- Show original tweet author's avatar for retweets -->
                                <img src="{{ $tweet->baseTweet->user->avatar_url }}" 
                                     alt="{{ $tweet->baseTweet->user->name }}'s avatar"
                                     class="w-full h-full object-cover transition-transform duration-200 hover:scale-110" />
                            @else
                                <img src="{{ $tweet->user->avatar_url }}" 
                                     alt="{{ $tweet->user->name }}'s avatar"
                                     class="w-full h-full object-cover transition-transform duration-200 hover:scale-110" />
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content area-->
                <div class="flex-1 min-w-0 space-y-3">
                    <!-- User info with timestamp -->
                    <div class="flex items-center justify-between">
                        @if($tweet->content === null && $tweet->baseTweet)
                            <!-- Show original tweet author info for retweets -->
                            <a href="{{ route('profile.show', $tweet->baseTweet->user) }}" class="group/user flex items-center gap-2 hover:underline">
                                <span class="font-semibold text-base-content group-hover/user:text-primary transition-colors">
                                    {{ $tweet->baseTweet->user->name }}
                                </span>
                            </a>
                            <time class="text-xs text-base-content/40 hidden sm:block">
                                {{ $tweet->baseTweet->created_at->diffForHumans() }}
                            </time>
                        @else
                            <!-- Show tweet author info for regular tweets -->
                            <a href="{{ route('profile.show', $tweet->user) }}" class="group/user flex items-center gap-2 hover:underline">
                                <span class="font-semibold text-base-content group-hover/user:text-primary transition-colors">
                                    {{ $tweet->user->name }}
                                </span>
                            </a>
                            <time class="text-xs text-base-content/40 hidden sm:block">
                                {{ $tweet->created_at->diffForHumans() }}
                            </time>
                        @endif
                    </div>
                    
                    <!-- Tweet content-->
                    <div class="block group/content">
                        @if($tweet->content === null && $tweet->baseTweet && $tweet->user->id !== $tweet->baseTweet->user->id)
                            <!-- This is a retweet - show retweeter info and original content -->
                            <div class="mb-2 text-sm text-base-content/60 flex items-center gap-1">
                                <span class="icon-[tabler--repeat] size-4"></span>
                                <span>{{ $tweet->user->name }} retweeted</span>
                            </div>
                            <a href="{{ route('tweet.view', $tweet->baseTweet->getKey()) }}" 
                               class="block group/content">
                                @if($tweet->baseTweet->content)
                                    <p class="text-base-content leading-relaxed break-words overflow-hidden group-hover/content:text-base-content/90 transition-colors">
                                        {{ $tweet->baseTweet->content }}
                                    </p>
                                @endif
                                
                                <!-- Display image for retweeted content -->
                                @if($tweet->baseTweet->image_path)
                                    <div class="mt-3">
                                        <img src="{{ $tweet->baseTweet->image_url }}" 
                                             alt="Tweet image" 
                                             class="max-w-full h-auto rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200" />
                                    </div>
                                @endif
                            </a>
                        @else
                            <!-- Regular tweet or quote tweet -->
                            <a href="{{ route('tweet.view', $tweet->baseTweet ? $tweet->baseTweet->getKey() : $tweet->getKey()) }}" 
                               class="block group/content">
                                @if($tweet->content)
                                    <p class="text-base-content leading-relaxed break-words overflow-hidden group-hover/content:text-base-content/90 transition-colors">
                                        {{ $tweet->content }}
                                    </p>
                                @endif
                                
                                <!-- Display image for regular content -->
                                @if($tweet->image_path)
                                    <div class="mt-3">
                                        <img src="{{ $tweet->image_url }}" 
                                             alt="Tweet image" 
                                             class="max-w-full h-auto rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200" />
                                    </div>
                                @endif
                            </a>
                        @endif
                    </div>
                    
                    <!-- Action buttons-->
                    <div class="flex items-center justify-between pt-3 mt-2">
                        <div class="flex items-center gap-1">
                            @if(request()->route('tweet') && request()->route('tweet')->id == $tweet->id)
                                <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-base-content/40 cursor-not-allowed" 
                                        disabled
                                        title="Currently viewing this tweet">
                                    <span class="icon-[tabler--message-circle] size-4"></span>
                                    <span class="hidden sm:inline">Reply</span>
                                </button>
                            @else
                                <a href="{{ route('tweet.view', $tweet->baseTweet->id) }}" 
                                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-base-content/60 hover:text-primary hover:bg-primary/10 transition-all duration-200"
                                   title="Reply to this tweet">
                                    <span class="icon-[tabler--message-circle] size-4"></span>
                                    <span class="hidden sm:inline">Reply</span>
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center gap-1">
                            <!-- Like button with heart animation -->
                            @php
                                // Check if user liked the ORIGINAL tweet (not this retweet)
                                $originalTweet = $tweet->baseTweet ? $tweet->baseTweet : $tweet;
                                $userLiked = $originalTweet->isLikedBy(auth()->user());
                            @endphp
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200 group/like {{ $userLiked ? 'text-red-500' : 'text-base-content/60 hover:text-red-500' }} hover:bg-red-50"
                                    title="Like this tweet"
                                    onclick="toggleLike({{ $tweet->getKey() }}, this)"
                                    data-liked="{{ $userLiked ? 'true' : 'false' }}">
                                <span class="icon-[tabler--heart{{ $userLiked ? '-filled' : '' }}] size-4 group-hover/like:scale-110 transition-transform"></span>
                                <span class="hidden sm:inline text-xs likes-count">{{ $originalTweet->likes_count }}</span>
                            </button>
                            
                            <!-- Retweet button -->
                            @php
                                // Check if user retweeted the ORIGINAL tweet (not this retweet)
                                $originalTweet = $tweet->baseTweet ? $tweet->baseTweet : $tweet;
                                $userRetweeted = auth()->user() ? 
                                    \App\Models\Tweet::where('user_id', auth()->user()->getKey())
                                        ->where('base_tweet_id', $originalTweet->getKey())
                                        ->whereNull('content')
                                        ->exists() 
                                    : false;
                            @endphp
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-all duration-200 group/retweet {{ $userRetweeted ? 'text-green-500' : 'text-base-content/60 hover:text-green-500' }} hover:bg-green-50"
                                    title="Retweet"
                                    onclick="toggleRetweet({{ $tweet->getKey() }}, this)"
                                    data-retweeted="{{ $userRetweeted ? 'true' : 'false' }}">
                                <span class="icon-[tabler--repeat] size-4 group-hover/retweet:scale-110 transition-transform"></span>
                                <span class="hidden sm:inline text-xs retweets-count">{{ $originalTweet->retweets_count }}</span>
                            </button>
                            
                            <!-- Share button -->
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-base-content/60 hover:text-blue-500 hover:bg-blue-50 transition-all duration-200 group/share"
                                    title="Share this tweet"
                                    data-tweet-url="{{ route('tweet.view', $tweet->baseTweet ? $tweet->baseTweet->getKey() : $tweet->getKey()) }}"
                                    data-tweet-content="{{ $tweet->content === null && $tweet->baseTweet ? $tweet->baseTweet->content : $tweet->content }}"
                                    data-author-name="{{ $tweet->content === null && $tweet->baseTweet ? $tweet->baseTweet->user->name : $tweet->user->name }}"
                                    onclick="shareTweet(this.dataset.tweetUrl, this.dataset.tweetContent, this.dataset.authorName)">
                                <span class="icon-[tabler--share] size-4 group-hover/share:scale-110 transition-transform"></span>
                                <span class="hidden sm:inline text-xs">Share</span>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile timestamp -->
                    <div class="sm:hidden">
                        <time class="text-xs text-base-content/40">
                            @if($tweet->content === null && $tweet->baseTweet)
                                {{ $tweet->baseTweet->created_at->diffForHumans() }}
                            @else
                                {{ $tweet->created_at->diffForHumans() }}
                            @endif
                        </time>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Replies section-->
@if (request()->routeIs('tweet.view'))
    @if($tweet->replies->count() > 0)
        <div class="mt-4 space-y-3">
            @foreach ($tweet->replies as $reply)
                <div class="relative ml-8 pl-4">
                    <!-- Connection line -->
                    <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary/30 to-transparent"></div>
                    <!-- Reply indicator -->
                    <div class="absolute -left-2 top-6 size-4 bg-primary/20 rounded-full border-2 border-white shadow-sm"></div>
                    
                    <x-trend :tweet="$reply" :depth="$depth + 1"></x-trend>
                </div>
            @endforeach
        </div>
    @endif
@endif