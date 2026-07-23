import { getConfeitarias } from '@/actions/App/Http/Controllers/Api/Admin/AdminController';
import { Confeitaria } from '@/types/types';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { defineStore } from 'pinia';


const page = usePage();
interface ConfeitariaState {
    confeitaria: Confeitaria;
    file: File | null;
    notification: boolean;
    theme: 'light' | 'dark';
    blockDates: string[];
    limite: number;
}

const useConfeitariaStore = defineStore('confeitariaStore', {
    state: (): ConfeitariaState => ({
        confeitaria: {
            // id: 0,
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
        limite: 0,
    }),
    getters:{
        getConfeitaria(){
            this.confeitaria = page.props.auth.user;
        }
    },
    actions: {
        async setConfeitaria(dataConf:Confeitaria) {
            try {
                const formData = new FormData();
                
                let data = {
                    confeitaria: dataConf,
                    blockdates: this.blockDates,
                };

                formData.append('data', JSON.stringify(data));

                if (this.limite != 0 && this.limite != null && this.limite != undefined) {
                    formData.append('limite', JSON.stringify(this.limite));
                }

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
