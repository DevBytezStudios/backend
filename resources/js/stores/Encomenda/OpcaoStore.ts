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
            const verificao = await this.verificacao();
            if (verificao === true) {
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
                        const newOpcao: OpcaoEtapa = response.data.newopcao;
                        this.opcoes.push(newOpcao);
                    }
                    return response.data;
                } catch ($error) {
                    console.log($error);
                }
            } else {
                return this.verificacao();
            }
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
        async delete(idOpcao: number) {
            const response = await axios.post('/encomenda/opcoes/delete', {
                id: idOpcao,
            });

            if (response.data.success) {
                this.opcoes = this.opcoes.filter(
                    (opcao: OpcaoEtapa) => opcao.id != idOpcao,
                );
            }
            return response.data;
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
        async verificacao() {
            const error = (mensagem: string) => ({
                error: {
                    titulo: mensagem,
                    code: 422,
                },
            });


            // Nome da opção
            if (!this.opcao.nome || this.opcao.nome.trim() === '') {
                return error('O nome da opção é obrigatório.');
            }

            // Etapa vinculada
            if (
                !this.opcao.etapa ||
                !this.opcao.etapa.id ||
                this.opcao.etapa.id <= 0
            ) {
                return error('A etapa da opção é obrigatória.');
            }

            // Descrição (opcional, mas se existir precisa ser válida)
            if (this.opcao.descricao && this.opcao.descricao.trim() === '') {
                return error('A descrição da opção não pode ser vazia.');
            }

            // Valor
            const valorNum = Number(this.opcao.valor);

            if (isNaN(valorNum)) {
                return error('O valor da opção deve ser um número válido.');
            }

            if (valorNum < 0) {
                return error('O valor da opção não pode ser negativo.');
            }

            // Status
            if (typeof this.opcao.active !== 'boolean') {
                return error('O status da opção é inválido.');
            }

            return true;
        },
    },
});

export default useOpcaoStore;
