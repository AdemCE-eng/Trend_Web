<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    function create()
    {
        return view("register.create");
    }
    function store(RegisterRequest $request)
    {
        // Create user without avatar first
        $validatedData = $request->validated();
        unset($validatedData['avatar']);
        
        $user = User::create($validatedData);

        // Handle avatar upload if present
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            
            // Security: Validate MIME type server-side
            $allowedMimes = ['image/jpeg', 'image/png'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return back()->withErrors(['avatar' => 'Invalid file type detected.']);
            }
            
            // Security: Use predefined extension based on MIME type
            $mimeToExtension = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png'
            ];
            $extension = $mimeToExtension[$file->getMimeType()];
            
            // Security: Generate secure filename
            $filename = $user->id . '_' . uniqid() . '_' . time() . '.' . $extension;
            
            $path = Storage::disk('public')->putFileAs(
                'avatars',
                $file,
                $filename
            );
            
            $user->avatar = $path;
            $user->save();
        }

        Auth::login($user, true);
        return redirect()->route('home');
    }
}

