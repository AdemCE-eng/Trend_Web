@props([
    'tweet', 
])
<div class="card card-border shadow-none mt-4 bg-green-30">
    <div class="card-body">
        <div class="flex">
            <div class="flex-shrink-0 mr-3">
                <div class="size-10 rounded-full">
                    <img src="{{ $tweet->user->avatar_url }}" alt="avatar"
                        class="w-full h-full rounded-full object-cover" />
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <a href="#">
                    <div class="font-medium text-gray-700 link link-animated mb-1">
                        {{ $tweet->user->name }}
                    </div>
                </a>
                
                <a href="{{ route('tweet.view',$tweet->id) }}">
                    <p class="mb-4 break-words overflow-hidden">{{ $tweet->content }}</p>
                </a>
                
                <div class="flex gap-6">
                    @if(request()->route('tweet') && request()->route('tweet')->id == $tweet->id)
                        <button class="btn-sm opacity-50 cursor-not-allowed" disabled>
                            <span class="icon-[tabler--message-circle] size-4"></span>
                        </button>
                    @else
                        <a href="{{ route('tweet.view', $tweet->id) }}" class="btn-sm">
                            <span class="icon-[tabler--message-circle] size-4"></span>
                        </a>
                    @endif
                    <button class="btn-sm">
                        <span class="icon-[tabler--heart] size-4"></span>
                    </button>
                    <button class="btn-sm">
                        <span class="icon-[tabler--repeat] size-4"></span>
                    </button>
                    <button class="btn-sm">
                        <span class="icon-[tabler--share] size-4"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>