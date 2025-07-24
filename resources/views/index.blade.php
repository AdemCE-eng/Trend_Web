<x-layouts.app title="Home Feed">
    @foreach ($tweets as $tweet)
    <x-trend :tweet="$tweet"></x-trend>
    @endforeach
</x-layouts.app>