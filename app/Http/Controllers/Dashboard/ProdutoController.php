<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Opcao;
use App\Models\Produto;
use App\Models\Variacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Throwable;

class ProdutoController extends Controller
{
    public function getVariacao(Request $request)
    {
        $produto = Produto::where("id", $request->id)->first();
        $variacoes = Variacao::select('id', 'titulo', 'id_produto')->where('id_produto', $produto->id)->get();
        $variacoesCollection = [];
        foreach ($variacoes as $variaco) {
            $variacoesCollection[] = [
                'id' => $variaco->id,
                'titulo' => $variaco->titulo,
                'opcoes' => $variaco->opcoes
            ];
        }

        return response()->json(['variacoes' => $variacoesCollection]);
    }

    public function deleteOpcao(Request $request)
    {
        try {
            $opcao = Opcao::find($request->id);
            if ($opcao != null) {
                $opcao->delete();
                return [
                    'success' => [
                        'titulo' => 'Deletada!',
                        'message' => "Opção Deletada!",
                        'code' => 200,
                    ]
                ];
            } else {
                return [
                    'error' => [
                        'titulo' => 'Algo deu Errado!',
                        'message' => "Opção não encontrada!",
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

    public function deleteVariacao(Request $request)
    {
        try {
            $variaco = Variacao::find($request->id);
            if ($variaco != null) {
                $variaco->delete();
                return [
                    'success' => [
                        'titulo' => 'Deletada!',
                        'message' => "Variação Deletada!",
                        'code' => 200,
                    ]
                ];
            } else {
                return [
                    'error' => [
                        'titulo' => 'Algo deu Errado!',
                        'message' => "Variação não encontrada!",
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

    public function deleteProduto(Request $request)
    {
        try {
            $produto = Produto::find($request->id);
            if ($produto != null) {
                $produto->delete();
                return [
                    'success' => [
                        'titulo' => 'Deletado!',
                        'message' => "Produto Deleteado!",
                        'code' => 200,
                    ]
                ];
            } else {
                return [
                    'error' => [
                        'titulo' => 'Algo deu Errado!',
                        'message' => "Produto não encontrada!",
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

    public function setProduto(Request $request)
    {
        $confeitaria = Auth::user();

        // CONFIGURAR A IMAGEM AO RECEBER ELA
        $imagem = ' ';
        if ($request->imagem) {
            $path = Storage::disk('public')->put('produtos', $request->imagem);
            $imagem = basename($path);
        } else {
            $magem = "semImagem.jpg";
        }

        try {
            $data = json_decode($request->data, true);
            $dialogProduto = $data['produto'];
            $variacoes = $data['variacoes'];
            // ATUALIZAR PRODUTO EXISTENTE
            if ($dialogProduto['id'] != 0) {
                $produto = Produto::find($dialogProduto['id']);

                //excluir imagem antiga 
                $imagemAntiga = $produto->getRawOriginal('imagem');
                if ($imagemAntiga && Storage::disk('public')->exists("produtos/" . $imagemAntiga)) {
                    Storage::disk('public')->delete("produtos/" . $imagemAntiga);
                }

                $produto->imagem = $imagem;

                $produto->nome = $dialogProduto['nome'];
                $produto->id_cat =  $dialogProduto['categoria']['id'];
                $produto->descricao = $dialogProduto['descricao'];
                $produto->valor = $dialogProduto['valor'];
                $produto->valor_desc = $dialogProduto['valor_desc'];
                $produto->save();
                // AUTALIZAR VARIACOES
                foreach ($variacoes as $variacao) {
                    if ($variacao['id'] != 0) {
                        $variacaoORM = Variacao::find($variacao['id']);
                        $variacaoORM->id_produto = $produto->id;
                        $variacaoORM->titulo = $variacao['titulo'];
                        $variacaoORM->save();

                        foreach ($variacao['opcoes'] as $opcao) {
                            if ($opcao['id'] != 0) {
                                $opcaoORM = Opcao::find($opcao['id']);
                                $opcaoORM->id_var = $opcao['id_var'];
                                $opcaoORM->nome = $opcao['nome'];
                                $opcaoORM->valor = $opcao['valor'];
                                $opcaoORM->save();
                            } else {
                                $opcaoORM = Opcao::create([
                                    "id_var" => $variacaoORM->id,
                                    "nome" => $opcao['nome'],
                                    "valor" => $opcao['valor'],
                                ]);
                            }
                        }
                    } else {
                        // CRIAR VARIACAO
                        $variacaoORM = Variacao::create([
                            "id_produto" => $produto->id,
                            "titulo" => $variacao['titulo']
                        ]);

                        foreach ($variacao['opcoes'] as $opcao) {
                            if ($opcao['id'] != 0) {
                                // UPDATE
                            } else {
                                $opcaoORM = Opcao::create([
                                    "id_var" => $variacaoORM->id,
                                    "nome" => $opcao['nome'],
                                    "valor" => $opcao['valor'],
                                ]);
                            }
                        }
                    }
                }

                return [
                    'success' => [
                        'titulo' => 'Produto Atualizado!',
                        'message' => "atualizado com sucesso!",
                        'code' => 200,
                    ]
                ];
            } else {
                // CRIAR PRODUTO

                $produto = Produto::create([
                    "nome" =>  $dialogProduto['nome'],
                    "id_con" => $confeitaria->id, // PEGAR O ID COM BASE NA CONFEITARIA LOGADA
                    "id_cat" =>  $dialogProduto['categoria']['id'],
                    "descricao" => $dialogProduto['descricao'],
                    "valor" =>  $dialogProduto['valor'],
                    "valor_desc" =>  $dialogProduto['valor_desc'],
                    "imagem" => $imagem,
                ]);

                foreach ($variacoes as $variacao) {
                    // CRIAR VARIACAO
                    $variacaoORM = Variacao::create([
                        "id_produto" => $produto->id,
                        "titulo" => $variacao['titulo']
                    ]);

                    foreach ($variacao['opcoes'] as $opcao) {
                        if ($opcao['id'] != 0) {
                            // UPDATE
                        } else {
                            $opcaoORM = Opcao::create([
                                "id_var" => $variacaoORM->id,
                                "nome" => $opcao['nome'],
                                "valor" => $opcao['valor'],
                            ]);
                        }
                    }
                }

                return [
                    'success' => [
                        'titulo' => 'Produto Criado!',
                        'message' => "criado com sucesso!",
                        'code' => 200,
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



    public function search(Request $request)
    {
        $confeitaria = Auth::user();

        $produtos = [];
        if ($request->filtro == "nome") {
            $produtos = Produto::with('categoria')->select('id', 'id_con', 'id_cat', 'nome', "descricao", 'imagem', 'valor', 'valor_desc')->where('nome', 'like', "%$request->valor%")->where('id_con',$confeitaria->id)->get();
            return $produtos;
        } else {

            $produtos = Produto::with('categoria')->select('id', 'id_con', 'id_cat', 'nome', "descricao", 'imagem', 'valor', 'valor_desc')->whereHas('categoria', function ($q) use ($request) {
                $q->where('titulo', 'like', "%$request->valor%");
            })->get();
            return $produtos;
        }
    }
}
