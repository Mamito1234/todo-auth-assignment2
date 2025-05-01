<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\ConfirmPasswordViewResponse as ConfirmPasswordViewResponseContract;

class ConfirmPasswordViewResponse implements ConfirmPasswordViewResponseContract
{
    public function toResponse($request)
    {
        return view('auth.confirm-password');
    }
}
