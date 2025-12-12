<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Produto;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class CatalogoProdutosController
{
    public function getProdutos(Request $request)
    {
        try {
            $produtos = Produto::with('categoria')->select('id', 'id_con', 'id_cat', 'nome', "descricao", 'imagem', 'valor', 'valor_desc')->where('id_con', 1)->paginate(10);
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
}
