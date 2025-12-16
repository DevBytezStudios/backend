<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class CatalogoController
{

    public function dashboard()
    {
        try {
            $confeitaria = Auth::User();
            $data = [
                "totalpedidos" => Pedido::where('id_con', $confeitaria->id)->count(),
                "pedidoshoje" => Pedido::where('id_con', $confeitaria->id)->where('data', today())->where('status','em_progresso')->count(),
                "totalprodutos" => Produto::where('id_con', $confeitaria->id)->count(),
            ];

            $pedidos = Pedido::with(['cliente', 'pedidoItem'])->where('id_con', $confeitaria->id)->orderBy('data', 'DESC')->where('data', today())->where('status','em_progresso')->get()->select('id', 'code', 'pagamento', 'data', 'status', 'produto', 'pedidoItem', 'cliente');
            return Inertia::render('Dashboard', ['confeitaria' => $confeitaria, 'data' => $data, 'pedidos' => $pedidos]);
        } catch (Throwable $error) {
            return redirect()->route('auth.login');
        }
    }

    public function getProdutos(Request $request)
    {
        try {
            $confeitaria = Auth::User();
            $produtos = Produto::with('categoria')->select('id', 'id_con', 'id_cat', 'nome', "descricao", 'imagem', 'valor', 'valor_desc')->where('id_con', $confeitaria->id)->paginate(10); //MEXER NA AUTENTICAÇÂO DEPOIS
            if ($produtos != null) {
                return Inertia::render('catalogo/Produtos', [
                    'produtos' => $produtos->items(),
                    'paginator' => $produtos,
                ]);
            }
        } catch (Throwable $error) {
            dd($error);
        }
    }

    public function getPedidos()
    {
        $confeitaria = Auth::user();
        $pedidos = Pedido::with(['cliente', 'pedidoItem'])->where('id_con', $confeitaria->id)->orderBy('data', 'DESC')->get()->select('id', 'code', 'pagamento', 'data', 'status', 'produto', 'pedidoItem', 'cliente');
        // return $pedidos;
        return Inertia::render("catalogo/Pedidos", ['pedidos' => $pedidos]);
    }

    public function getCategorias()
    {
        $confeitaria = Auth::user();

        $categorias = Categoria::where('id_con', $confeitaria->id)->get()->select('id', 'titulo');
        return Inertia::render("catalogo/Categorias", ['categorias' => $categorias]);
    }
}
