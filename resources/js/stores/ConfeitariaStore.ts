import { Confeitaria } from '@/types/types';
import axios from 'axios';
import { defineStore } from 'pinia';

interface ConfeitariaState {
    confeitaria: Confeitaria;
    file: File | null;
    notification: boolean;
    theme: 'light' | 'dark';
    blockDates: string[];
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
            logo_url: '',
            slug: '',
        },
        file: null,
        notification: true,
        theme: 'light',
        blockDates: [],
    }),
    actions: {
        async setConfeitaria() {
            try {
                const formData = new FormData();
                console.log(this.blockDates);

                const data = {
                    confeitaria: this.confeitaria,
                    blockdates: this.blockDates,
                };

                formData.append('data', JSON.stringify(data));

                if (this.file != null) {
                    formData.append('logo', this.file);
                }

                const response = await axios.post(
                    '/configuracoes/setinfo',
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
        async getBlockDates() {
            try {
                const response = await axios.get(
                    '/configuracoes/getblockdates',
                );

                if (response.data) {
                    this.blockDates = response.data;
                }
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
