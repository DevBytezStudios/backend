<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Throwable;

class LoginController
{
    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->route("dashboard");
            }
        } catch (Throwable $error) {
            return back()->withErrors([
                'email' => 'Email ou senha inválidos',
            ]); 
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route("auth.loginForm");
    }
}
