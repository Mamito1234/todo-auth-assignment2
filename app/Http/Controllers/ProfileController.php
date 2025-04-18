<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class ProfileController extends Controller
// {
//     //
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nickname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
            // $avatarPath = $request->file('avatar')->store('avatars', 'public');
            // $user->avatar = $avatarPath;
        }

        // if (!empty($validated['password'])) {
        //     $user->password = Hash::make($validated['password']);
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // Don't update password if it's empty
        }

        // $user->fill($validated)->save();
        // }

        $user->fill($validated)->save();

        return back()->with('success', 'Profile updated.');
    }

    public function destroy()
    {
        Auth::user()->delete();
        return redirect('/')->with('success', 'Account deleted.');
    }
}
