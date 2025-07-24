<x-layouts.app title="Edit Profile">
    <div class="min-h-screen bg-base-200/30 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('profile.show', $user) }}" 
                       class="btn btn-primary hover:btn-primary-focus rounded-full size-12 flex items-center justify-center transition-all duration-200 hover:scale-110 shadow-lg">
                        <span class="icon-[tabler--arrow-left] size-6 text-white"></span>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-base-content">Edit Profile</h1>
                        <p class="text-base-content/60">Update your profile information</p>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-success/10 border border-success/20 rounded-xl text-success">
                    <div class="flex items-center gap-2">
                        <span class="icon-[tabler--check] size-5"></span>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Profile Information Form -->
            <div class="bg-base-100/90 backdrop-blur-sm rounded-2xl shadow-xl border border-base-300/50 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-base-300/50">
                    <h2 class="text-lg font-semibold text-base-content">Profile Information</h2>
                    <p class="text-sm text-base-content/60">Update your account's profile information and email address.</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Banner Upload -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-base-content">Profile Banner</label>
                        <div class="space-y-4">
                            <!-- Current Banner Preview -->
                            <div class="relative group">
                                <div class="w-full h-32 rounded-xl overflow-hidden bg-gradient-to-r from-primary via-primary-focus to-secondary">
                                    @if($user->banner)
                                        <img id="banner-preview" src="{{ $user->banner_url }}" 
                                             alt="Current banner"
                                             class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-105"
                                             loading="eager"
                                             style="background-color: transparent;" />
                                    @else
                                        <div id="banner-preview" class="w-full h-full bg-gradient-to-r from-primary/80 via-primary-focus/70 to-secondary/80 flex items-center justify-center">
                                            <span class="text-primary-content/70 text-sm">No banner set</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Banner Upload Input -->
                            <div>
                                <input type="file" name="banner" id="banner" accept="image/jpeg,image/png,image/jpg" 
                                       onchange="previewImage(this, 'banner-preview')"
                                       class="block w-full text-sm text-base-content file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-content hover:file:bg-primary-focus transition-colors">
                                <p class="text-xs text-base-content/50 mt-1">JPG, PNG up to 5MB. Recommended size: 1500x500 pixels</p>
                                @error('banner')
                                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Avatar Upload -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-base-content">Profile Picture</label>
                        <div class="flex items-center gap-6">
                            <div class="relative group">
                                <div class="size-20 rounded-full overflow-hidden bg-base-200 ring-2 ring-base-300">
                                    <img id="avatar-preview" src="{{ $user->avatar_url }}" 
                                         alt="Current avatar"
                                         class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-110"
                                         loading="eager"
                                         style="background-color: transparent;" />
                                </div>
                                <div class="absolute inset-0 rounded-full bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                    <span class="icon-[tabler--camera] size-6 text-white"></span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/jpg" 
                                       onchange="previewImage(this, 'avatar-preview')"
                                       class="block w-full text-sm text-base-content file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-content hover:file:bg-primary-focus transition-colors">
                                <p class="text-xs text-base-content/50 mt-1">JPG, PNG up to 2MB</p>
                                @error('avatar')
                                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-base-content">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                               class="input input-bordered w-full rounded-xl @error('name') border-error @enderror"
                               placeholder="Your full name">
                        @error('name')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-base-content">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                               class="input input-bordered w-full rounded-xl @error('email') border-error @enderror"
                               placeholder="your@email.com">
                        @error('email')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div class="space-y-2">
                        <label for="bio" class="block text-sm font-medium text-base-content">Bio</label>
                        <textarea name="bio" id="bio" rows="3" 
                                  class="textarea textarea-bordered w-full rounded-xl resize-none @error('bio') border-error @enderror"
                                  placeholder="Tell us about yourself..." 
                                  maxlength="160">{{ old('bio', $user->bio) }}</textarea>
                        <div class="flex justify-between text-xs text-base-content/50">
                            <span>@error('bio'){{ $message }}@enderror</span>
                            <span id="bio-count">{{ strlen(old('bio', $user->bio ?? '')) }}/160</span>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="space-y-2">
                        <label for="location" class="block text-sm font-medium text-base-content">Location</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 icon-[tabler--map-pin] size-4 text-base-content/40"></span>
                            <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}" 
                                   class="input input-bordered w-full rounded-xl pl-10 @error('location') border-error @enderror"
                                   placeholder="Your location">
                        </div>
                        @error('location')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="space-y-2">
                        <label for="website" class="block text-sm font-medium text-base-content">Website</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 icon-[tabler--link] size-4 text-base-content/40"></span>
                            <input type="url" name="website" id="website" value="{{ old('website', $user->website) }}" 
                                   class="input input-bordered w-full rounded-xl pl-10 @error('website') border-error @enderror"
                                   placeholder="https://yourwebsite.com">
                        </div>
                        @error('website')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit" 
                                class="btn btn-primary rounded-xl px-8 py-2 shadow-lg hover:shadow-xl transition-all duration-200">
                            <span class="icon-[tabler--check] size-4 mr-2"></span>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Update Form -->
            <div class="bg-base-100/90 backdrop-blur-sm rounded-2xl shadow-xl border border-base-300/50 overflow-hidden">
                <div class="px-6 py-4 border-b border-base-300/50">
                    <h2 class="text-lg font-semibold text-base-content">Update Password</h2>
                    <p class="text-sm text-base-content/60">Ensure your account is using a long, random password to stay secure.</p>
                </div>

                <form method="POST" action="{{ route('profile.password.update') }}" class="p-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Current Password -->
                    <div class="space-y-2">
                        <label for="current_password" class="block text-sm font-medium text-base-content">Current Password</label>
                        <input type="password" name="current_password" id="current_password" 
                               class="input input-bordered w-full rounded-xl @error('current_password') border-error @enderror"
                               placeholder="Enter your current password">
                        @error('current_password')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-base-content">New Password</label>
                        <input type="password" name="password" id="password" 
                               class="input input-bordered w-full rounded-xl @error('password') border-error @enderror"
                               placeholder="Enter your new password">
                        @error('password')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-base-content">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="input input-bordered w-full rounded-xl"
                               placeholder="Confirm your new password">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit" 
                                class="btn btn-outline rounded-xl px-8 py-2 shadow-lg hover:shadow-xl transition-all duration-200">
                            <span class="icon-[tabler--lock] size-4 mr-2"></span>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Character Counter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bioTextarea = document.getElementById('bio');
            const bioCount = document.getElementById('bio-count');
            
            if (bioTextarea && bioCount) {
                bioTextarea.addEventListener('input', function() {
                    const length = this.value.length;
                    bioCount.textContent = length + '/160';
                    
                    if (length > 160) {
                        bioCount.classList.add('text-error');
                        bioCount.classList.remove('text-base-content/50');
                    } else {
                        bioCount.classList.add('text-base-content/50');
                        bioCount.classList.remove('text-error');
                    }
                });
            }
        });

        // Image preview function
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (previewId === 'banner-preview') {
                        // For banner, create img element if it doesn't exist
                        if (preview.tagName === 'DIV') {
                            preview.innerHTML = `<img src="${e.target.result}" alt="Banner preview" class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-105" />`;
                        } else {
                            preview.src = e.target.result;
                        }
                    } else {
                        // For avatar
                        preview.src = e.target.result;
                    }
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-layouts.app>
