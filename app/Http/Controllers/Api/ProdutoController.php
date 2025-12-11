<?php

namespace App\Http\Controllers\API;

use App\Models\Confeitaria;
use App\Models\Produto;
use App\Models\Variacao;
use Illuminate\Http\Request;
use Throwable;

class ProdutoController extends Controller
{
    public function getProduto(Request $request)
    {
        try {
            $confeitaria = Confeitaria::where('slug', $request->slug)->first();
            $produto = Produto::select('id', 'nome', 'imagem', 'valor', 'valor_desc', 'descricao')->where('id', $request->idproduto)->where('id_con', $confeitaria->id)->first();
            $variacoes = Variacao::select('id', 'titulo')->where('id_produto', $produto->id)->get();
            $variacoesCollection = [];

            foreach ($variacoes as $variaco) {
                $variacoesCollection[] = [
                    'titulo' => $variaco->titulo,
                    'opoes' => $variaco->opcoes
                ];
            }
            return [
                'produto' => $produto,
                'variacoes' => $variacoesCollection
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
