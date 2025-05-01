<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController extends Controller
{
    public function show()
    {
        return view('auth.confirm-password');
    }

    public function store(Request $request)
    {
        $request->validate(['password' => ['required']]);

        $user = $request->user();

        $salted = $request->password . $user->salt;

        if (!Hash::check($salted, $user->password)) {
            throw ValidationException::withMessages([
                'password' => __('The provided password was incorrect.'),
            ]);
        }

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(config('fortify.home'));
    }
}
