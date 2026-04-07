import { Cardapio } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';
import { toast } from 'vue-sonner';

interface DialogCardapioState {
    cardapio: Cardapio;
    cardapios: Cardapio[];
    open: boolean;
}

const useDialogCardapio = defineStore('dialogCardapio', {
    state: (): DialogCardapioState => ({
        cardapio: {
            id: 0,
            titulo: '',
            id_con: 0,
            cor_princ: '',
            cor_sec: '',
            dt_fim: '',
            dt_inicio: '',
            active: false,
        },
        cardapios: [],
        open: false,
    }),

    actions: {
        async setCardapio() {
            const formData = new FormData();
            console.log(this.cardapio)
            formData.append('data', JSON.stringify(this.cardapio));

            const response = await axios.post(
                '/cardapios/setcardapio',
                formData,
            );

            if (response.data.success) {
                this.cardapios.push(response.data.success.newcardapio);
                toast.success(response.data.success.titulo);
            }
        },
        clearDialog() {
            this.cardapio = {
                id: 0,
                titulo: '',
                id_con: 0,
                cor_princ: '',
                cor_sec: '',
                dt_fim: '',
                dt_inicio: '',
                active: false,
            };
            this.open = false;
        },
    },
});

export default useDialogCardapio;
