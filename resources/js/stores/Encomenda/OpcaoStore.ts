import { OpcaoEtapa } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface EtapaState {
    opcoes: OpcaoEtapa[];
    opcao: OpcaoEtapa;
    etapas: EtapaSelect[] | [];
}

// TYPE PARA AS ETAPAS QUE APARECEM NA HORA DE EDITAR/CRIAR UMA OPÇÃO
interface EtapaSelect {
    id: number;
    nome: string;
}

const useOpcaoStore = defineStore('opcaoStore', {
    state: (): EtapaState => ({
        opcoes: [],
        opcao: {
            id: 0,
            etapa: {
                id: 0,
                nome: '',
            },
            nome: '',
            valor: 0,
            descricao: '',
            active: true,
        },
        etapas: [],
    }),
    actions: {
        async setOpcao() {
            try {
                const formData = new FormData();
                const data = {
                    opcao: this.opcao,
                };

                formData.append('data', JSON.stringify(data));

                const response = await axios.post(
                    '/encomenda/opcoes/setopcao',
                    formData,
                );

                if (this.opcao.id == 0 && response.data.newopcao) {
                    const newOpcao: OpcaoEtapa = response.data.newopcao 
                    this.opcoes.push(newOpcao);
                }
                return response.data;
            } catch ($error) {}
        },
        async getEtapas() {
            try {
                if (this.etapas.length == 0) {
                    const response = await axios.get<EtapaSelect[]>(
                        '/encomenda/opcoes/getetapas',
                    );

                    this.etapas = response.data;
                }
            } catch ($error) {}
        },
        clear() {
            this.opcao = {
                id: 0,
                etapa: {
                    id: 0,
                    nome: '',
                },
                nome: '',
                valor: 0,
                descricao: '',
                active: true,
            };
        },
    },
});

export default useOpcaoStore;
