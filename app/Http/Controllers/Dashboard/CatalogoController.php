<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Categoria;
use App\Models\Encomenda;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class CatalogoController
{

    public function dashboard()
    {
        $confeitaria = Auth::User();

        // $entregashoje = Pedido::where('id_con', $confeitaria->id)->where('data', today())->count() + Encomenda::where('id_con', $confeitaria->id)->where('data_entrega', today())->count();
        // $proximasentregas = Pedido::where('id_con', $confeitaria->id)->where('data', now()->addDays(5))->count() + Encomenda::where('id_con', $confeitaria->id)->where('data_entrega', now()->addDays(5))->count();

        try {
            // $data = [
            //     "entregasHoje" => $entregashoje,
            //     "proximasEntregas" => $proximasentregas,
            //     "produtosTotais" => 0,
            // ];

            $pedidos = Pedido::with(['cliente', 'pedidoItem'])->where('id_con', $confeitaria->id)->orderBy('data', 'DESC')->where('data', today())->where('status', 'em_progresso')->get()->select('id', 'code', 'pagamento', 'data', 'status', 'produto', 'pedidoItem', 'cliente');

            $encomendas = Encomenda::with(['opcoes', 'cliente', 'estilo'])->where("data_entrega", ">", now())->where('id_con', $confeitaria->id)->get();

            // return Inertia::render('Dashboard', ['confeitaria' => $confeitaria, 'data' => $data, 'pedidos' => $pedidos, "encomendas" => $encomendas]);
            return Inertia::render('Dashboard', [ "encomendas" => $encomendas]);
        } catch (Throwable $error) {
            dd("ERRO $error");
            return redirect()->route('auth.login');
        }
    }

    public function getProdutos(Request $request)
    {
        try {
            $confeitaria = Auth::User();

        } catch (Throwable $error) {
            report($error);
            abort(500);
        }
    }

    public function getPedidos()
    {
        $confeitaria = Auth::user();
        if ($confeitaria) {
            $pedidos = Pedido::with(['cliente', 'pedidoItem'])->where('id_con', $confeitaria->id)->orderBy('data', 'DESC')->get()->select('id', 'code', 'pagamento', 'data', 'status', 'produto', 'pedidoItem', 'cliente');
            // return $pedidos;
            return Inertia::render("catalogo/Pedidos", ['pedidos' => $pedidos]);
        } else {
            return redirect()->route('auth.login');
        }
    }

    public function getCategorias()
    {
        $confeitaria = Auth::user();

        $categorias = Categoria::where('id_con', $confeitaria->id)->get()->select('id', 'titulo');
        return Inertia::render("catalogo/Categorias", ['categorias' => $categorias]);
    }
}
