import { Etapa } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface EtapaState {
    etapas: Etapa[] | [];
    etapa: Etapa;
}

const useEtapaStore = defineStore('etapaStore', {
    state: (): EtapaState => ({
        etapas: [],
        etapa: {
            id: 0,
            id_con: 0,
            nome: '',
            icone: '',
            ordem: 0,
            multiple: false,
            required: false,
        },
    }),
    actions: {
        async setEtapa() {
            try {
                console.log(this.etapa);
                const formData = new FormData();

                if (this.etapa.ordem == 0) {
                    this.etapa.ordem = this.etapas.length + 1;
                }
                const data = {
                    etapa: this.etapa,
                };

                formData.append('data', JSON.stringify(data));

                const response = await axios.post(
                    '/encomenda/etapas/setetapa',
                    formData,
                );

                return response.data;
            } catch ($error) {}
        },
        async setOrdem(current:Etapa, novo:Etapa) {
            try {
                console.log(this.etapa);
                const formData = new FormData();

                if (this.etapa.ordem == 0) {
                    this.etapa.ordem = this.etapas.length + 1;
                }

                const data = {
                    atual: current,
                    novo: novo
                };

                formData.append('data', JSON.stringify(data));

                const response = await axios.post(
                    '/encomenda/etapas/setordem',
                    formData,
                );

                return response.data;
            } catch ($error) {}
        },
        clear() {
            this.etapa = {
                id: 0,
                id_con: 0,
                nome: '',
                icone: '',
                ordem: 0,
                multiple: false,
                required: false,
            };
        },
    },
});

export default useEtapaStore;
