<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Encomenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Throwable;

class EncomendaController
{
    public function getEncomendas()
    {
        try {
            $confeitaria = Auth::User();

            $encomendas = Encomenda::with(['opcoes', 'cliente', 'estilo'])->where('id_con', $confeitaria->id)->orderBy('id', 'DESC')->get();

            return Inertia::render('encomenda/Encomendas', ['encomendas' => $encomendas]);
        } catch (Throwable $error) {

            return redirect()->route('auth.login');
        }
    }


    public function updateStatus(Request $request)
    {

        try {
            $encomenda = Encomenda::where("id", $request->id)->first();
            if ($encomenda) {
                $encomenda->status = $request->status;
                $encomenda->save();

                return [
                    'success' => [
                        'titulo' => 'Atualizado!',
                    ]
                ];
            } else {
                return [
                    'error' => [
                        'titulo' => 'Pedido não encontrado!'
                    ]
                ];
            }
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

    public function deleteEncomenda(Request $request)
    {
        try {
            $encomenda = Encomenda::where("id", $request->id)->first();
            if ($encomenda) {
                $encomenda->delete();

                return [
                    'success' => [
                        'titulo' => 'Deletado!',
                    ]
                ];
            } else {
                return [
                    'error' => [
                        'titulo' => 'Encomenda não encontrado!'
                    ]
                ];
            }
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

    public function search(Request $request)
    {
        try {
            $confeitaria = Auth::user();
            $encomenda = [];
            $encomenda = Encomenda::with(['opcoes', 'cliente', 'estilo'])->where('code', 'like', "$request->valor%")->where('id_con', $confeitaria->id)->get();
            return $encomenda;
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
}
