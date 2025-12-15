<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class CatalogoController
{
    public function getProdutos(Request $request)
    {
        try {
            $produtos = Produto::with('categoria')->select('id', 'id_con', 'id_cat', 'nome', "descricao", 'imagem', 'valor', 'valor_desc')->where('id_con', 1)->paginate(10); //MEXER NA AUTENTICAÇÂO DEPOIS
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
        $pedidos = Pedido::with(['cliente', 'pedidoItem'])->where('id_con', 1)->orderBy('data', 'DESC')->get()->select('id', 'code', 'pagamento', 'data', 'status', 'produto', 'pedidoItem', 'cliente');
        // return $pedidos;
        return Inertia::render("catalogo/Pedidos", ['pedidos' => $pedidos]);
    }

    public function getCategorias()
    {
        $categorias = Categoria::where('id_con', 1)->get()->select('id','titulo');
        return Inertia::render("catalogo/Categorias", ['categorias' => $categorias]);
    }
}
