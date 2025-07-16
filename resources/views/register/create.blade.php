<x-layouts.auth>
  <div class="drop-shadow-2xl flex h-auto min-h-screen items-center justify-center overflow-x-hidden py-10">
    <div class="relative flex items-center justify-center px-4 sm:px-6 lg:px-8">
      <div class="bg-base-100 shadow-base-300/20 z-1 w-full space-y-6 rounded-xl p-6 shadow-md sm:min-w-md lg:p-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3 pl-3">
          <img src="/images/Trends_Logo.png" class="size-8 rounded-md" alt="logo">
          <h2 class="text-base-content text-xl font-bold">Trends</h2>
        </a>
        <div class="pl-3">
          <h3 class="text-base-content mb-1.5 text-2xl font-semibold">Sign Up to Trends</h3>
        </div>
        <div class="space-y-4 pl-3">
          <form method="post" class="mb-4 space-y-4">
            @csrf
            <div class="input">
              <span class="icon-[tabler--user] text-base-content/80 my-auto size-5 shrink-0"></span>
              <div class="input-floating grow">
                <input
                  required
                  type="text"
                  placeholder="Enter your username"
                  class="ps-3"
                  id="name"
                  name="name"
                  maxLength="20"
                  minlength="3"
                  pattern="^[a-zA-Z][a-zA-Z0-9_]*$"
                  value="{{ old('name') }}"
                  title="Username must be 3-20 characters, start with a letter, and contain only letters, numbers, or underscores (no spaces allowed)"
                />
                <label class="input-floating-label" for="name">Username</label>
              </div>
            </div>
            <div class="input">
              <span class="icon-[tabler--mail] text-base-content/80 my-auto size-5 shrink-0"></span>
              <div class="input-floating grow">
                <input
                  required
                  type="email"
                  placeholder="Enter your email address"
                  class="ps-3"
                  id="email"
                  name="email"
                  maxLength="255"
                  value="{{ old('email') }}"
                  title="Please enter a valid email address"
                />
                <label class="input-floating-label" for="email">Email address</label>
              </div>
            </div>
            <div>
              <div class="input">
                <span class="icon-[tabler--lock] text-base-content/80 my-auto size-5 shrink-0"></span>
                <div class="input-floating grow">
                  <input
                    required
                    type="password"
                    placeholder="············"
                    class="ps-3"
                    id="password"
                    name="password"
                    maxLength="255"
                    minlength="8"
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                    title="Password must be at least 8 characters with uppercase, lowercase, number, and special character"
                  />
                  <label class="input-floating-label" for="password">Password</label>
                </div>
                <button type="button" data-toggle-password='{ "target": "#password" }' class="block cursor-pointer"
                  aria-label="Toggle password visibility">
                  <span class="icon-[tabler--eye] password-active:block hidden size-5 shrink-0"></span>
                  <span class="icon-[tabler--eye-off] password-active:hidden block size-5 shrink-0"></span>
                </button>
              </div>
              <div class="text-sm text-base-content/60 mt-2">
                <!-- Password Strength Bar -->
                <div class="password-strength mb-3">
                  <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium">Password strength</span>
                    <span class="text-xs strength-text text-base-content/70">Enter password</span>
                  </div>
                  <div class="flex gap-1 mb-2">
                    <div class="h-2 bg-base-300 rounded-full flex-1 strength-bar transition-colors duration-300" data-level="1"></div>
                    <div class="h-2 bg-base-300 rounded-full flex-1 strength-bar transition-colors duration-300" data-level="2"></div>
                    <div class="h-2 bg-base-300 rounded-full flex-1 strength-bar transition-colors duration-300" data-level="3"></div>
                    <div class="h-2 bg-base-300 rounded-full flex-1 strength-bar transition-colors duration-300" data-level="4"></div>
                  </div>
                </div>
                
                <!-- Password Requirements -->
                <ul class="list-none ml-0 text-xs space-y-1">
                  <li class="requirement flex items-center gap-2" data-requirement="length">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>At least 8 characters</span>
                  </li>
                  <li class="requirement flex items-center gap-2" data-requirement="uppercase">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>One uppercase letter</span>
                  </li>
                  <li class="requirement flex items-center gap-2" data-requirement="lowercase">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>One lowercase letter</span>
                  </li>
                  <li class="requirement flex items-center gap-2" data-requirement="number">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>One number</span>
                  </li>
                  <li class="requirement flex items-center gap-2" data-requirement="special">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>One special character (@$!%*?&)</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="input">
              <span class="icon-[tabler--lock-check] text-base-content/80 my-auto size-5 shrink-0"></span>
              <div class="input-floating grow">
                <input
                  required
                  type="password"
                  placeholder="············"
                  class="ps-3"
                  id="password_confirmation"
                  name="password_confirmation"
                  maxLength="255"
                  minlength="8"
                />
                <label class="input-floating-label" for="password_confirmation">Confirm Password</label>
              </div>
              <button type="button" data-toggle-password='{ "target": "#password_confirmation" }'
                class="block cursor-pointer" aria-label="Toggle password confirmation visibility">
                <span class="icon-[tabler--eye] password-active:block hidden size-5 shrink-0"></span>
                <span class="icon-[tabler--eye-off] password-active:hidden block size-5 shrink-0"></span>
              </button>
            </div>
            <div class="flex items-center gap-2">
              <input type="checkbox" 
                     class="checkbox checkbox-primary" 
                     id="policyagreement" 
                     name="terms" 
                     required />
              <label class="label-text text-base-content/80 p-0 text-base" for="policyagreement">
                I agree to
                <a href="#" class="link link-animated link-primary font-normal">privacy policy & terms</a>
              </label>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-gradient btn-block">Sign Up to Trends</button>
          </form>
          <p class="text-base-content/80 mb-4 text-center">
            Already have an account?
            <a href="{{route('login')}}" class="link link-animated link-primary font-normal">Sign in instead</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</x-layouts.auth>