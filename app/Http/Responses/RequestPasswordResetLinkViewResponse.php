<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse as RequestPasswordResetLinkViewResponseContract;

class RequestPasswordResetLinkViewResponse implements RequestPasswordResetLinkViewResponseContract
{
    public function toResponse($request)
    {
        return view('auth.passwords.email');
    }
}
