<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Illuminate\Validation\ValidationException;

class ResetUserPassword implements ResetsUserPasswords
{
    public function reset($user, array $input)
    {
        Validator::make($input, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        // Generate a new salt
        $salt = bin2hex(random_bytes(16));

        $user->forceFill([
            'password' => Hash::make($input['password'] . $salt),
            'salt' => $salt,
        ])->save();
    }
}






// namespace App\Actions\Fortify;

// use App\Models\User;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
// use Laravel\Fortify\Contracts\ResetsUserPasswords;

// class ResetUserPassword implements ResetsUserPasswords
// {
//     use PasswordValidationRules;

//     /**
//      * Validate and reset the user's forgotten password.
//      *
//      * @param  array<string, string>  $input
//      */
//     public function reset(User $user, array $input): void
//     {
//         Validator::make($input, [
//             'password' => $this->passwordRules(),
//         ])->validate();

//         $user->forceFill([
//             'password' => Hash::make($input['password']),
//         ])->save();
//     }
// }
