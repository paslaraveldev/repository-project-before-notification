<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Fixed: Removed space
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Department;

class SupervisorProfileController extends Controller
{

        public function show()
    {
        $supervisor = Auth::user();
        return view('supervisor.profile', compact('supervisor'));
    }

    public function edit()
    {
        $supervisor = Auth::user();
        $departments = Department::all();
        return view('supervisor.edit_profile', compact('supervisor', 'departments'));
    }

    public function update(Request $request)
    {
        $supervisor = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $supervisor->id,
            'job_id_number' => 'required|string|max:255|unique:users,job_id_number,' . $supervisor->id,
            'department_id' => 'nullable|exists:departments,id',
            'image' => 'nullable|image|max:8192', // 8MB max
        ]);

        if ($request->hasFile('image')) {
            if ($supervisor->image) {
                Storage::delete('public/images/users/' . $supervisor->image);
            }
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/images/users'), $imageName);
            $validatedData['image'] = $imageName;
        }

        $supervisor->update($validatedData);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}
