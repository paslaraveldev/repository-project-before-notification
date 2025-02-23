<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserProfileController extends Controller
{
    
    /**
     * Show the profile of the logged-in user.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Show the profile settings page.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'image' => 'nullable|image|max:8192', // Allow images up to 8MB
        ]);

        // Get logged-in user
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Handle image upload
        if ($request->hasFile('image')) {
            $filename = 'user_image_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/images/users'), $filename);
            $user->image = $filename;
        }

        $user->save();

        return redirect()->route('userprofile.show')->with('success', 'Profile updated successfully');
    }
}
