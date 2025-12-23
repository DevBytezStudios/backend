<?php

namespace App\Http\Controllers\Api;

use App\Models\Cliente;
use App\Models\Confeitaria;
use App\Models\Encomenda;
use App\Models\Encomenda_Opcao;
use App\Models\EncomendaOpcao;
use App\Models\Etapa;
use App\Models\EtapaOpcao;
use App\Models\Opcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class EncomendaController extends Controller
{
    public function setEncomenda(Request $request)
    {
        try {
            $dataCliente = $request->cliente;
            $pagamento = $request->pagamento;
            $etapas = $request->etapas;
            $estilo = $request->estilo;
            $observacao = $request->observacoes;
            $data_entrega = $request->data_entrega;
            $confeitaria = DB::table('confeitarias')->select('id')->where('slug', $request->slug)->first();

            $cliente = Cliente::select('id', 'nome', 'telefone', 'cep')->where('telefone', $dataCliente['telefone'])->where('nome', $dataCliente['nome'])->where('cep', $dataCliente['cep'])->first();
            if ($cliente == null) {
                $cliente = Cliente::create([
                    'nome'        => $dataCliente['nome'],
                    'telefone'    => $dataCliente['telefone'],
                    'cep'         => $dataCliente['cep'],
                    'rua'         => $dataCliente['rua'],
                    'numero'      => $dataCliente['numero'],
                    'complemento' => $dataCliente['complemento'],
                    'bairro'      => $dataCliente['bairro'],
                    'cidade'      => $dataCliente['cidade'],
                ]);
            }
            if ($confeitaria != null) {
                $encomenda = Encomenda::create([
                    "id_con" => $confeitaria->id,
                    "id_cliente" => $cliente->id,
                    "id_estilo" => $estilo['id'],
                    "pagamento" => $pagamento,
                    "code" => $this->getCode(),
                    "data_entrega" => date($data_entrega),
                    "observacao" => $observacao,
                    "status" => "em_progresso"
                ]);

                foreach ($etapas as $etapa) {
                    $dataEtapa = Etapa::find($etapa["id"]);
                    foreach ($etapa['opcoes'] as $opcao) {
                        $dataOpcao = EtapaOpcao::find($opcao['id']);
                        $encomendaOpcao = EncomendaOpcao::create([
                            "id_encomenda" => $encomenda->id,
                            "etapa" => $dataEtapa->nome,
                            "nome" => $dataOpcao->nome,
                            "valor" => $dataOpcao->valor,
                        ]);
                    }
                }

                return $encomenda;
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

    protected function getCode()
    {
        $code = "";
        do {
            $letras = '';
            $numeros = '';

            // gerar letras
            for ($i = 0; $i < 3; $i++) {
                $letras .= chr(rand(65, 90)); // A-Z
            }

            // gerar números
            for ($i = 0; $i < 3; $i++) {
                $numeros .= rand(0, 9);
            }

            $code = $letras . $numeros;
        } while (Encomenda::where('code', $code)->exists());

        return $code;
    }
}
