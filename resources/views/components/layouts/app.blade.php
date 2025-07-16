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
  <div class="fixed bottom-4 left-4 right-4 mx-auto max-w-2xl">
    <div class="bg-base-100 border border-base-200 rounded-xl shadow-lg p-4 backdrop-blur-sm">
      <div class="flex flex-col gap-3">
        <div class="textarea-floating">
          <textarea class="textarea border border-base-300 focus:border-primary focus:outline-none resize-none min-h-12 max-h-32 rounded-lg px-3 py-2 transition-all duration-200" 
            placeholder="What's happening?" 
            id="textareaFloating"></textarea>
          <label class="textarea-floating-label text-base-content/60" for="textareaFloating">Share your thoughts</label>
        </div>
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-2 text-base-content/50">
            <span class="icon-[tabler--photo] text-lg cursor-pointer hover:text-primary transition-colors"></span>
            <span class="icon-[tabler--mood-smile] text-lg cursor-pointer hover:text-primary transition-colors"></span>
            <span class="icon-[tabler--map-pin] text-lg cursor-pointer hover:text-primary transition-colors"></span>
          </div>
          <div class="flex items-center gap-3">
            <span class="text-sm text-base-content/50 font-medium">0/300</span>
            <button class="btn btn-primary btn-sm px-6 hover:btn-primary-focus transition-all duration-200">
              <span class="icon-[tabler--send] mr-1"></span>
              Tweet
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-layouts.default>