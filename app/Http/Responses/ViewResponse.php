<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginViewResponse as LoginContract;
use Laravel\Fortify\Contracts\RegisterViewResponse as RegisterContract;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse as VerifyContract;

class ViewResponse implements LoginContract, RegisterContract, VerifyContract
{
    protected string $view;

    public function __construct(string $view)
    {
        $this->view = $view;
    }

    public function toResponse($request)
    {
        return response()->view($this->view);
    }
}
