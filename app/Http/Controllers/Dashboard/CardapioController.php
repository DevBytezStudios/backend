<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Cardapio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CardapioController
{
    // Pegar os produtos do cardapio
    public function cardapioProds(Request $request)
    {
        return Inertia::render('cardapios/CardapioProdutos', ['cardapTitulo' => $request->titulo]);
    }

    public function setCardapio(Request $request)
    {
        $data = json_decode($request->data);
        if ($data->id == 0) {
            $newCardapio = Cardapio::create(
                [
                    'id_con' => Auth::user()->id,
                    'titulo' => $data->titulo,
                    'cor_princ' => $data->cor_princ,
                    'cor_sec' => $data->cor_sec,
                    'dt_inicio' => $data->dt_inicio,
                    'dt_fim' => $data->dt_fim,
                    'active' => $data->active,
                ]
            );

            if($newCardapio){
                return [
                    "success" => [
                        'titulo' => 'Cardápio Criado!',
                        'newcardapio' => $newCardapio,
                    ]
                ];
            }
        }
    }
}
