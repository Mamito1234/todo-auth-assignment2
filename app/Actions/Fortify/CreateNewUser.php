<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        $salt = bin2hex(random_bytes(8)); // 16-char salt
        $hashedPassword = Hash::make($input['password'] . $salt);

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'salt' => $salt,
            'password' => $hashedPassword,
        ]);
    }

     // public function create(array $input): User
    // {
    //     Validator::make($input, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => [
    //             'required',
    //             'string',
    //             'email',
    //             'max:255',
    //             Rule::unique(User::class),
    //         ],
    //         'password' => $this->passwordRules(),
    //     ])->validate();

    //     // Generate salt
    //     $salt = bin2hex(random_bytes(8)); // 16-char alphanumeric

    //     // Combine password with salt and hash
    //     $hashedPassword = Hash::make($input['password'] . $salt);

    //     // Use fillable-safe mass assignment
    //     return User::create([
    //         'name' => $input['name'],
    //         'email' => $input['email'],
    //         'salt' => $salt,
    //         'password' => $hashedPassword,
    //     ]);
    // }
}
