<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterViewResponse as RegisterViewResponseContract;

class RegisterViewResponse implements RegisterViewResponseContract
{
    public function toResponse($request)
    {
        return view('auth.register');
    }
}
