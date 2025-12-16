<?php

namespace App\Http\Controllers\Api;

use App\Events\NewPedido;
use App\Models\Cliente;
use App\Models\Confeitaria;
use App\Models\Pedido;
use App\Models\pedido_item;
use App\Models\PedidoItemOpcao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Throwable;

class PedidoController extends Controller
{
    public function setPedido(Request $request)
    {
        try {
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
                // 'data' => "2025/12/12",
                'status' => 'em_progresso'
            ]);


            if ($pedido) {
                $produtos = $request['produtos'];
                foreach ($produtos as $produto) {
                    $pedidoItem = pedido_item::create([
                        'id_pedido' => $pedido->id,
                        'id_produto' => $produto['id'],
                        'quantidade' => $produto['quant']
                    ]);
                    foreach ($produto['opcoes'] ?? [] as $opcao) {
                        if (!isset($opcao['id'])) continue;

                        PedidoItemOpcao::create([
                            'id_pedido_item' => $pedidoItem->id,
                            'id_opcao' => $opcao['id'],
                        ]);
                    }
                }

                broadcast(new NewPedido($pedido));
                return [
                    "infomacoes" => $pedido,
                ];
            } else {
                return [
                    'error' => [
                        'titulo' => 'Erro ao realizar o pedido!',
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
