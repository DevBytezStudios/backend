<?php

namespace App\Http\Controllers\API;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ConfeitariaController extends Controller
{
    public function index(Request $request)
    {

        try {
            if ($request->slug == null) {
                return [
                    'error' => 'Slug vazio!',
                    'message' => 'confeitaria não encontrada!',
                    'code' => 404,
                ];
            }
            $confeitaria = DB::table('confeitarias')->select('id', 'nome', 'slug', 'cor_princ', 'cor_sec', 'logo')->where('slug', $request->slug)->first();
            $categorias = DB::table('categorias')->select('id', 'titulo')->get();
            $paginator = Produto::select('id', 'nome', 'imagem', 'valor', 'valor_desc')->where('id_cat', $categorias[0]->id)->where('id_con', $confeitaria->id)->cursorPaginate(10);
            // $paginator = DB::table('produtos')->select('id', 'nome', 'imagem', 'valor', 'valor_desc', 'descricao')->where('id_con', $confeitaria->id)->where('id_cat', $categorias[0]->id)->orderBy('id')->cursorPaginate(10);
            $catalogo = [
                    'confeitaria' => $confeitaria,
                    'categorias' => $categorias,
                    'produtos' => $paginator->items(),
                    'paginator' => [
                        'nextCursor' => $paginator->nextCursor()?->encode(),
                        'hasMore' => $paginator->hasMorePages(),
                ]
            ];

            if ($confeitaria != null) {
                return response()->json($catalogo);
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

    public function getProdutos(Request $request)
    {
        try {
            $confeitaria = DB::table('confeitarias')->select('id')->where('slug', $request->slug)->first();
            $paginator = DB::table('produtos')->select('id', 'nome', 'imagem', 'valor', 'valor_desc', 'descricao')->where('id_con', $confeitaria->id)->where('id_cat', $request->idcat)->orderBy('id')->cursorPaginate(5);

            return [
                'produtos' => $paginator->items(),
                'paginator' => [
                    'nextCursor' => $paginator->nextCursor()?->encode(),
                    'hasMore' => $paginator->hasMorePages(),
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
