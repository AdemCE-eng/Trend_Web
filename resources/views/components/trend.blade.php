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
                            <img src="{{ $tweet->user->avatar_url }}" 
                                 alt="{{ $tweet->user->name }}'s avatar"
                                 class="w-full h-full object-cover transition-transform duration-200 hover:scale-110" />
                        </div>
                    </div>
                </div>

                <!-- Content area-->
                <div class="flex-1 min-w-0 space-y-3">
                    <!-- User info with timestamp -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('profile.show', $tweet->user) }}" class="group/user flex items-center gap-2 hover:underline">
                            <span class="font-semibold text-base-content group-hover/user:text-primary transition-colors">
                                {{ $tweet->user->name }}
                            </span>
                        </a>
                        <time class="text-xs text-base-content/40 hidden sm:block">
                            {{ $tweet->created_at->diffForHumans() }}
                        </time>
                    </div>
                    
                    <!-- Tweet content-->
                    <a href="{{ route('tweet.view',$tweet->baseTweet->id) }}" 
                       class="block group/content">
                        <p class="text-base-content leading-relaxed break-words overflow-hidden group-hover/content:text-base-content/90 transition-colors">
                            {{ $tweet->content }}
                        </p>
                    </a>
                    
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
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-base-content/60 hover:text-red-500 hover:bg-red-50 transition-all duration-200 group/like"
                                    title="Like this tweet">
                                <span class="icon-[tabler--heart] size-4 group-hover/like:scale-110 transition-transform"></span>
                                <span class="hidden sm:inline text-xs">24</span>
                            </button>
                            
                            <!-- Retweet button -->
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-base-content/60 hover:text-green-500 hover:bg-green-50 transition-all duration-200 group/retweet"
                                    title="Retweet">
                                <span class="icon-[tabler--repeat] size-4 group-hover/retweet:scale-110 transition-transform"></span>
                                <span class="hidden sm:inline text-xs">12</span>
                            </button>
                            
                            <!-- Share button -->
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-base-content/60 hover:text-blue-500 hover:bg-blue-50 transition-all duration-200 group/share"
                                    title="Share this tweet"
                                    onclick="shareTweet('{{ route('tweet.view', $tweet->baseTweet ? $tweet->baseTweet->id : $tweet->id) }}', '{{ addslashes($tweet->content) }}', '{{ addslashes($tweet->user->name) }}')">
                                <span class="icon-[tabler--share] size-4 group-hover/share:scale-110 transition-transform"></span>
                                <span class="hidden sm:inline text-xs">Share</span>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile timestamp -->
                    <div class="sm:hidden">
                        <time class="text-xs text-base-content/40">
                            {{ $tweet->created_at->diffForHumans() }}
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