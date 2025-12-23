<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Estilo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Throwable;

class EstiloController
{
    public function getEStilos()
    {
        $confeitaria = Auth::User();
        $estilos = Estilo::where('id_con', $confeitaria->id)->get();

        return Inertia::render('encomenda/Estilos', ['estilos' => $estilos]);
    }


    public function setEstilo(Request $request)
    {
                            $confeitaria = Auth::User();
        try {
            $data = json_decode($request->data);
            $estilo = $data->estilo;
            // CONFIGURAR A IMAGEM AO RECEBER ELA
            $imagem = ' ';
            if ($request->imagem) {
                $path = Storage::disk('public')->put('estilos', $request->imagem);
                $imagem = basename($path);
            } else {
                $magem = "semImagem.jpg";
            }

            if ($estilo->id != 0) {
                $ormEstilo = Estilo::find($estilo->id);
                $ormEstilo->titulo = $estilo->titulo;
                $ormEstilo->descricao = $estilo->descricao;
                $ormEstilo->valor = $estilo->valor;
                $ormEstilo->active = $estilo->active;

                // IMAGEM
                //excluir imagem antiga 
                if ($request->imagem) {
                    if ($imagemAntiga = $ormEstilo->getRawOriginal('imagem')) {
                        if ($imagemAntiga && Storage::disk('public')->exists("estilos/" . $imagemAntiga)) {
                            Storage::disk('public')->delete("estilos/" . $imagemAntiga);
                        }
                        $ormEstilo->imagem = $imagem;
                    }
                }

                $ormEstilo->save();

                return [
                    'success' => [
                        'titulo' => 'Estilo Atualizado!',
                        'message' => "atualizado com sucesso!",
                        'code' => 200,
                    ]
                ];
            } else {
                $newEstilo = Estilo::create([
                    'id_con' => $confeitaria->id,
                    'titulo' => $estilo->titulo,
                    'descricao' => $estilo->descricao,
                    'valor' => $estilo->valor,
                    'imagem' => $imagem,
                    'active' => $estilo->active
                ]);

                return [
                    'success' => [
                        'titulo' => 'Estilo Criado!',
                    ],
                    'estilo' => $newEstilo,
                ];
            }
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => "Algo deu Errado!",
                    'message' => $error->getMessage()
                ]
            ];
        }
    }

    public function delete(Request $request)
    {
        try {
            $estilo = Estilo::find($request->id);
            $estilo->delete();
            return [
                'success' => [
                    'titulo' => 'Estilo Deletado!',
                ],
            ];
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => "Algo deu Errado!",
                    'message' => $error->getMessage()
                ]
            ];
        }
    }
}
