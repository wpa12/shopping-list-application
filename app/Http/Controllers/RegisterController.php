<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(RegisterUserRequest $request, User $user)
    {
        $user->create([
            'name'      => encrypt($request->register_name),
            'email'     => Hash('sha256', $request->register_email_address),
            'password'  => bcrypt($request->register_password),
        ]);

        return redirect('/')->with(['success' => 'Your account has been created successfully! Please login.']);
    }
}
