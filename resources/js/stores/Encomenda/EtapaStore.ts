import { Etapa } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface EtapaState {
    etapas: Etapa[];
    etapa: Etapa;
}

const useEtapaStore = defineStore('etapaStore', {
    state: (): EtapaState => ({
        etapas: [],
        etapa: {
            id: 0,
            id_con: 0,
            nome: 'tamanho',
            icone: '',
            ordem: 0,
            multiple: false,
            required: true,
            opcoes_count: 0,
        },
    }),
    actions: {
        async setEtapa() {
            try {
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

                if (response.data.etapa) {
                    const newEtapa: Etapa = response.data.etapa;
                    this.etapas.push(newEtapa);
                }

                this.clear();

                return response.data;
            } catch ($error) {}
        },
        async setOrdem(current: Etapa, novo: Etapa) {
            try {
                const formData = new FormData();

                if (this.etapa.ordem == 0) {
                    this.etapa.ordem = this.etapas.length + 1;
                }

                const data = {
                    atual: current,
                    novo: novo,
                };

                formData.append('data', JSON.stringify(data));

                const response = await axios.post(
                    '/encomenda/etapas/setordem',
                    formData,
                );

                return response.data;
            } catch ($error) {}
        },
        async delete(idEtapa: number) {
            const response = await axios.post('/encomenda/etapas/delete', {
                id: idEtapa,
            });

            if (response.data.success) {
                this.etapas = this.etapas.filter(
                    (etapa: Etapa) => etapa.id != idEtapa,
                );
            }

            return response.data;
        },
        clear() {
            this.etapa = {
                id: 0,
                id_con: 0,
                nome: 'tamanho',
                icone: '',
                ordem: 0,
                multiple: false,
                required: true,
                opcoes_count: 0,
            };
        },
        addCountOpcao(idEtapa:Number){
            this.etapas.map((etapa)=>{
                if(etapa.id == idEtapa){
                    etapa.opcoes_count++
                }
            })
        }
    },
});

export default useEtapaStore;
