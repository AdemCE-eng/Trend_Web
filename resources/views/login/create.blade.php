<x-layouts.auth title="Sign In">
    <div class="drop-shadow-2xl flex h-auto min-h-screen items-center justify-center overflow-x-hidden py-6">
    <div class="relative flex items-center justify-center px-4 sm:px-6 lg:px-8 w-full">
      <div class="bg-base-100 shadow-base-300/20 z-1 w-full max-w-md space-y-4 rounded-xl p-6 shadow-md lg:p-6">
        <div class="text-center">
          <a href="{{ route('home') }}" class="inline-flex justify-center items-center gap-3 pb-2">
            <img src="/images/Trends_Logo.png" class="size-8 rounded-md flex-shrink-0" alt="logo">
            <h2 class="text-base-content text-xl font-bold whitespace-nowrap">Trends</h2>
          </a>
          <div>
            <h3 class="text-base-content mb-4 text-2xl font-semibold">Sign in to Trends</h3>
          </div>
        </div>
        <div class="space-y-3">
          <form method="post" class="space-y-3">
            @csrf
            <div>
              <div class="input">
                <span class="icon-[tabler--mail] text-base-content/80 my-auto size-5 shrink-0"></span>
                <div class="input-floating grow">
                  <input
                    required
                    type="email"
                    placeholder="Enter your email address"
                    class="ps-3 @error('email') border-error @enderror"
                    id="email"
                    name="email"
                    maxlength="255"
                    value="{{ old('email') }}"
                    title="Please enter a valid email address"
                  />
                  <label class="input-floating-label @error('email') text-error @enderror" for="email">Email Address</label>
                </div>
              </div>
              @error('email')
                <div class="text-error text-xs mt-1 flex items-start gap-1 px-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-3 flex-shrink-0 mt-0.5" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                  </svg>
                  <span class="flex-1 leading-tight">{{ $message }}</span>
                </div>
              @enderror
            </div>
            <div>
              <div class="input">
                <span class="icon-[tabler--lock] text-base-content/80 my-auto size-5 shrink-0"></span>
                <div class="input-floating grow">
                  <input
                    required
                    type="password"
                    placeholder="············"
                    class="ps-3 @error('password') border-error @enderror"
                    id="password"
                    name="password"
                    maxlength="255"
                    title="Please enter your password"
                  />
                  <label class="input-floating-label @error('password') text-error @enderror" for="password">Password</label>
                </div>
                <button type="button" data-toggle-password='{ "target": "#password" }' class="block cursor-pointer"
                  aria-label="Toggle password visibility">
                  <span class="icon-[tabler--eye] password-active:block hidden size-5 shrink-0"></span>
                  <span class="icon-[tabler--eye-off] password-active:hidden block size-5 shrink-0"></span>
                </button>
              </div>
              @error('password')
                <div class="text-error text-xs mt-1 flex items-start gap-1 px-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-3 flex-shrink-0 mt-0.5" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                  </svg>
                  <span class="flex-1 leading-tight">{{ $message }}</span>
                </div>
              @enderror
            </div>
            <div class="flex items-center justify-between gap-y-2">
              <div class="flex items-center gap-2">
                <input type="checkbox" 
                       class="checkbox checkbox-sm checkbox-primary" 
                       id="rememberMe" 
                       name="remember" 
                       value="1"
                       {{ old('remember') ? 'checked' : '' }} />
                <label class="label-text p-0 text-sm text-base-content/80" for="rememberMe">Remember Me</label>
              </div>
              {{-- <a href="#" class="link link-animated link-primary font-normal">Forgot Password?</a> --}}
            </div>
            <button type="submit" class="btn btn-md btn-primary btn-gradient btn-block">Sign in to Trends</button>
          </form>
          <p class="text-base-content/80 text-center text-sm">
            New on our platform?
            <a href="{{route('register')}}" class="link link-animated link-primary font-normal">Create an account</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</x-layouts.auth>