<?php



namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AttemptToLogin
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again in 60 seconds.'],
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password . $user->salt, $user->password)) {
            RateLimiter::hit($throttleKey, 60); // Lockout time in seconds
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        RateLimiter::clear($throttleKey);
        Auth::login($user, $request->boolean('remember'));

        return redirect()->intended(config('fortify.home'));
    }
}



// namespace App\Actions\Fortify;

// use App\Models\User;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\ValidationException;

// class AttemptToLogin
// {
//     public function login($request)
//     {
//         $user = User::where('email', $request->email)->first();

//         if (!$user || !Hash::check($request->password . $user->salt, $user->password)) {
//             throw ValidationException::withMessages([
//                 'email' => __('These credentials do not match our records.'),
//             ]);
//         }

//         Auth::login($user, $request->boolean('remember'));

//         return redirect()->intended(config('fortify.home'));
//     }
// }
