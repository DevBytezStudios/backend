import { Categoria, Produto, Variacao } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface DialogState {
    produto: Produto;
    variacoes: Variacao[];
    categorias: Categoria[] | null;
    file: File | null;
}

const useDialogProduto = defineStore('dialogProduto', {
    state: (): DialogState => ({
        produto: {
            id: 0,
            nome: '',
            descricao: '',
            categoria: null,
            valor: 0,
            valor_desc: 0,
            imagem: '',
        },
        variacoes: [],
        categorias: null,
        file: null,
    }),
    actions: {
        async getVariacao() {
            await this.getCategorias();
            if (this.produto.id != 0) {
                try {
                    const response = await axios.post(
                        '/catalogo/produto/variacao',
                        {
                            id: this.produto.id,
                        },
                    );
                    const variacoes = response.data.variacoes;
                    variacoes.map((variacao: Variacao) => {
                        this.variacoes.push(variacao);
                    });

                    console.log(this.variacoes);
                } catch ($error) {
                    console.log($error);
                }
            }
        },
        // DEPOIS COLOCAR NA STORE DA CONFEITARIA
        async getCategorias() {
            try {
                const response = await axios.post('/catalogo/categorias', {
                    id_con: 1,
                });

                if (response.data.categorias) {
                    const categorias = response.data.categorias;
                    this.categorias = categorias;
                    if (this.produto.categoria == null && this.categorias) {
                        console.log('aaa');
                        this.produto.categoria = this.categorias[0];
                    }
                }
            } catch ($error) {
                console.log($error);
            }
        },
        async deleteVariaco(idVaricao: number) {
            // AXIOS PARA REMOVER UM CAMPO DE VARIACAO DO BANCO
            try {
                const response = await axios.post(
                    '/catalogo/produto/deletevariacao',
                    {
                        id: idVaricao,
                    },
                );
                return response.data;
            } catch ($error) {
                console.log($error);
            }
        },
        async deleteOpcao(idOpcao: number) {
            // AXIOS PARA REMOVER UMA OPCAO DO BANCO
            try {
                const response = await axios.post(
                    '/catalogo/produto/deleteopcao',
                    {
                        id: idOpcao,
                    },
                );

                return response.data;
            } catch ($error) {
                console.log($error);
            }
        },
        async deleteProduto() {
            try {
                if (this.produto.id != 0) {
                    const response = await axios.post(
                        '/catalogo/produto/deleteproduto',
                        {
                            id: this.produto.id,
                        },
                    );

                    return response.data;
                } else {
                    return {
                        error: {
                            titulo: 'Produto não encontrado para deletar!',
                        },
                    };
                }
            } catch ($error) {
                console.log($error);
            }
        },
        clearDialog() {
            this.produto = {
                id: 0,
                nome: '',
                descricao: '',
                categoria: null,
                valor: 0,
                valor_desc: 0,
                imagem: '',
            };
            this.variacoes = [];
            this.categorias = null;
        },
        async saveProduto() {
            const verificao = await this.verificacao();
            if (verificao === true) {
                try {
                    await this.getCategorias();
                    const formData = new FormData();
                    const data = {
                        produto: this.produto,
                        variacoes: this.variacoes,
                    };

                    formData.append('data', JSON.stringify(data));

                    if (this.file != null) {
                        formData.append('imagem', this.file);
                    }

                    const response = await axios.post(
                        '/catalogo/produto/setproduto',
                        formData,
                        {
                            headers: { 'Content-Type': 'multipart/form-data' },
                        },
                    );

                    return response.data;
                } catch ($error) {}
            } else {
                return this.verificacao();
            }
        },
        async verificacao() {
            const error = (mensagem: string) => {
                return {
                    error: {
                        titulo: mensagem,
                        code: 422,
                    },
                };
            };

            if (!this.produto.nome || this.produto.nome.trim() === '') {
                return error('O nome do produto é obrigatório.');
            }

            if (
                !this.produto.descricao ||
                this.produto.descricao.trim() === ''
            ) {
                return error('A descrição do produto é obrigatória.');
            }
            if (
                this.produto.categoria === null ||
                this.produto.categoria === undefined
            ) {
                return error('A categoria do produto é obrigatória.');
            }

            const valorNum = Number(this.produto.valor);
            if (isNaN(valorNum) || valorNum <= 0) {
                return error('O valor do produto deve ser maior que zero.');
            }

            const valorDescNum = Number(this.produto.valor_desc);
            if (!isNaN(valorDescNum) && valorDescNum > valorNum) {
                return error(
                    'O valor do desconto não pode ser maior que o valor do produto.',
                );
            }

            if (valorDescNum < 0) {
                return error('O valor do desconto não pode ser negativo.');
            }

            return true;
        },
    },
});

export default useDialogProduto;
