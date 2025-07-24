@php
    // Set default page title for auth pages if not provided
    $pageTitle = $title ?? 'Authentication';
@endphp

<x-layouts.default :title="$pageTitle">
    <div>
      {{ $slot }}
    </div>
</x-layouts.default>