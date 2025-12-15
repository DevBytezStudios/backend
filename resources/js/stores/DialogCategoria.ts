import { Categoria } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface DialogCategoriaState {
    categoria: Categoria;
}

const useDialogCategoria = defineStore('dialogCategoria', {
    state: (): DialogCategoriaState => ({
        categoria: {
            id: 0,
            titulo: '',
        },
    }),

    actions: {
        clearDialog() {
            this.categoria = {
                id: 0,
                titulo: '',
            };
        },
        async setCategoria() {
            const verificacao = this.verificacao();
            if (verificacao !== true) return verificacao;

            try {
                const response = await axios.post(
                    '/catalogo/categorias/setcategoria',
                    {
                        id: this.categoria.id,
                        titulo: this.categoria.titulo
                    },
                );

                return response.data;
            } catch (error) {
                console.log(error);
            }
        },

        /** Deletar */
        async deleteCategoria(idCat:number) {
            if (idCat == 0) {
                return {
                    error: {
                        titulo: 'Categoria não encontrada para deletar!',
                        code: 422,
                    },
                };
            }

            try {
                const response = await axios.post(
                    '/catalogo/categorias/delete',
                    {
                        id: idCat,
                    },
                );

                return response.data;
            } catch (error) {
                console.log(error);
            }
        },

        /** Validação */
        verificacao() {
            const error = (mensagem: string) => ({
                error: {
                    titulo: mensagem,
                    code: 422,
                },
            });

            if (!this.categoria.titulo || this.categoria.titulo.trim() === '') {
                return error('O título da categoria é obrigatório.');
            }

            return true;
        },
    },
});

export default useDialogCategoria;
