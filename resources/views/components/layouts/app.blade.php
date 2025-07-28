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

@php
    // Set default page title if not provided
    $pageTitle = $title ?? 'Home';
@endphp

<x-layouts.default :title="$pageTitle">
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
        {{--
        <li>
        <a class="dropdown-item rounded-lg p-3 hover:bg-base-200/80 transition-all duration-200 flex items-center gap-3" href="#">
          <span class="icon-[tabler--help-triangle] text-primary"></span>
          <span class="font-medium">Help & Support</span>
        </a>
        </li>
        --}}
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
    <form method="post" action="{{ route('tweet.create') }}" enctype="multipart/form-data">
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
            @error('image')
              <div class="text-error text-sm mt-1">
                <span class="icon-[tabler--alert-circle] mr-1"></span>
                {{ $message }}
              </div>
            @enderror
          </div>
          
          <!-- Image Preview -->
          <div id="imagePreview" class="hidden">
            <div class="relative" style="min-height: 12rem;">
              <img id="previewImg" src="" alt="Image preview" class="max-w-full h-48 object-cover rounded-lg border border-base-200">
              <button type="button" id="removeImage" style="top: 0.5rem; right: 0.5rem; z-index: 20;" class="absolute w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg transition-all duration-200">
                <span class="icon-[tabler--x] text-lg font-bold"></span>
              </button>
            </div>
            <div id="fileInfo" class="text-xs text-base-content/60 mt-1 hidden"></div>
          </div>
          
          <div class="flex justify-between items-center">
            <div class="flex items-center gap-2 text-base-content/50">
              <!-- Photo Upload Button -->
              <label for="imageUpload" class="icon-[tabler--photo] text-lg cursor-pointer hover:text-primary transition-colors" title="Add photo (max 10MB)">
              </label>
              <input type="file" id="imageUpload" name="image" accept="image/*" class="hidden">
              
              <!-- Emoji Button -->
              <button type="button" id="emojiBtn" class="icon-[tabler--mood-smile] text-lg cursor-pointer hover:text-primary transition-colors" title="Add emoji">
              </button>
              
              <!-- Location Button -->
              <button type="button" id="locationBtn" class="icon-[tabler--map-pin] text-lg cursor-pointer hover:text-primary transition-colors" title="Add location">
              </button>
            </div>
            <div class="flex items-center gap-3">
              <span id="charCounter" class="text-sm text-base-content/50">0/10000</span>
              <button type="submit" class="btn btn-primary btn-sm px-6 hover:btn-primary-focus transition-all duration-200" onclick="return validateSubmission()">
                <span class="icon-[tabler--send] mr-1"></span>
                Tweet
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- JavaScript for tweet composer functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const textarea = document.getElementById('textareaFloating');
      const charCounter = document.getElementById('charCounter');
      const imageUpload = document.getElementById('imageUpload');
      const imagePreview = document.getElementById('imagePreview');
      const previewImg = document.getElementById('previewImg');
      const removeImageBtn = document.getElementById('removeImage');
      const emojiBtn = document.getElementById('emojiBtn');
      const locationBtn = document.getElementById('locationBtn');

      // Character counter
      textarea.addEventListener('input', function() {
        const count = this.value.length;
        charCounter.textContent = `${count}/10000`;
        
        if (count > 9000) {
          charCounter.classList.add('text-warning');
        } else if (count > 9500) {
          charCounter.classList.add('text-error');
        } else {
          charCounter.classList.remove('text-warning', 'text-error');
        }
      });

      // Image upload preview
      imageUpload.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
          // Check file size (10MB = 10 * 1024 * 1024 bytes)
          const maxSize = 10 * 1024 * 1024; // 10MB in bytes
          
          // Check file type first
          const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
          if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, GIF, or WebP).');
            this.value = ''; // Clear the input
            return;
          }

          if (file.size > maxSize) {
            const fileSizeMB = (file.size / 1024 / 1024).toFixed(1);
            alert(`File size (${fileSizeMB}MB) exceeds the 10MB limit. Please choose a smaller image.`);
            this.value = ''; // Clear the input
            return;
          }

          displayImagePreview(file);
        }
      });

      // Function to display image preview
      function displayImagePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          previewImg.src = e.target.result;
          imagePreview.classList.remove('hidden');
          
          // Show file info
          const fileInfo = document.getElementById('fileInfo');
          if (fileInfo) {
            fileInfo.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(1)} MB)`;
            fileInfo.classList.remove('hidden');
          }
        };
        reader.readAsDataURL(file);
      }

      // Function to create file info element (no longer needed but kept for compatibility)
      function createFileInfo() {
        return document.getElementById('fileInfo');
      }

      // Remove image
      removeImageBtn.addEventListener('click', function() {
        imageUpload.value = '';
        imagePreview.classList.add('hidden');
        previewImg.src = '';
        
        // Hide file info
        const fileInfo = document.getElementById('fileInfo');
        if (fileInfo) {
          fileInfo.classList.add('hidden');
          fileInfo.textContent = '';
        }
      });

      // Emoji button (basic emoji insertion)
      emojiBtn.addEventListener('click', function() {
        // Create emoji picker dropdown
        const existingPicker = document.getElementById('emojiPicker');
        if (existingPicker) {
          existingPicker.remove();
          return;
        }

        const emojiPicker = document.createElement('div');
        emojiPicker.id = 'emojiPicker';
        emojiPicker.className = 'absolute bottom-12 left-0 bg-base-100 border border-base-200 rounded-lg shadow-lg p-3 z-50 max-w-xs';
        emojiPicker.innerHTML = `
          <div class="grid grid-cols-8 gap-1">
            ${['😀', '😂', '🥰', '😍', '🤔', '😭', '🥺', '😤', '🤯', '🥳', '😴', '🤤', '🤢', '🤮', '🤧', '😇', '🤠', '🥸', '🤡', '🥶', '🥵', '😱', '🤗', '🤫', '🤭', '🫡', '🤨', '😐', '😑', '🫤', '😔', '😟', '😕', '🙁', '☹️', '😖', '😫', '😩', '🥺', '😢', '😥', '😪', '😓', '😰', '😨', '😧', '😦', '😮', '😯', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐', '🥴', '🤢', '🤮', '🤧', '🤒', '🤕'].map(emoji => 
              `<button type="button" class="hover:bg-base-200 p-1 rounded text-lg" onclick="insertEmoji('${emoji}')">${emoji}</button>`
            ).join('')}
          </div>
        `;
        this.parentElement.appendChild(emojiPicker);

        // Close picker when clicking outside
        setTimeout(() => {
          document.addEventListener('click', function closeEmojiPicker(e) {
            if (!emojiPicker.contains(e.target) && e.target !== emojiBtn) {
              emojiPicker.remove();
              document.removeEventListener('click', closeEmojiPicker);
            }
          });
        }, 100);
      });

      // Function to insert emoji
      window.insertEmoji = function(emoji) {
        const cursorPos = textarea.selectionStart;
        const textBefore = textarea.value.substring(0, cursorPos);
        const textAfter = textarea.value.substring(cursorPos);
        
        textarea.value = textBefore + emoji + textAfter;
        textarea.focus();
        textarea.setSelectionRange(cursorPos + emoji.length, cursorPos + emoji.length);
        
        // Trigger input event to update character counter
        textarea.dispatchEvent(new Event('input'));
        
        // Close emoji picker
        document.getElementById('emojiPicker')?.remove();
      };

      // Function to validate form submission
      window.validateSubmission = function() {
        const content = textarea.value.trim();
        const hasImage = imageUpload.files.length > 0;
        
        if (!content && !hasImage) {
          alert('Please enter some text or select an image to tweet.');
          return false;
        }
        
        if (hasImage) {
          const file = imageUpload.files[0];
          const maxSize = 10 * 1024 * 1024; // 10MB
          
          if (file.size > maxSize) {
            alert(`Image file is too large (${(file.size / 1024 / 1024).toFixed(1)}MB). Please choose a smaller image (max 10MB).`);
            return false;
          }
        }
        
        return true;
      };

      // Location button (simple location text insertion)
      locationBtn.addEventListener('click', function() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            const locationText = ` 📍 Location: ${position.coords.latitude.toFixed(4)}, ${position.coords.longitude.toFixed(4)}`;
            
            const cursorPos = textarea.selectionStart;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos);
            
            textarea.value = textBefore + locationText + textAfter;
            textarea.focus();
            textarea.setSelectionRange(cursorPos + locationText.length, cursorPos + locationText.length);
            
            // Trigger input event to update character counter
            textarea.dispatchEvent(new Event('input'));
          }, function() {
            alert('Location access denied or unavailable');
          });
        } else {
          alert('Geolocation is not supported by this browser');
        }
      });
    });
  </script>
  @endif
</x-layouts.default>