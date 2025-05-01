<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\AttemptToAuthenticate;
use Laravel\Fortify\Fortify;

class CustomAttemptToAuthenticate implements AttemptToAuthenticate
{
    public function __invoke(Request $request)
    {
        $user = User::where(Fortify::username(), $request->input(Fortify::username()))->first();

        if (! $user || ! Hash::check($request->password . $user->salt, $user->password)) {
            return false;
        }

        auth()->login($user, $request->boolean('remember'));

        return app(RedirectIfTwoFactorAuthenticatable::class)($request);
    }
}
