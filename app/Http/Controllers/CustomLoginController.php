<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Fortify\AttemptToLogin;

class CustomLoginController extends Controller
{
    public function store(Request $request, AttemptToLogin $loginHandler)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return $loginHandler->login($request);
    }
}
