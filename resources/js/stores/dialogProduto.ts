import { Produto, Variacao } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface ProdutoState {
    produto: Produto;
    variacoes: Variacao[];
}

const useDialogProduto = defineStore('dialogProduto', {
    state: (): ProdutoState => ({
        produto: {
            id: 0,
            nome: '',
            descricao: '',
            categoria: '',
            valor: 0,
            valorDesc: 0,
            imagem: '',
        },
        variacoes: [
            {
                id: 0,
                titulo: '',
                opcoes: [
                    {
                        id: 0,
                        titulo: '',
                        valor: 0,
                    },
                ],
            },
        ],
    }),
    actions: {
        editProduto() {},
        async getVariacao() {
            console.log(this.produto);
            if (this.produto.id != 0) {
                const respose = await axios.post('/api/produto/getvariacao', {
                    id: 1,
                });

                const variacoes = respose.data;
                this.variacoes = [];
                console.log(this.variacoes);
                variacoes.map((variacao: Variacao) => {
                    this.variacoes.push({
                        id: variacao.id,
                        titulo: variacao.titulo,
                        opcoes: [
                            {
                                id: 0,
                                titulo: 'nada',
                                valor: 0,
                            },
                        ],
                    });
                });

                console.log(this.variacoes);
            }
        },
        deleteVariaco(idVaricao:number){
          // AXIOS PARA REMOVER UM CAMPO DE VARIACAO DO BANCO
        },
        deleteOpcao(idOpcao:number){
          // AXIOS PARA REMOVER UMA OPCAO DO BANCO
        }
    },
});

export default useDialogProduto;
