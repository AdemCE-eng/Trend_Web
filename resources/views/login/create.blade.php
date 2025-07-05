<x-layouts.auth>
    <div class="bg-base-100 flex h-auto min-h-screen items-center justify-center overflow-x-hidden py-10">
    <div class="relative flex items-center justify-center px-4 sm:px-6 lg:px-8">
      <div class="absolute">
      </div>
      <div class="bg-base-100 shadow-base-300/20 z-1 w-full space-y-6 rounded-xl p-6 shadow-md sm:min-w-md lg:p-8">
        <div class="flex items-center gap-3">
          <img src="/images/Trends_Logo.png" class="size-8 rounded-md" alt="brand-logo" />
          <h2 class="text-base-content text-xl font-bold">Trends</h2>
        </div>
        <div>
          <h3 class="text-base-content mb-1.5 text-2xl font-semibold">Sign in to Trends</h3>
        </div>
        <div class="space-y-4">
          <form class="mb-4 space-y-4" onsubmit="return false;">
            <div>
              <label class="label-text" for="userEmail">Email address*</label>
              <input type="email" placeholder="Enter your email address" class="input" id="userEmail" required />
            </div>
            <div>
              <label class="label-text" for="userPassword">Password*</label>
              <div class="input">
                <input id="userPassword" type="password" placeholder="············" required />
                <button
                  type="button"
                  data-toggle-password='{ "target": "#userPassword" }'
                  class="block cursor-pointer"
                  aria-label="userPassword"
                >
                  <span class="icon-[tabler--eye] password-active:block hidden size-5 shrink-0"></span>
                  <span class="icon-[tabler--eye-off] password-active:hidden block size-5 shrink-0"></span>
                </button>
              </div>
            </div>
            <div class="flex items-center justify-between gap-y-2">
              <div class="flex items-center gap-2">
                <input type="checkbox" class="checkbox checkbox-primary" id="rememberMe" />
                <label class="label-text text-base-content/80 p-0 text-base" for="rememberMe">Remember Me</label>
              </div>
              <a href="#" class="link link-animated link-primary font-normal">Forgot Password?</a>
            </div>
            <button class="btn btn-lg btn-primary btn-gradient btn-block">Sign in to FlyonUI</button>
          </form>
          <p class="text-base-content/80 mb-4 text-center">
            New on our platform?
            <a href="/register" class="link link-animated link-primary font-normal">Create an account</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</x-layouts.auth>