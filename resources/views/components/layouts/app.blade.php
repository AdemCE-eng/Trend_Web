<x-layouts.default>
  <nav class="navbar bg-base-100 rounded-box shadow-base-300/20 shadow-sm sticky top-0 z-50 border-b-1 h-16 px-6">
    <div class="flex flex-1 items-center">
      <a class="link text-base-content link-neutral text-2xl font-bold no-underline" href="{{route('home')}}">
        Trends
      </a>
    </div>
    <div class="navbar-end flex items-center gap-4">
      @if (Auth::check())
      <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
      <button id="dropdown-scrollable" type="button" class="dropdown-toggle flex items-center" aria-haspopup="menu"
        aria-expanded="false" aria-label="Dropdown">
        <div class="avatar">
        <div class="size-9.5 rounded-full">
          <img src="/images/Trends_Logo.png" alt="Logo" />
        </div>
        </div>
      </button>
      <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical"
        aria-labelledby="dropdown-avatar">
        <li class="dropdown-header gap-2">
        <div class="avatar">
          <div class="w-10 rounded-full">
          <img src="/images/Trends_logo.png" alt="avatar" />
          </div>
        </div>
        <div>
          <h6 class="text-base-content text-base font-semibold">John Doe</h6>
          <small class="text-base-content/50">Admin</small>
        </div>
        </li>
        <li>
        <a class="dropdown-item" href="#">
          <span class="icon-[tabler--user]"></span>
          My Profile
        </a>
        </li>
        <li>
        <a class="dropdown-item" href="#">
          <span class="icon-[tabler--settings]"></span>
          Settings
        </a>
        </li>
        <li>
        <a class="dropdown-item" href="#">
          <span class="icon-[tabler--receipt-rupee]"></span>
          Billing
        </a>
        </li>
        <li>
        <a class="dropdown-item" href="#">
          <span class="icon-[tabler--help-triangle]"></span>
          FAQs
        </a>
        </li>
        <li class="dropdown-footer gap-2">
        <a class="btn btn-error btn-soft btn-block" href="#">
          <span class="icon-[tabler--logout]"></span>
          Sign out
        </a>
        </li>
      </ul>
      </div>
    @else
      <div class="flex items-center gap-2">
      <a href="{{ route('login') }}" class="btn btn-primary">
        <span class="icon-[tabler--login-2]"></span>
        Login
      </a>
      <a href="{{ route('register') }}" class="btn btn-outline btn-primary">
        <span class="icon-[tabler--user-plus]"></span>
        Register
      </a>
      </div>
    @endif
    </div>
  </nav>
  <div class="mt-8">
    {{ $slot }}
  </div>
  <div
    class="border border-base-200 border-t-2 border-t-primary rounded-field sticky bottom-2 drop-shadow-2xl bg-base-100">
    <div class="textarea-floating">
      <textarea class="textarea border-0 resize-none min-h-8 max-h-16" placeholder="Share your thoughts…"
        id="textareaFloating"></textarea>
      <label class="textarea-floating-label" for="textareaFloating">Write a tweet</label>
    </div>
    <div class="p-1">
      <button class="btn btn-primary btn-sm">
        Tweet
      </button>
    </div>
  </div>
</x-layouts.default>