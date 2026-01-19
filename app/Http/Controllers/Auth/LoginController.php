<?php

namespace App\Http\Controllers\Auth;

use Cocur\Slugify\Slugify;
use App\Models\Confeitaria;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Throw_;
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
                'titulo' => $error->getMessage(),
            ]);
        }
    }

    public function register(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $dataConfeitaria = $data['confeitaria'];
            $slugify = new Slugify();
            if (Confeitaria::where('email', $dataConfeitaria['email'])->where('nome', $dataConfeitaria['confeitaria']['nome'])->first() == null) {
                $confeitaria = Confeitaria::create([
                    'email' => $dataConfeitaria['email'],
                    'password' => Hash::make($dataConfeitaria['password']),
                    'nome' =>  $dataConfeitaria['confeitaria']['nome'],
                    'slug' => $slugify->slugify($dataConfeitaria['confeitaria']['nome']),
                    'cor_princ' => $dataConfeitaria['confeitaria']['cor'],
                    'cor_sec' => $dataConfeitaria['confeitaria']['cor_sec'],
                ]);

                State::create([
                    'id_con' => $confeitaria->id,
                ]);

                return [
                    'success' => [
                        'titulo' => 'Cadastro feito!',
                    ],
                    'confeitaria' => $confeitaria,
                ];
            } else {
                return [
                    'error' => [
                        'titulo' => 'Confeitaria Já Existe!',
                    ]
                ];
            }
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => 'Algo de errado!',
                    'message' => $error->getMessage(),
                ]
            ];
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("auth.loginForm");
    }
}
