<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    /**
     * Update user profile settings.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // If password provided, update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile picture upload
        if ($request->hasFile('picture')) {
            // Delete old avatar if it was locally uploaded
            if ($user->picture && !Str::startsWith($user->picture, 'http')) {
                // Remove public/ prefix if stored that way
                $oldPath = str_replace('storage/', '', $user->picture);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('picture');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('avatars', $fileName, 'public');

            // Save public URL path
            $user->picture = 'storage/' . $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
