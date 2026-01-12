<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

            return back()->withErrors([
                'titulo' => 'Email ou senha inválidos',
            ]);
        } catch (Throwable $error) {
            return back()->withErrors([
                'titulo' => 'Email ou senha inválidos',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("auth.loginForm");
    }
}
