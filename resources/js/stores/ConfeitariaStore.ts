import { Confeitaria } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface ConfeitariaState {
    confeitaria: Confeitaria;
    file: File | null;
    notification: boolean;
    theme: 'light' | 'dark';
}

const useConfeitariaStore = defineStore('confeitariaStore', {
    state: (): ConfeitariaState => ({
        confeitaria: {
            id: 0,
            email: '',
            telefone: '',
            cor_princ: '',
            cor_sec: '',
            nome: '',
            logo: '',
            slug: '',
        },
        file: null,
        notification: true,
        theme: 'light',
    }),
    actions: {
        async setConfeitaria() {
            try {
                const formData = new FormData();
                const data = {
                    confeitaria: this.confeitaria,
                };

                formData.append('data', JSON.stringify(data));

                if (this.file != null) {
                    formData.append('logo', this.file);
                }

                const response = await axios.post(
                    '/informacoes/setinfo',
                    formData,
                    {
                        headers: { 'Content-Type': 'multipart/form-data' },
                    },
                );

                if (response.data.confeitaria) {
                    this.confeitaria = response.data.confeitaria;
                }
                return response.data;
            } catch ($error) {
                console.log($error);
            }
        },
    },
    persist: {
        storage: localStorage,
    },
});

export default useConfeitariaStore;
