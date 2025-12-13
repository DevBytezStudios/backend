<?php

namespace App\Http\Controllers\Api;

use App\Models\Cliente;
use App\Models\Confeitaria;
use App\Models\Pedido;
use App\Models\pedido_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Throwable;

class PedidoController extends Controller
{
    public function setPedido(Request $request)
    {
        try {;
            $confeitaria = Confeitaria::where('slug', $request->slug)->first();
            $dataCliente = $request['cliente'];
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

            // CRIAR O PEDIDO
            $pedido = Pedido::create([
                'id_con' => $confeitaria->id,
                'id_cliente' => $cliente->id,
                'pagamento' => $request->pagamento,
                'code' => $this->getCode(),
                'data' => now()->toDateString(),
                'status' => 'nenhum'
            ]);


            $produtos = $request['produtos'];
            foreach ($produtos as $produto) {
                foreach ($produto["opcoes"] as $opcao) {
                    pedido_item::create([
                        'id_pedido' => $pedido->id,
                        'id_produto' => $produto['id'],
                        'id_opcao' => $opcao['id'],
                        'quantidade' => $produto['quant']
                    ]);
                }
            }

            return [
                "infomacoes" => $pedido,
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
        } while (Pedido::where('code', $code)->exists());

        return $code;
    }

}
