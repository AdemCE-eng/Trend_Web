@props([
    'tweet', 
])
<a href="{{ route('tweet.view') }}">
    <div class="card card-border shadow-none mt-4 bg-green-30">
        <div class="card-body">
            <div class="flex items-center mb-3">
                <div class="size-10 rounded-full mr-3">
                    <img src="{{ $tweet->user->avatar_url }}" alt="avatar"
                        class="w-full h-full rounded-full object-cover" />
                </div>
                <div class="font-medium text-gray-700">
                    {{ $tweet->user->name }}
                </div>
            </div>
            <p class="mb-4 ml-10 mr-10 break-words overflow-hidden">{{ $tweet->content }}</p>
            <div class="flex gap-4 ml-13">
                <button class="btn-sm">
                    <span class="icon-[tabler--message-circle] size-4"></span>
                </button>
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
</a>