<x-layouts.app>
    <!-- Preload critical images to prevent flickering -->
    @if($user->banner)
        <link rel="preload" as="image" href="{{ $user->banner_url }}">
    @endif
    @if($user->avatar)
        <link rel="preload" as="image" href="{{ $user->avatar_url }}">
    @endif
    
    <div class="min-h-screen bg-base-200/30">
        <!-- Profile Header -->
        <div class="relative">
            <!-- Banner Section -->
            <div class="h-48 sm:h-64 relative overflow-hidden bg-gradient-to-r from-primary via-primary-focus to-secondary">
                @if($user->banner)
                    <img src="{{ $user->banner_url }}" 
                         alt="Profile banner"
                         class="w-full h-full object-cover"
                         loading="eager" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent"></div>
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-primary-focus/80 to-secondary/90"></div>
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
                @endif
                
                <!-- Floating Elements -->
                <div class="absolute top-4 right-4 size-3 bg-white/30 rounded-full animate-pulse"></div>
                <div class="absolute top-12 right-12 size-2 bg-white/40 rounded-full animate-pulse delay-75"></div>
                <div class="absolute top-8 right-20 size-1 bg-white/50 rounded-full animate-pulse delay-150"></div>
            </div>

            <!-- Profile Info Container -->
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative -mt-16 sm:-mt-20">
                    <!-- Avatar -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                        <div class="relative group">
                            <div class="size-32 sm:size-40 rounded-full ring-4 ring-white shadow-xl overflow-hidden bg-white">
                                <img src="{{ $user->avatar_url }}" 
                                     alt="{{ $user->name }}'s avatar"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                     loading="eager" />
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="flex-1 pb-4">
                            <div class="bg-base-100/95 backdrop-blur-sm rounded-2xl p-6 shadow-xl border border-base-300/50">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div>
                                        <h1 class="text-2xl sm:text-3xl font-bold text-base-content mb-1">
                                            {{ $user->name }}
                                        </h1>
                                        
                                        @if($user->bio)
                                            <p class="text-base-content/80 max-w-md leading-relaxed">{{ $user->bio }}</p>
                                        @endif

                                        <!-- Location & Website -->
                                        <div class="flex flex-wrap items-center gap-4 mt-3 text-sm text-base-content/60">
                                            @if($user->location)
                                                <div class="flex items-center gap-1">
                                                    <span class="icon-[tabler--map-pin] size-4"></span>
                                                    <span>{{ $user->location }}</span>
                                                </div>
                                            @endif
                                            @if($user->website)
                                                <a href="{{ $user->website }}" target="_blank" class="flex items-center gap-1 text-primary hover:text-primary-focus transition-colors">
                                                    <span class="icon-[tabler--link] size-4"></span>
                                                    <span>{{ parse_url($user->website, PHP_URL_HOST) }}</span>
                                                </a>
                                            @endif
                                            <div class="flex items-center gap-1">
                                                <span class="icon-[tabler--calendar] size-4"></span>
                                                <span>Joined {{ $user->created_at->format('F Y') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center gap-3">
                                        @auth
                                            @if(auth()->user()->getKey() === $user->getKey())
                                                <a href="{{ route('profile.edit') }}" 
                                                   class="btn btn-primary rounded-full px-6 py-2 shadow-lg hover:shadow-xl transition-all duration-200">
                                                    <span class="icon-[tabler--edit] size-4 mr-2"></span>
                                                    Edit Profile
                                                </a>
                                            @else
                                                <button class="btn btn-outline rounded-full px-6 py-2 shadow-lg hover:shadow-xl transition-all duration-200">
                                                    <span class="icon-[tabler--user-plus] size-4 mr-2"></span>
                                                    Follow
                                                </button>
                                                <button class="btn btn-ghost rounded-full p-2 shadow-lg hover:shadow-xl transition-all duration-200">
                                                    <span class="icon-[tabler--message-circle] size-5"></span>
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="grid grid-cols-3 gap-4 sm:gap-6">
                <div class="bg-base-100/80 backdrop-blur-sm rounded-2xl p-4 sm:p-6 text-center shadow-lg border border-base-300/50 hover:bg-base-100 transition-all duration-300 group">
                    <div class="text-2xl sm:text-3xl font-bold text-base-content group-hover:scale-110 transition-transform duration-200">
                        {{ number_format($stats['tweets_count']) }}
                    </div>
                    <div class="text-sm sm:text-base text-base-content/60 mt-1">Tweets</div>
                </div>
                <div class="bg-base-100/80 backdrop-blur-sm rounded-2xl p-4 sm:p-6 text-center shadow-lg border border-base-300/50 hover:bg-base-100 transition-all duration-300 group">
                    <div class="text-2xl sm:text-3xl font-bold text-base-content group-hover:scale-110 transition-transform duration-200">
                        {{ number_format($stats['following_count']) }}
                    </div>
                    <div class="text-sm sm:text-base text-base-content/60 mt-1">Following</div>
                </div>
                <div class="bg-base-100/80 backdrop-blur-sm rounded-2xl p-4 sm:p-6 text-center shadow-lg border border-base-300/50 hover:bg-base-100 transition-all duration-300 group">
                    <div class="text-2xl sm:text-3xl font-bold text-base-content group-hover:scale-110 transition-transform duration-200">
                        {{ number_format($stats['followers_count']) }}
                    </div>
                    <div class="text-sm sm:text-base text-base-content/60 mt-1">Followers</div>
                </div>
            </div>
        </div>

        <!-- Tweets Section -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 pb-12">
            <div class="bg-base-100/80 backdrop-blur-sm rounded-2xl shadow-xl border border-base-300/50 overflow-hidden">
                <!-- Tab Header -->
                <div class="px-6 py-4 border-b border-base-300/50">
                    <div class="flex items-center gap-6">
                        <button class="relative px-4 py-2 text-primary font-semibold">
                            Tweets
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary rounded-full"></div>
                        </button>
                        <button class="px-4 py-2 text-base-content/60 hover:text-base-content font-medium transition-colors">
                            Replies
                        </button>
                        <button class="px-4 py-2 text-base-content/60 hover:text-base-content font-medium transition-colors">
                            Media
                        </button>
                        <button class="px-4 py-2 text-base-content/60 hover:text-base-content font-medium transition-colors">
                            Likes
                        </button>
                    </div>
                </div>

                <!-- Tweets List -->
                <div class="divide-y divide-base-300/50">
                    @forelse($tweets as $tweet)
                        <div class="p-6 hover:bg-base-100 transition-colors duration-200">
                            <x-trend :tweet="$tweet" />
                        </div>
                    @empty
                        <div class="p-12">
                            <x-empty-state 
                                title="No tweets yet"
                                description="{{ $user->name }} hasn't posted any tweets."
                            />
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($tweets->hasPages())
                    <div class="px-6 py-4 border-t border-base-300/50">
                        {{ $tweets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Floating Action Button (for mobile) -->
    @auth
        @if(auth()->user()->getKey() === $user->getKey())
            <div class="fixed bottom-6 right-6 sm:hidden">
                <a href="{{ route('profile.edit') }}" 
                   class="btn btn-primary rounded-full size-14 shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center justify-center">
                    <span class="icon-[tabler--edit] size-6"></span>
                </a>
            </div>
        @endif
    @endauth
</x-layouts.app>
