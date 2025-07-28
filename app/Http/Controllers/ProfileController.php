<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(User $user)
    {
        $tweets = $user->tweets()
            ->with(['user', 'replies.user'])
            ->latest()
            ->paginate(10);

        $stats = [
            'tweets_count' => $user->tweets()->count(),
            'following_count' => $user->following()->count(),
            'followers_count' => $user->followers()->count(),
        ];

        $activeTab = request('tab', 'tweets');

        if ($activeTab === 'tweets') {
            $tweets = $user->tweets()->latest()->paginate(10);
        } elseif ($activeTab === 'replies') {
            $tweets = $user->tweets()->whereNotNull('parent_tweet_id')->latest()->paginate(10);
        } elseif ($activeTab === 'media') {
            $tweets = $user->tweets()->whereNotNull('image_path')->latest()->paginate(10);
        } elseif ($activeTab === 'likes') {
            $tweets = $user->likedTweets()->latest()->paginate(10);
        }

        return view('profile.show', compact('user', 'tweets', 'stats', 'activeTab'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        return view('profile.edit', data: ['user' => Auth::user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $user->getKey()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->getKey()],
            'bio' => ['nullable', 'string', 'max:160'],
            'location' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'], // 5MB for banner
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatar = $request->file('avatar');

            // Security: Validate MIME type server-side (no GIF support)
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($avatar->getMimeType(), $allowedMimes)) {
                return back()->withErrors(['avatar' => 'Invalid file type detected. Only JPG and PNG files are allowed.']);
            }

            // Delete old avatar if exists
            $oldAvatar = $user->getAttribute('avatar');
            if (!empty($oldAvatar) && Storage::disk('public')->exists($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }

            // Security: Use predefined extension based on MIME type
            $mimeToExtension = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png'
            ];
            $extension = $mimeToExtension[$avatar->getMimeType()];

            // Security: Generate secure filename like registration
            $filename = $user->getKey() . '_' . uniqid() . '_' . time() . '.' . $extension;

            $path = Storage::disk('public')->putFileAs(
                'avatars',
                $avatar,
                $filename
            );

            if ($path) {
                $validated['avatar'] = $path;
            }
        }

        // Handle banner upload
        if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
            $banner = $request->file('banner');

            // Security: Validate MIME type server-side (no GIF support)
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($banner->getMimeType(), $allowedMimes)) {
                return back()->withErrors(['banner' => 'Invalid file type detected. Only JPG and PNG files are allowed.']);
            }

            // Delete old banner if exists
            $oldBanner = $user->getAttribute('banner');
            if (!empty($oldBanner) && Storage::disk('public')->exists($oldBanner)) {
                Storage::disk('public')->delete($oldBanner);
            }

            // Security: Use predefined extension based on MIME type
            $mimeToExtension = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png'
            ];
            $extension = $mimeToExtension[$banner->getMimeType()];

            // Security: Generate secure filename like registration
            $filename = $user->getKey() . '_' . uniqid() . '_' . time() . '.' . $extension;

            $path = Storage::disk('public')->putFileAs(
                'banners',
                $banner,
                $filename
            );

            if ($path) {
                $validated['banner'] = $path;
            }
        }

        $user->update($validated);

        return redirect()->route('profile.show', $user)
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'string',
                'max:255',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
        ], [
            'current_password.required' => 'Current password is required.',
            'current_password.current_password' => 'The current password is incorrect.',
            'password.required' => 'New password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password cannot exceed 255 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
