<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Confeitaria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ConfeitariaController extends Controller
{
    public function index(Request $request)
    {

        // $confeitaria = Confeitaria::where('slug',$request->slug)->first();
        $confeitaria = DB::table('confeitarias')->select('id', 'nome', 'slug', 'cor_princ', 'cor_sec', 'logo')->where('id', 1)->first();

        $produtos = Produto::with('categoria')->select('id', 'id_con', 'id_cat', 'nome',"descricao", 'imagem', 'valor','valor_desc')->where('id_con', 1)->orderBy('id')->get(10);


        $catalogo = [
            'confeitaria' => $confeitaria,
            'produtos' => $produtos
        ];

        if ($confeitaria != null) {
            return Inertia::render('catalogo/Produtos',[
                'produtos'=> $produtos->toArray(),
            ]);
        }

        return response()->json($catalogo, 404);
    }
}
