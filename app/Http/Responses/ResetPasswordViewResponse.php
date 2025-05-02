<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\ResetPasswordViewResponse as ResetPasswordViewResponseContract;

class ResetPasswordViewResponse implements ResetPasswordViewResponseContract
{
    public function toResponse($request)
    {
        return view('auth.passwords.reset', [
            'request' => $request,
            'token' => $request->route('token'),
            'email' => $request->email,
        ]);
    }
}
