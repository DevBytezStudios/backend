<?php

namespace App\Http\Controllers\Api;

use App\Models\Categoria;
use App\Models\Estilo;
use App\Models\Etapa;
use App\Models\EtapaOpcao;
use App\Models\Produto;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ConfeitariaController extends Controller
{

    public object $confeitaria;
    // CONFIGURAÇÂO PARA O CATALOGO
    public function index(Request $request)
    {
        try {
            if ($request->slug == null) {
                return [
                    'titulo' => 'Confeitaria não encontrada!',
                    'message' => 'Slug Vazio!',
                    'code' => 404,
                ];
            }

            $this->confeitaria = DB::table('confeitarias')->select('id', 'nome', 'slug', 'cor_princ', 'cor_sec', 'logo', 'telefone')->where('slug', $request->slug)->first();


            // VERIFICAR STATE
            $state = State::where('id_con', $this->confeitaria->id)->first();
            if ($state->state == "active") {
                $categorias = DB::table('categorias')->where('id_con', $this->confeitaria->id)->select('id', 'titulo')->get();
                if (count($categorias) > 0) {
                    $paginator = Produto::select('id', 'nome', 'imagem', 'valor', 'valor_desc')->where('id_cat', $categorias[0]->id)->where('id_con', $this->confeitaria->id)->cursorPaginate(10);

                    $catalogo = [
                        'confeitaria' => $this->confeitaria,
                        'categorias' => $categorias,
                        'produtos' => $paginator->items(),
                        'paginator' => [
                            'nextCursor' => $paginator->nextCursor()?->encode(),
                            'hasMore' => $paginator->hasMorePages(),
                        ]
                    ];
                } else {

                    $catalogo = [
                        'confeitaria' => $this->confeitaria,
                        'categorias' => [],
                        'produtos' => [],
                    ];
                }

                if ($this->confeitaria != null) {
                    return response()->json($catalogo);
                }
            } else if ($state->state == "paralyzed") {

                return [

                    'error' => [
                        'titulo' => 'Confeitaria Paralizada!',

                    ]

                ];
            } else if ($state->state == "inactive") {

                return [
                    'error' => [
                        'titulo' => 'Confeitaria Inativa!',
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

    public function getProdutos(Request $request)
    {
        try {

            $this->confeitaria = DB::table('confeitarias')->select('id')->where('slug', $request->slug)->first();

            $paginator = DB::table('produtos')->select('id', 'nome', 'imagem', 'valor', 'valor_desc', 'descricao')->where('id_con', $this->confeitaria->id)->where('id_cat', $request->idcat)->orderBy('id')->cursorPaginate(5);

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


    // CONFIGURAÇÂO PARA ENCOMENDAS
    public function getEtapas(Request $request)
    {
        try {
            // VERIFICAR STATE


            $this->confeitaria = DB::table('confeitarias')->select('id', 'nome', 'slug', 'cor_princ', 'cor_sec', 'logo')->where('slug', $request->slug)->first();

            $state = State::where('id_con', $this->confeitaria->id)->first();
            if ($state->state == "active") {
                if ($request->slug == null) {
                    return [
                        'titulo' => 'Confeitaria não encontrada!',
                        'message' => 'Slug Vazio!',
                        'code' => 404,
                    ];
                }


                // PRAPRANDO OS DADOS
                $etapas = Etapa::where('id_con', $this->confeitaria->id)->select('id', 'id_con', 'nome', 'ordem', 'icone', 'required', 'multiple')->orderby('ordem', 'ASC')->get();

                return [
                    'confeitaria' => $this->confeitaria,
                    'etapas' => $etapas
                ];
            } else if ($state->state == "paralyzed") {

                return [

                    'error' => [
                        'titulo' => 'Confeitaria Paralizada!',

                    ]

                ];
            } else if ($state->state == "inactive") {

                return [
                    'error' => [
                        'titulo' => 'Confeitaria Inativa!',
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

    protected int $idetapa = 0;
    public function getOpcoes(Request $request)
    {

        $this->idetapa = $request->idetapa;
        try {
            if ($request->slug == null) {
                return [
                    'titulo' => 'Confeitaria não encontrada!',
                    'message' => 'Slug Vazio!',
                    'code' => 404,
                ];
            }

            $this->confeitaria = DB::table('confeitarias')->select('id', 'nome', 'slug', 'cor_princ', 'cor_sec', 'logo')->where('slug', $request->slug)->first();

            // PRAPRANDO OS DADOS
            $opcoes = EtapaOpcao::with('etapa')
                ->whereHas('etapa', function ($query) {
                    $query->where('id_con', $this->confeitaria->id)->where('id_etapa', $this->idetapa);
                })->select('id', 'id_etapa', 'nome', 'valor', 'active', 'descricao')->get();

            return [
                'opcoes' => $opcoes
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

    public function getEstilos(Request $request)
    {

        try {
            if ($request->slug == null) {
                return [
                    'titulo' => 'Confeitaria não encontrada!',
                    'message' => 'Slug Vazio!',
                    'code' => 404,
                ];
            }

            $this->confeitaria = DB::table('confeitarias')->select('id')->where('slug', $request->slug)->first();
            $estilos = Estilo::where('id_con', $this->confeitaria->id)->where('active', true)->select('id', 'imagem', 'valor', 'descricao', 'titulo')->get();

            return [
                'estilos' => $estilos
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
