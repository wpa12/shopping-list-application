<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function login (AuthRequest $request): RedirectResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]));

        return redirect('/');
    }

    public function logout (): RedirectResponse {
        Auth::logout();
        return redirect('/');
    }
}
