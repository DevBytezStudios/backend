import { Categoria } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface DialogCategoriaState {
    categoria: Categoria;
    categorias: Categoria[];
    open: boolean;
}

const useDialogCategoria = defineStore('dialogCategoria', {
    state: (): DialogCategoriaState => ({
        categoria: {
            id: 0,
            titulo: '',
            id_cardap: 0,
        },
        categorias: [],
        open: false,
    }),

    actions: {
        clearDialog() {
            this.categoria = {
                id: 0,
                titulo: '',
                id_cardap: 0,
            };
            this.open = false;
        },
    },
});

export default useDialogCategoria;
