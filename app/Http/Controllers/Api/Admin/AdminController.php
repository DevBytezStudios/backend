<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Confeitaria;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AdminController
{
    public function getConfeitarias(Request $request)
    {
        try {
            $confeitarias = Confeitaria::with([
                'state'
            ])->select('id', 'email', 'slug', 'nome', 'logo')->get();
            return $confeitarias;
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => 'Algo de errado!',
                    'message' => $error->getMessage(),
                    'code' => $error->getCode(),
                ]
            ];
        }
    }

    public function setConfeitaria(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $dataConfeitaria = $data['confeitaria'];
            if ($dataConfeitaria['id'] != 0) {
                $state = State::where('id_con', $dataConfeitaria['id'])->first();
                $state->state = $dataConfeitaria['state']['state'];
                $confeitaria = Confeitaria::find($dataConfeitaria['id']);
                $confeitaria->nome = $dataConfeitaria['nome'];
                $confeitaria->slug = $dataConfeitaria['slug'];
                $confeitaria->email = $dataConfeitaria['email'];
                if ($dataConfeitaria['password'] != "" || !empty($dataConfeitaria['password'])) {
                    $confeitaria->password = Hash::make($dataConfeitaria['password']);
                }
                $state->save();
                $confeitaria->save();

                return [
                    'success' => [
                        'titulo' => 'Confeitaria modificada!',
                    ]
                ];
            } else {
                $confeitaria = Confeitaria::create([
                    "nome" => $dataConfeitaria['nome'],
                    "slug" => $dataConfeitaria['slug'],
                    "email" => $dataConfeitaria['email'],
                    "password" => Hash::make($dataConfeitaria['password'])
                ]);

                $state = State::create([
                    'id_con' => $confeitaria->id,
                    'state' => $dataConfeitaria['state']['state']
                ]);

                if ($confeitaria) {
                    return [
                        'success' => [
                            'titulo' => 'Confeitaria Adicionada!',
                        ]
                    ];
                }
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


    public function deleteConfeitaria(Request $request)
    {
        try {
            $confeitaria = Confeitaria::find($request->id);
            $confeitaria->delete();
            return [
                'success' => [
                    'titulo' => 'Confeitaria Deleteada!',
                ]
            ];
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => 'Algo de errado!',
                    'message' => $error->getMessage(),
                ]
            ];
        }
    }
}
