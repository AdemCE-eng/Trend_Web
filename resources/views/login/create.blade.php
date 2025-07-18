<x-layouts.auth>
    <div class="drop-shadow-2xl flex h-auto min-h-screen items-center justify-center overflow-x-hidden py-10">
    <div class="relative flex items-center justify-center px-4 sm:px-6 lg:px-8">
      <div class="absolute">
      </div>
      <div class="bg-base-100 shadow-base-300/20 z-1 w-full space-y-6 rounded-xl p-6 shadow-md sm:min-w-md lg:p-8">
        <a href="{{route('home')}}" class="flex items-center gap-3">
          <img src="/images/Trends_Logo.png" class="size-8 rounded-md" alt="brand-logo" />
          <h2 class="text-base-content text-xl font-bold">Trends</h2>
        </a>
        <div>
          <h3 class="text-base-content mb-1.5 text-2xl font-semibold">Sign in to Trends</h3>
        </div>
        <div class="space-y-4">
          <form method="post" class="mb-4 space-y-4">
            @csrf
            <div>
              <label class="label-text" for="email">Email address*</label>
              <input type="email" 
                     placeholder="Enter your email address" 
                     class="input @error('email') border-error @enderror" 
                     id="email" 
                     name="email" 
                     required 
                     maxlength="255"
                     value="{{ old('email') }}"
                     title="Please enter a valid email address"/>
              @error('email')
                <div class="text-error text-sm mt-1 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                  </svg>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>
            <div>
              <label class="label-text" for="password">Password*</label>
              <div class="input @error('password') border-error @enderror">
                <input id="password" 
                       type="password" 
                       name="password" 
                       placeholder="············" 
                       required 
                       maxlength="255"
                       title="Please enter your password"/>
                <button
                  type="button"
                  data-toggle-password='{ "target": "#password" }'
                  class="block cursor-pointer"
                  aria-label="Toggle password visibility"
                >
                  <span class="icon-[tabler--eye] password-active:block hidden size-5 shrink-0"></span>
                  <span class="icon-[tabler--eye-off] password-active:hidden block size-5 shrink-0"></span>
                </button>
              </div>
              @error('password')
                <div class="text-error text-sm mt-1 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                  </svg>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>
            <div class="flex items-center justify-between gap-y-2">
              <div class="flex items-center gap-2">
                <input type="checkbox" 
                       class="checkbox checkbox-primary" 
                       id="rememberMe" 
                       name="remember" 
                       value="1"
                       {{ old('remember') ? 'checked' : '' }} />
                <label class="label-text text-base-content/80 p-0 text-base" for="rememberMe">Remember Me</label>
              </div>
              <a href="#" class="link link-animated link-primary font-normal">Forgot Password?</a>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-gradient btn-block">Sign in to Trends</button>
          </form>
          <p class="text-base-content/80 mb-4 text-center">
            New on our platform?
            <a href="{{route('register')}}" class="link link-animated link-primary font-normal">Create an account</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</x-layouts.auth>