<x-layouts.app>
    @foreach ($tweets as $tweet)
    <x-trend :tweet="$tweet"></x-trend>
    @endforeach
</x-layouts.app>