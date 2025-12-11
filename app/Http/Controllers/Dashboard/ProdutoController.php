<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Variacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    public function geVariacao(Request $request){
        // $variacao = Variacao::where('id_produto',$request->id)->get();
        $variacao = DB::table('variacaos')->select('id','id_produto','titulo')->where('id_produto',$request->id)->get();
        return response()->json($variacao);
    }
}
