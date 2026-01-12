import { Estilo } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface EstiloState {
    estilos: Estilo[];
    estilo: Estilo;
}

const useEstiloStore = defineStore('estiloStore', {
    state: (): EstiloState => ({
        estilos: [],
        estilo: {
            id: 0,
            id_con: 0,
            titulo: '',
            imagem: '',
            valor: 0,
            descricao: '',
            active: true,
            file: null,
        },
    }),
    actions: {
        async setEstilo() {
            try {
                const formData = new FormData();
                const data = {
                    estilo: this.estilo,
                };

                formData.append('data', JSON.stringify(data));
                if (this.estilo.file != null) {
                    formData.append('imagem', this.estilo.file);
                }

                const response = await axios.post(
                    '/encomenda/estilos/setestilo',
                    formData,
                    {
                        headers: {
                            'Content-Type': "multipart/form-data",
                        },
                    },
                );
                if (response.data.success) {
                    if (response.data.estilo) {
                        this.estilos.push(response.data.estilo);
                    }
                }

                return response.data;
            } catch ($error) {}
        },
        async delete() {
            try {
                if (this.estilo.id != 0) {
                    const response = await axios.post(
                        '/encomenda/estilos/delete',
                        {
                            id: this.estilo.id,
                        },
                    );

                    if (response.data.success) {
                        this.estilos = this.estilos.filter(
                            (e: Estilo) => e.id != this.estilo.id,
                        );
                    }

                    return response.data;
                }
            } catch ($error) {}
        },
        clear() {
            this.estilo = {
                id: 0,
                id_con: 0,
                titulo: '',
                imagem: '',
                descricao: '',
                valor: 0,
                active: true,
                file: null,
            };
        },
    },
});

export default useEstiloStore;
