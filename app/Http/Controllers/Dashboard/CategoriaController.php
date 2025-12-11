<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Throwable;

class CategoriaController extends Controller
{
    public function getCategorias()
    {
        try {
            $categorias = Categoria::all()->select('id','id_con','titulo');
            return ['categorias'=>$categorias];
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
