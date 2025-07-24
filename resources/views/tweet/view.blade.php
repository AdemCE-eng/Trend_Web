<x-layouts.app :title="$tweet->user->name . ' on Trends'">
    <x-trend :tweet="$tweet" :depth="0"></x-trend>
</x-layouts.app>