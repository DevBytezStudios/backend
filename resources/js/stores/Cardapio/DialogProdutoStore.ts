import { Produto } from '@/types/types';
import { defineStore } from 'pinia';

interface DialogCardapioState {
    produto: Produto;
    open: boolean;
    file: File | null;
}

const useDialogProduto = defineStore('dialogProduto', {
    state: (): DialogCardapioState => ({
        produto: {
            id: 0,
            imagem: '',
            nome: '',
            categoria: null,
            descricao: '',
            valor: 0,
            valor_desc: 0,
        },
        file: null,
        open: false,
    }),
    actions: {
        clearDialog() {
            this.produto = {
                id: 0,
                imagem: '',
                nome: '',
                categoria: null,
                descricao: '',
                valor: 0,
                valor_desc: 0,
            };
            this.open = false;
        },
    },
});

export default useDialogProduto;
