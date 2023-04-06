<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    public function login (AuthRequest $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]));

        return redirect('/');
    }

    public function logout () {
        Auth::logout();
        return redirect('/');
    }
}
