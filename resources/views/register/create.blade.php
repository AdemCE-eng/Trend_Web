<x-layouts.auth>
  <div class="drop-shadow-2xl flex h-auto min-h-screen items-center justify-center overflow-x-hidden py-6">
    <div class="relative flex items-center justify-center px-4 sm:px-6 lg:px-8">
      <div class="bg-base-100 shadow-base-300/20 z-1 w-full space-y-4 rounded-xl p-6 shadow-md sm:min-w-md lg:p-6">
        <div class="text-center">
          <a href="{{ route('home') }}" class="flex justify-center items-center gap-3 pb-2">
          <img src="/images/Trends_Logo.png" class="size-8 rounded-md" alt="logo">
          <h2 class="text-base-content text-xl font-bold">Trends</h2>
        </a>
        <div>
          <h3 class="text-base-content mb-4 text-2xl font-semibold">Sign Up to Trends</h3>
        </div>
        </div>
        <div class="space-y-3">
          <form method="post" class="space-y-3" enctype="multipart/form-data">
            @csrf
            <!-- Avatar Upload Section -->
            <div class="flex justify-center">
              <div class="flex flex-col items-center">
                <div class="relative group">
                  <div class="avatar-preview w-16 h-16 rounded-full border-2 border-base-300 bg-base-200 flex items-center justify-center overflow-hidden mb-2 transition-all duration-300 group-hover:border-primary">
                    <img id="avatar-image" src="/images/default-avatar.png" alt="Avatar preview" class="w-full h-full object-cover hidden" />
                    <span class="icon-[tabler--camera] text-base-content/40 size-6" id="avatar-placeholder"></span>
                  </div>
                  <label for="avatar" class="absolute inset-0 cursor-pointer rounded-full">
                    <span class="sr-only">Choose avatar</span>
                  </label>
                </div>
                <label for="avatar" class="btn btn-xs btn-outline btn-primary cursor-pointer">
                  <span class="icon-[tabler--upload] size-3"></span>
                  Choose Avatar
                </label>
                <input
                  type="file"
                  id="avatar"
                  name="avatar"
                  accept=".png,.jpg,.jpeg"
                  class="hidden @error('avatar') border-error @enderror"
                  onchange="previewAvatar(this)"
                />
                <p class="text-xs text-base-content/60 mt-1 text-center">
                  Upload PNG or JPEG only (max 2MB)
                </p>
              </div>
              @error('avatar')
                <div class="text-error text-xs mt-1 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
              <div class="input">
                <span class="icon-[tabler--user] text-base-content/80 my-auto size-5 shrink-0"></span>
                <div class="input-floating grow">
                  <input
                    required
                    type="text"
                    placeholder="Enter your username"
                    class="ps-3 @error('name') border-error @enderror"
                    id="name"
                    name="name"
                    maxLength="20"
                    minlength="3"
                    pattern="^[a-zA-Z][a-zA-Z0-9_]*$"
                    value="{{ old('name') }}"
                    title="Username must be 3-20 characters, start with a letter, and contain only letters, numbers, or underscores (no spaces allowed)"
                  />
                  <label class="input-floating-label @error('name') text-error @enderror" for="name">Username</label>
                </div>
              </div>
              @error('name')
                <div class="text-error text-xs mt-1 pl-8 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                    maxLength="255"
                    value="{{ old('email') }}"
                    title="Please enter a valid email address"
                  />
                  <label class="input-floating-label @error('email') text-error @enderror" for="email">Email Address</label>
                </div>
              </div>
              @error('email')
                <div class="text-error text-xs mt-1 pl-8 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                    maxLength="255"
                    minlength="8"
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                    title="Password must be at least 8 characters with uppercase, lowercase, number, and special character"
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
                <div class="text-error text-xs mt-1 pl-8 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                  </svg>
                  <span>{{ $message }}</span>
                </div>
              @enderror
              <div class="text-xs text-base-content/60 mt-2">
                <!-- Password Strength Bar -->
                <div class="password-strength mb-2">
                  <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium">Password strength</span>
                    <span class="text-xs strength-text text-base-content/70">Enter password</span>
                  </div>
                  <div class="flex gap-1 mb-2">
                    <div class="h-1.5 bg-base-300 rounded-full flex-1 strength-bar transition-colors duration-300" data-level="1"></div>
                    <div class="h-1.5 bg-base-300 rounded-full flex-1 strength-bar transition-colors duration-300" data-level="2"></div>
                    <div class="h-1.5 bg-base-300 rounded-full flex-1 strength-bar transition-colors duration-300" data-level="3"></div>
                    <div class="h-1.5 bg-base-300 rounded-full flex-1 strength-bar transition-colors duration-300" data-level="4"></div>
                  </div>
                </div>
                
                <!-- Password Requirements -->
                <ul class="list-none ml-0 text-xs space-y-1">
                  <li class="requirement flex items-center gap-2" data-requirement="length">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>8+ characters</span>
                  </li>
                  <li class="requirement flex items-center gap-2" data-requirement="uppercase">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>Uppercase letter</span>
                  </li>
                  <li class="requirement flex items-center gap-2" data-requirement="lowercase">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>Lowercase letter</span>
                  </li>
                  <li class="requirement flex items-center gap-2" data-requirement="number">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>Number</span>
                  </li>
                  <li class="requirement flex items-center gap-2" data-requirement="special">
                    <span class="requirement-icon text-base-content/40">○</span>
                    <span>Special character</span>
                  </li>
                </ul>
              </div>
            </div>
            <div>
              <div class="input">
                <span class="icon-[tabler--lock-check] text-base-content/80 my-auto size-5 shrink-0"></span>
                <div class="input-floating grow">
                  <input
                    required
                    type="password"
                    placeholder="············"
                    class="ps-3 @error('password_confirmation') border-error @enderror"
                    id="password_confirmation"
                    name="password_confirmation"
                    maxLength="255"
                    minlength="8"
                  />
                  <label class="input-floating-label @error('password_confirmation') text-error @enderror" for="password_confirmation">Confirm Password</label>
                </div>
                <button type="button" data-toggle-password='{ "target": "#password_confirmation" }'
                  class="block cursor-pointer" aria-label="Toggle password confirmation visibility">
                  <span class="icon-[tabler--eye] password-active:block hidden size-5 shrink-0"></span>
                  <span class="icon-[tabler--eye-off] password-active:hidden block size-5 shrink-0"></span>
                </button>
              </div>
              @error('password_confirmation')
                <div class="text-error text-xs mt-1 pl-8 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
              <div class="flex items-center gap-2">
                <input type="checkbox" 
                       class="checkbox checkbox-sm @error('terms') checkbox-error @else checkbox-primary @enderror" 
                       id="policyagreement" 
                       name="terms" 
                       required />
                <label class="label-text p-0 text-sm text-base-content/80" for="policyagreement">
                  I agree to
                  <a href="#" class="link link-animated link-primary font-normal">privacy policy & terms</a>
                </label>
              </div>
              @error('terms')
                <div class="text-error text-xs mt-1 pl-8 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-3 mr-1 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                  </svg>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>
            <button type="submit" class="btn btn-md btn-primary btn-gradient btn-block">Sign Up to Trends</button>
          </form>
          <p class="text-base-content/80 text-center text-sm">
            Already have an account?
            <a href="{{route('login')}}" class="link link-animated link-primary font-normal">Sign in instead</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Avatar Preview Script -->
  <script>
    function previewAvatar(input) {
      const preview = document.getElementById('avatar-image');
      const placeholder = document.getElementById('avatar-placeholder');
      
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
          placeholder.classList.add('hidden');
        };
        
        reader.readAsDataURL(input.files[0]);
      } else {
        // If no file selected, hide preview and show placeholder
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
      }
    }
  </script>
</x-layouts.auth>