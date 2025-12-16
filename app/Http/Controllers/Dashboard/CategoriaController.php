<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CategoriaController extends Controller
{
    public function getCategorias()
    {
        try {
            $categorias = Categoria::all()->select('id', 'id_con', 'titulo');
            return ['categorias' => $categorias];
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

    public function setCategoria(Request $request)
    {

        try {
            $confeitaria = Auth::User();

            if ($request->id != 0) {
                $categoria = Categoria::find($request->id);
                $categoria->titulo = $request->titulo;
                $categoria->save();
                return [
                    'success' => [
                        'titulo' => 'Categoria Ataualizada!'
                    ]
                ];
            } else {
                $categoria = Categoria::create([
                    "id_con" => $confeitaria->id,
                    'titulo' => $request->titulo
                ]);
                return [
                    'success' => [
                        'titulo' => 'Categoria Criada!'
                    ]
                ];
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


    public function deleteCategoria(Request $request)
    {
        try {
            $Categoria = Categoria::find($request->id);
            if ($Categoria != null) {
                $Categoria->delete();
                return [
                    'success' => [
                        'titulo' => 'Deletado!',
                        'message' => "Categoria Deleteado!",
                        'code' => 200,
                    ]
                ];
            } else {
                return [
                    'error' => [
                        'titulo' => 'Algo deu Errado!',
                        'message' => "Categoria não encontrada!",
                        'code' => 404,
                    ]
                ];
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
}
