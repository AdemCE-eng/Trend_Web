{{-- Empty state for when there are no tweets --}}
@props(['title' => 'No tweets yet', 'description' => 'Be the first to share something!', 'actionText' => null, 'actionUrl' => null])

<div class="text-center py-12">
    <div class="max-w-md mx-auto">
        <!-- Empty state illustration -->
        <div class="size-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
            <span class="icon-[tabler--message-circle-off] size-12 text-gray-400"></span>
        </div>
        
        <!-- Empty state content -->
        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $title }}</h3>
        <p class="text-gray-600 mb-6">{{ $description }}</p>
        
        <!-- Optional action button -->
        @if($actionText && $actionUrl)
            <a href="{{ $actionUrl }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-all duration-200 shadow-sm hover:shadow-md">
                <span class="icon-[tabler--plus] size-4"></span>
                {{ $actionText }}
            </a>
        @endif
        
        <!-- Decorative elements -->
        <div class="mt-8 flex justify-center space-x-2">
            <div class="size-2 bg-gray-300 rounded-full animate-pulse"></div>
            <div class="size-2 bg-gray-300 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
            <div class="size-2 bg-gray-300 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
        </div>
    </div>
</div>
