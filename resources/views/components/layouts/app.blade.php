{{--
/**
 * Main Application Layout - Trends Social Media Platform
 * 
 * This layout provides the core structure for authenticated user pages including:
 * - Responsive navigation bar with user dropdown
 * - Tweet composition form (floating on mobile, fixed on desktop)
 * - User authentication state handling
 * - Consistent styling and branding
 * 
 * Features:
 * - Sticky navigation with backdrop blur effect
 * - User profile dropdown with navigation links
 * - Floating tweet composer with character limit
 * - Responsive design for mobile and desktop
 * - Toast notifications support
 * - CSRF token management
 * 
 * Used by: All authenticated user pages
 * Extends: components.layouts.default
 */
--}}

<x-layouts.default>
  {{-- Main Navigation Bar --}}
  <nav class="navbar bg-base-100/95 backdrop-blur-md rounded-box shadow-lg shadow-base-300/30 sticky top-2 z-50 border border-base-200/50 h-20 px-6">
    <div class="flex flex-1 items-center">
      <a class="flex items-center gap-3 link text-base-content link-neutral text-2xl font-bold no-underline hover:scale-105 transition-transform duration-200" href="{{route('home')}}">
        <img src="{{ asset('images/Trends_Logo.png') }}" alt="Trends Logo" class="h-10 w-10 object-contain rounded-xl shadow-sm">
        <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Trends</span>
      </a>
    </div>
    <div class="navbar-end flex items-center gap-4">
      @if (Auth::check())
      <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:12] [--placement:bottom-end]">
      <button id="dropdown-scrollable" type="button" class="dropdown-toggle flex items-center gap-2 p-2 rounded-full hover:bg-base-200/80 transition-all duration-200 group" aria-haspopup="menu"
        aria-expanded="false" aria-label="User menu">
        <div class="avatar">
        <div class="size-11 rounded-full ring-2 ring-primary/20 group-hover:ring-primary/40 transition-all duration-200">
          <img src="{{ Auth::user()->avatar_url }}" alt="User avatar" class="object-cover" />
        </div>
        </div>
        <span class="icon-[tabler--chevron-down] text-base-content/60 group-hover:text-base-content transition-colors"></span>
      </button>
      <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-64 bg-base-100/95 backdrop-blur-md border border-base-200/50 shadow-xl rounded-2xl p-2" role="menu" aria-orientation="vertical"
        aria-labelledby="dropdown-avatar">
        <li class="dropdown-header gap-3 p-3 bg-gradient-to-r from-primary/5 to-secondary/5 rounded-xl mb-2">
        <div class="avatar">
          <div class="w-12 rounded-full ring-2 ring-primary/30">
          <img src="{{ Auth::user()->avatar_url }}" alt="User avatar" class="object-cover" />
          </div>
        </div>
        <div class="flex-1">
          <h6 class="text-base-content text-base font-semibold truncate">{{ Auth::user()->name }}</h6>
        </div>
        </li>
        <li>
        <a class="dropdown-item rounded-lg p-3 hover:bg-base-200/80 transition-all duration-200 flex items-center gap-3" href="{{ route('profile.show', Auth::user()) }}">
          <span class="icon-[tabler--user] text-primary"></span>
          <span class="font-medium">My Profile</span>
        </a>
        </li>
        <li>
        <a class="dropdown-item rounded-lg p-3 hover:bg-base-200/80 transition-all duration-200 flex items-center gap-3" href="{{ route('profile.edit') }}">
          <span class="icon-[tabler--settings] text-primary"></span>
          <span class="font-medium">Settings</span>
        </a>
        </li>
        <li>
        <a class="dropdown-item rounded-lg p-3 hover:bg-base-200/80 transition-all duration-200 flex items-center gap-3" href="#">
          <span class="icon-[tabler--help-triangle] text-primary"></span>
          <span class="font-medium">Help & Support</span>
        </a>
        </li>
        <li class="dropdown-footer gap-2 mt-2 pt-2 border-t border-base-200/50">
        <form method="post" action="{{ route('logout') }}" class="w-full">
          @csrf
          <button type="submit" class="btn btn-error btn-soft btn-block rounded-lg hover:btn-error-focus transition-all duration-200 group">
          <span class="icon-[tabler--logout] group-hover:scale-110 transition-transform"></span>
          Sign out
          </button>
        </form>
        </li>
      </ul>
      </div>
    @else
      <div class="flex items-center gap-3">
      <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-6 hover:btn-primary-focus transition-all duration-200 hover:scale-105">
        <span class="icon-[tabler--login-2]"></span>
        Login
      </a>
      <a href="{{ route('register') }}" class="btn btn-outline btn-primary btn-sm px-6 hover:bg-primary hover:text-primary-content transition-all duration-200 hover:scale-105">
        <span class="icon-[tabler--user-plus]"></span>
        Register
      </a>
      </div>
    @endif
    </div>
  </nav>
  <div class="mt-5 @if(Auth::check() && !request()->routeIs('profile.*')) pb-32 @else pb-10 @endif">
    {{ $slot }}
  </div>
  @if (Auth::check() && !request()->routeIs('profile.*'))
  <div class="fixed bottom-4 left-4 right-4 mx-auto max-w-2xl">
    <form method="post" action="{{ route('tweet.create') }}">
      @csrf
      <input type="hidden" name="parent_tweet_id" value="{{ request()->tweet?->id }}">
      <div class="bg-base-100 border border-base-200 rounded-xl shadow-lg p-4 backdrop-blur-sm">
        <div class="flex flex-col gap-3">
          <div class="textarea-floating">
            <textarea
              class="textarea border focus:outline-none resize-none min-h-12 max-h-32 rounded-lg px-3 py-2 transition-all duration-200 {{ $errors->has('content') ? 'border-error focus:border-error' : 'border-base-300 focus:border-primary' }}"
              placeholder="What's happening?" id="textareaFloating" name="content" maxlength="10000">{{ old('content') }}</textarea>
            <label class="textarea-floating-label text-base-content/60" for="textareaFloating">Share your
              thoughts</label>
            @error('content')
              <div class="text-error text-sm mt-1">
                <span class="icon-[tabler--alert-circle] mr-1"></span>
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="flex justify-between items-center">
            <div class="flex items-center gap-2 text-base-content/50">
              <span class="icon-[tabler--photo] text-lg cursor-pointer hover:text-primary transition-colors"></span>
              <span
                class="icon-[tabler--mood-smile] text-lg cursor-pointer hover:text-primary transition-colors"></span>
              <span class="icon-[tabler--map-pin] text-lg cursor-pointer hover:text-primary transition-colors"></span>
            </div>
            <div class="flex items-center gap-3">
              <button type="submit" class="btn btn-primary btn-sm px-6 hover:btn-primary-focus transition-all duration-200">
                <span class="icon-[tabler--send] mr-1"></span>
                Tweet
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  @endif
</x-layouts.default>