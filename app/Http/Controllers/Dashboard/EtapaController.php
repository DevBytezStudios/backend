<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Etapa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Throwable;

class EtapaController
{
    public function getEtapas()
    {
        try {
            $confeitaria = Auth::User();
            $etapas = Etapa::where('id_con', $confeitaria->id)->orderBy('ordem', 'ASC')->select('id', 'id_con', 'nome', 'ordem', 'required', 'multiple', 'icone')->get();
            return Inertia::render('encomenda/Etapas', ['etapas' => $etapas]);
        } catch (Throwable $error) {
            return redirect()->route('auth.login');
        }
    }

    public function setEtapa(Request $request)
    {
        $confeitaria = Auth::User();

        try {
            $data = json_decode($request->data, true);
            $etapa = $data['etapa'];
            // ATUALIZA
            if ($etapa['id'] != 0) {
                $etapaModel = Etapa::find($etapa['id']);
                $etapaModel->nome = $etapa['nome'];
                $etapaModel->required = $etapa['required'];
                $etapaModel->multiple = $etapa['multiple'];
                $etapaModel->ordem = $etapa['ordem'];
                $etapaModel->save();
                return [
                    'success' => [
                        'titulo' => 'Etapa Atualizada!',
                        'code' => 200,
                    ]
                ];
            } else {
                // VERIFICA SE EXISTE 
                if (Etapa::where('nome', $etapa["nome"])->exists()) {
                    return [
                        'error' => [
                            'titulo' => 'Etapa já existe!',
                        ]
                    ];
                }
                // CRIA
                $newEtapa = Etapa::create([
                    "id_con" => $confeitaria->id,
                    "nome" => $etapa["nome"],
                    "required" => $etapa["required"],
                    "multiple" => $etapa["multiple"],
                    "ordem" => $etapa["ordem"],
                    "icone" => "" //CONFIGURAR DEPOIS
                ]);

                if ($newEtapa) {
                    return [
                        'success' => [
                            'titulo' => 'Etapa Criada!',
                            'code' => 200,
                        ],
                        'etapa' => $newEtapa,
                    ];
                }
            }
        } catch (Throwable $error) {
            if ($error->getCode() == "23000") {
                return [
                    'error' => [
                        'titulo' => 'Etapa já existe!',
                    ]
                ];
            }
            return [
                'error' => [
                    'titulo' => 'Algo de errado!',
                    'message' => $error->getMessage(),
                    'code' => $error->getCode(),
                ]
            ];
        }
    }


    public function setOrdem(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $atual = $data['atual'];

            $ormAtual = Etapa::find($atual['id']);
            $ormAtual->ordem = $atual['ordem'];

            $anterior = $data['novo'];
            $ormanterior = Etapa::find($anterior['id']);
            $ormanterior->ordem = $anterior['ordem'];

            $ormAtual->save();
            $ormanterior->save();

            return [
                'success' => [
                    'titulo' => 'Ordem Atualizada!',
                    'code' => 200,
                ]
            ];
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

    public function delete(Request $request)
    {
        try {
            $etapa = Etapa::find($request->id);
            $etapa->delete();

            return [
                'success' => [
                    'titulo' => 'Etapa Deletada!',
                ]
            ];
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
