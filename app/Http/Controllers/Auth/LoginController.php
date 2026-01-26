<?php

namespace App\Http\Controllers\Auth;

use App\Models\Categoria;
use Cocur\Slugify\Slugify;
use App\Models\Confeitaria;
use App\Models\Estilo;
use App\Models\Etapa;
use App\Models\EtapaOpcao;
use App\Models\Opcao;
use App\Models\Produto;
use App\Models\State;
use App\Models\Variacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Throw_;
use Throwable;

class LoginController
{
    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route("dashboard");
            }

            return back()->withErrors([
                'titulo' => 'Email ou senha inválidos',
            ]);
        } catch (Throwable $error) {
            return back()->withErrors([
                'titulo' => $error->getMessage(),
            ]);
        }
    }

    public function register(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $dataConfeitaria = $data['confeitaria'];
            $slugify = new Slugify();
            if (Confeitaria::where('email', $dataConfeitaria['email'])->where('nome', $dataConfeitaria['confeitaria']['nome'])->first() == null) {
                $confeitaria = Confeitaria::create([
                    'email' => $dataConfeitaria['email'],
                    'telefone' => $dataConfeitaria['telefone'],
                    'password' => Hash::make($dataConfeitaria['password']),
                    'nome' =>  $dataConfeitaria['confeitaria']['nome'],
                    'slug' => $slugify->slugify($dataConfeitaria['confeitaria']['nome']),
                    'cor_princ' => $dataConfeitaria['confeitaria']['cor'],
                    'cor_sec' => $dataConfeitaria['confeitaria']['cor_sec'],
                ]);

                State::create([
                    'id_con' => $confeitaria->id,
                ]);
                
                $seeder = $this->seedEncomenda($confeitaria->id);
                $seeder = $this->seedCatalogo($confeitaria->id);
                if ($seeder == true) {
                    return [
                        'success' => [
                            'titulo' => 'Cadastro feito!',
                        ],

                        'confeitaria' => $confeitaria,
                    ];
                } else {
                    return $seeder;
                };
            } else {
                return [
                    'error' => [
                        'titulo' => 'Confeitaria Já Existe!',
                    ]
                ];
            }
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => 'Algo de errado!',
                    'message' => $error->getMessage(),
                ]
            ];
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("auth.loginForm");
    }

    protected function seedEncomenda($idConf)
    {
        // ETAPAS
        $etapasDefault = [
            [
                'id_con' => $idConf,
                'nome' => 'formato',
                'ordem' => 1,
                'required' => true,
                'multiple' => false,
                'icone' => '',
            ],
            [
                'id_con' => $idConf,
                'nome' => 'tamanho',
                'ordem' => 2,
                'required' => true,
                'multiple' => false,
                'icone' => '',
            ],
            [
                'id_con' => $idConf,
                'nome' => 'massa',
                'ordem' => 3,
                'required' => true,
                'multiple' => false,
                'icone' => '',
            ],
            [
                'id_con' => $idConf,
                'nome' => 'recheio',
                'ordem' => 4,
                'required' => true,
                'multiple' => false,
                'icone' => '',
            ],
            [
                'id_con' => $idConf,
                'nome' => 'decoração',
                'ordem' => 5,
                'required' => true,
                'multiple' => true,
                'icone' => '',
            ],
        ];
        // OPCOES
        $opcoesDefault = [
            // FORMATO
            "formato" => [
                [
                    'nome' => 'Redondo',
                    'valor' => 0,
                    'descricao' => 'Formato redondo tradicional',
                    'active' => true,
                ],
                [
                    'nome' => 'Retangular',
                    'valor' => 0,
                    'descricao' => 'Formato retangular',
                    'active' => true,
                ],
            ],

            // TAMANHO
            "tamanho" => [
                [
                    'nome' => 'Pequeno',
                    'valor' => 30,
                    'descricao' => '10 - 12 fatias | 15 cm',
                    'active' => true,
                ],
                [
                    'nome' => 'Médio',
                    'valor' => 50,
                    'descricao' => '15 - 20 fatias | 20 cm',
                    'active' => true,
                ],
                [
                    'nome' => 'Grande',
                    'valor' => 80,
                    'descricao' => '25 - 30 fatias | 25 cm',
                    'active' => true,
                ],
                [
                    'nome' => 'Extra Grande',
                    'valor' => 120,
                    'descricao' => '35 - 40 fatias | 30 cm',
                    'active' => true,
                ],
            ],

            // MASSA
            "massa" => [
                [
                    'nome' => 'Chocolate',
                    'valor' => 0,
                    'descricao' => 'Massa de chocolate tradicional',
                    'active' => true,
                ],
                [
                    'nome' => 'Baunilha',
                    'valor' => 0,
                    'descricao' => 'Massa de baunilha',
                    'active' => true,
                ],
                [
                    'nome' => 'Red Velvet',
                    'valor' => 15,
                    'descricao' => 'Massa red velvet aveludada',
                    'active' => true,
                ],
                [
                    'nome' => 'Cenoura',
                    'valor' => 10,
                    'descricao' => 'Massa de cenoura com chocolate',
                    'active' => true,
                ],
            ],

            // RECHEIO
            "recheio" => [
                [
                    'nome' => 'Brigadeiro',
                    'valor' => 10,
                    'descricao' => 'Brigadeiro tradicional',
                    'active' => true,
                ],
                [
                    'nome' => 'Doce de leite',
                    'valor' => 10,
                    'descricao' => 'Doce de leite cremoso',
                    'active' => true,
                ],
                [
                    'nome' => 'Ninho',
                    'valor' => 12,
                    'descricao' => 'Recheio de leite ninho',
                    'active' => true,
                ],
                [
                    'nome' => 'Ninho com Nutella',
                    'valor' => 18,
                    'descricao' => 'Leite ninho com Nutella',
                    'active' => true,
                ],
                [
                    'nome' => 'Ganache',
                    'valor' => 15,
                    'descricao' => 'Ganache de chocolate meio amargo',
                    'active' => true,
                ],
            ],

            // COBERTURA
            "cobertura" => [
                [
                    'nome' => 'Chantilly',
                    'valor' => 0,
                    'descricao' => 'Cobertura de chantilly tradicional',
                    'active' => true,
                ],
                [
                    'nome' => 'Ganache',
                    'valor' => 15,
                    'descricao' => 'Cobertura de ganache de chocolate',
                    'active' => true,
                ],
                [
                    'nome' => 'Buttercream',
                    'valor' => 20,
                    'descricao' => 'Cobertura de buttercream',
                    'active' => true,
                ],
            ],

            // TOPO / DECORAÇÃO
            "decoração" => [
                [
                    'nome' => 'Topo simples',
                    'valor' => 10,
                    'descricao' => 'Topo decorativo simples',
                    'active' => true,
                ],
                [
                    'nome' => 'Topo personalizado',
                    'valor' => 25,
                    'descricao' => 'Topo personalizado com nome/tema',
                    'active' => true,
                ],
                [
                    'nome' => 'Flores comestíveis',
                    'valor' => 30,
                    'descricao' => 'Decoração com flores comestíveis',
                    'active' => true,
                ],
            ],
        ];

        // ESTILO
        $estilosDefault = [
            [
                'titulo' => 'Clássico',
                'descricao' => 'Acabamento tradicional, ideal para aniversários e comemorações simples',
                'valor' => 0,
                'active' => true,
            ],
            [
                'titulo' => 'Tema Infantil',
                'descricao' => 'Decoração colorida com personagens ou tema escolhido',
                'valor' => 30,
                'active' => true,
            ],
            [
                'titulo' => 'Minimalista',
                'descricao' => 'Decoração clean, cores suaves e acabamento elegante',
                'valor' => 20,
                'active' => true,
            ],
            [
                'titulo' => 'Luxo',
                'descricao' => 'Acabamento premium com detalhes refinados',
                'valor' => 50,
                'active' => true,
            ],
            [
                'titulo' => 'Casamento',
                'descricao' => 'Estilo sofisticado ideal para casamentos e eventos formais',
                'valor' => 80,
                'active' => true,
            ],
        ];

        // PREENCHENDO
        try {
            // ETAPAS E OPCOES
            foreach ($etapasDefault as $etapa) {
                $ormEtapa = Etapa::create(
                    [
                        'id_con' => $idConf,
                        ...$etapa,
                    ]
                );

                foreach ($opcoesDefault[$etapa['nome']] as $opcao) {
                    $ormOpcao = EtapaOpcao::create([
                        'id_etapa' => $ormEtapa->id,
                        ...$opcao,
                    ]);
                }
            }

            // ESTLOS
            foreach ($estilosDefault as $estilo) {
                Estilo::create([
                    'id_con' => $idConf,
                    'titulo' => $estilo['titulo'],
                    'descricao' => $estilo['descricao'],
                    'valor' => $estilo['valor'],
                    'imagem' => 'semImagem.jpg',
                    'active' => $estilo['active'],
                ]);
            }

            return true;
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => 'Algo de errado!',
                    'message' => $error->getMessage(),
                ]
            ];
        }
    }

    protected function seedCatalogo($idConf)
    {
        $categoriasDefault = [
            ['titulo' => 'Docinhos'],
            ['titulo' => 'Salgados'],
            ['titulo' => 'Tortas'],
            ['titulo' => 'Cupcakes'],
        ];

        $produtosDefault = [

            //Brigadeiro Gourmet
            'Docinhos' => [
                [
                    'nome' => 'Brigadeiro Gourmet',
                    'descricao' => 'Brigadeiros artesanais de diversos sabores premium',
                    'valor' => 60.00,
                    'valor_desc' => 0,
                    'imagem' => 'semImagem.jpg',
                    'variacoes' => [
                        [
                            'titulo' => 'Quantidade',
                            'opcoes' => [
                                ['nome' => '30 unidades', 'valor' => -15.00],
                                ['nome' => '50 unidades', 'valor' => 0.00],
                                ['nome' => '100 unidades', 'valor' => 50.00],
                            ]
                        ],
                        [
                            'titulo' => 'Sabores',
                            'opcoes' => [
                                ['nome' => 'Tradicional', 'valor' => 0.00],
                                ['nome' => 'Chocolate Branco', 'valor' => 0.00],
                                ['nome' => 'Nutella', 'valor' => 15.00],
                                ['nome' => 'Pistache', 'valor' => 20.00],
                                ['nome' => 'Maracujá', 'valor' => 5.00],
                                ['nome' => 'Paçoca', 'valor' => 5.00],
                            ]
                        ]
                    ],
                ],
            ],

            // PRODUTO 3: Coxinha
            'Salgados' => [
                [
                    'nome' => 'Coxinha',
                    'descricao' => 'Coxinha crocante com recheios variados',
                    'valor' => 4.50,
                    'valor_desc' => 0,
                    'imagem' => 'semImagem.jpg',
                    'variacoes' => [
                        [
                            'titulo' => 'Recheio',
                            'opcoes' => [
                                ['nome' => 'Frango com Catupiry', 'valor' => 0.00],
                                ['nome' => 'Carne', 'valor' => 0.50],
                                ['nome' => 'Queijo', 'valor' => 1.00],
                            ]
                        ],
                        [
                            'titulo' => 'Tamanho',
                            'opcoes' => [
                                ['nome' => 'Mini', 'valor' => -1.50],
                                ['nome' => 'Tradicional', 'valor' => 0.00],
                                ['nome' => 'Grande', 'valor' => 2.00],
                            ]
                        ],
                    ]
                ],

            ],

            // PRODUTO 4: Torta de Limão
            'Tortas' =>
            [
                [
                    'nome' => 'Torta de Limão',
                    'descricao' => 'Torta crocante com recheio cremoso de limão e merengue',
                    'valor' => 35.00,
                    'valor_desc' => 0,
                    'imagem' => 'semImagem.jpg',
                    'variacoes' => [
                        [
                            'titulo' => 'Tamanho',
                            'opcoes' => [
                                ['nome' => 'Individual', 'valor' => 0.00],
                                ['nome' => 'Média (6-8 fatias)', 'valor' => 25.00],
                                ['nome' => 'Grande (12-15 fatias)', 'valor' => 50.00],
                            ]
                        ],
                    ]
                ],

            ],

            // PRODUTO: Cupcake Red Velvet
            'Cupkakes' =>
            [
                [
                    'nome' => 'Cupcake Red Velvet',
                    'descricao' => 'Cupcake aveludado com frosting de cream cheese',
                    'valor' => 48.00,
                    'valor_desc' => 0,
                    'imagem' => 'semImagem.jpg',
                    'variacoes' => [
                        [
                            'titulo' => 'Quantidade',
                            'opcoes' => [
                                ['nome' => '6 unidades', 'valor' => 0.00],
                                ['nome' => '12 unidades', 'valor' => 42.00],
                                ['nome' => '24 unidades', 'valor' => 78.00],
                            ]
                        ],
                        [
                            'titulo' => 'Decoração',
                            'opcoes' => [
                                ['nome' => 'Simples', 'valor' => 0.00],
                                ['nome' => 'Personalizada', 'valor' => 15.00],
                            ]
                        ],
                    ]
                ],

            ],
        ];

        try {
            //PREENCHENDO OS DADOS
            foreach ($categoriasDefault as $categoria) {
                $cat = Categoria::create([
                    'id_con' => $idConf,
                    ...$categoria
                ]);

                foreach ($produtosDefault[$cat['titulo']] as $produto) {
                    $ormProduto = Produto::create([
                        "id_con" => $idConf,
                        "id_cat" => $cat->id,
                        ...$produto
                    ]);

                    foreach ($produto['variacoes'] as $variacao) {
                        $ormVariacao = Variacao::create([
                            "id_produto" => $ormProduto->id,
                            ...$variacao,
                        ]);

                        foreach ($variacao['opcoes'] as $opcao) {
                            $ormOpcao = Opcao::create([
                                "id_var" => $ormVariacao->id,
                                ...$opcao,
                            ]);
                        }
                    }
                }
            }
            return true;
        } catch (Throwable $error) {
            return [
                'error' => [
                    'titulo' => 'Algo de errado!',
                    'message' => $error->getMessage(),
                ]
            ];
        }
    }
}
