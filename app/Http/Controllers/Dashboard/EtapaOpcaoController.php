<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Etapa;
use App\Models\EtapaOpcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Throwable;

class EtapaOpcaoController
{
    public function getOpcoes()
    {
        try {

            $opcoes = EtapaOpcao::with('etapa')
                ->whereHas('etapa', function ($query) {

                    $confeitaria = Auth::User();
                    $query->where('id_con', $confeitaria->id);
                })->paginate(10);

            return Inertia::render('encomenda/Opcoes', ['opcoes' => $opcoes->items(), 'paginator' => $opcoes]);
        } catch (Throwable $error) {
            return redirect()->route('auth.login');
        }
    }

    public function getEtapas()
    {
        $confeitaria = Auth::User();

        $etapas = Etapa::where('id_con', $confeitaria->id)->select('id', 'nome')->get();
        return $etapas;
    }

    public function setOpcao(Request $request)
    {
        $data = json_decode($request->data, true);
        $opcao = $data['opcao'];
        try {
            if ($opcao['id'] != 0) {
                $ormOpcao = EtapaOpcao::find($opcao['id']);
                $ormOpcao->nome = $opcao['nome'];
                $ormOpcao->valor = $opcao['valor'];
                $ormOpcao->descricao = $opcao['descricao'];
                $ormOpcao->id_etapa = $opcao['etapa']['id'];
                $ormOpcao->active = $opcao['active'];
                $ormOpcao->save();

                return [
                    'success' => [
                        'titulo' => 'Opção Atualizada!',
                        'code' => 200,
                    ]
                ];
            } else {
                $newOpcao = EtapaOpcao::create([
                    'id_etapa' => $opcao['etapa']['id'],
                    'nome' => $opcao['nome'],
                    'valor' => $opcao['valor'],
                    'descricao' => $opcao['descricao'],
                    'active' => $opcao['active'],
                ]);

                $ormOpcao = EtapaOpcao::with('etapa')->where('id', $newOpcao->id)->first();

                if ($newOpcao) {
                    return [
                        'success' => [
                            'titulo' => 'Opção Criada!',
                            'code' => 200,
                        ],
                        'newopcao' => $ormOpcao
                    ];
                }
            }
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => "Algo deu Errado!",
                    'message' => $error->getMessage()
                ]
            ];
        }
    }



    protected string $valor;
    public function search(Request $request)
    {
        try {
            $opcoes = [];
            if ($request->filtro == "nome") {
                $opcoes = EtapaOpcao::with('etapa')
                    ->whereHas('etapa', function ($query) {

                        $confeitaria = Auth::User();
                        $query->where('id_con', $confeitaria->id);
                    })->where("nome", 'like', "$request->valor%")->get();
                dd($opcoes);
            } else {
                $this->valor = $request->valor;
                $opcoes = EtapaOpcao::with('etapa')
                    ->whereHas('etapa', function ($query) {
                        $confeitaria = Auth::User();
                        $query->where('id_con', $confeitaria->id)->where("nome","like","%$this->valor%");
                    })->get();
            }
            return $opcoes;
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
