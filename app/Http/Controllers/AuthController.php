<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login (AuthRequest $request): RedirectResponse
    {
        if(
            Auth::attempt(['email' => Hash('sha256', $request->email), 
            'password' => $request->password])
        );

        return redirect('/');
    }

    public function logout (): RedirectResponse {
        Auth::logout();
        return redirect('/');
    }
}
