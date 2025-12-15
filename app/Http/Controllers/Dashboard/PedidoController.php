<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Cliente;
use App\Models\Confeitaria;
use App\Models\Pedido;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Throwable;

class PedidoController extends Controller
{
    public function setStatus(Request $request)
    {
        try {
            $pedido = Pedido::where("id", $request->id)->first();
            if ($pedido) {
                $pedido->status = $request->status;
                $pedido->save();

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

    public function deletePedido(Request $request)
    {
        try {
            $pedido = Pedido::where("id", $request->id)->first();
            if ($pedido) {
                $pedido->delete();

                return [
                    'success' => [
                        'titulo' => 'Deletado!',
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

    public function search(Request $request)
    {
        try {

            $pedidos = [];
            $pedidos = Pedido::with(['cliente', 'pedidoItem'])->where('code', 'like', "$request->valor%")->get()->select('id', 'code', 'pagamento', 'data', 'status', 'produto', 'pedidoItem', 'cliente');;
            return $pedidos;
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
