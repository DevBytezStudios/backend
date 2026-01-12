<script setup lang="ts">
import CardEncomenda from '@/components/Dashboard/Encomendas/CardEncomenda.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/AppLayout.vue';
import { Encomenda } from '@/types/types';

interface Props {
    encomendas: Encomenda[];
}
const loading = ref(false);
const props = defineProps<Props>();

const encomendas = ref([...props.encomendas]);
const tab = ref<'todos' | 'em_progresso' | 'concluido' | 'cancelado'>('todos');
const tabsValues = ['todos', 'em_progresso', 'concluido', 'cancelado'];
const encomendasFiltradas = computed(() => {
    if (tab.value === 'todos') {
        return encomendas.value;
    }

    return encomendas.value.filter(
        (encomenda: Encomenda) => encomenda.status == tab.value,
    );
});

const showAlert = ref({
    idEncomenda: 0,
    active: false,
});



const updateStauts = (encomenda: Encomenda, status: string) => {
    loading.value = true;
    encomenda.status = status;
    encomendasFiltradas;
    loading.value = !loading.value;
    return;
};

const deleteEncomenda = async (idEncomenda: number) => {
    try {
        loading.value = !loading.value;

        const response = await axios.post('/encomenda/delete', {
            id: idEncomenda,
        });

        if (response.data.success) {
            encomendas.value = encomendas.value.filter(
                (encomenda) => encomenda.id != idEncomenda,
            );
            showAlert.value.idEncomenda = 0;
            showAlert.value.active = false;
            loading.value = false;
            toast.success(response.data.success.titulo);
        } else {
            loading.value = !loading.value;
            toast.error(response.data.error.titulo);
        }
    } catch ($error) {
        console.log($error);
    } finally {
        loading.value = false;
    }
};

import ButtonGroup from '@/components/ui/button-group/ButtonGroup.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import axios from 'axios';
import { SearchIcon } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';


import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';

import LoadingBar from '@/components/LoadingBar.vue';
import Empty from '@/components/Empty.vue';

// PESQUISA
const searchValue = ref('');
const pesquisando = ref(false);
const encomendaPesquisa = ref<Encomenda[]>([]);
let searchTimeout: number | null = null;

const serachEncomenda = async () => {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    // BUSCAR PRODUTOS
    try {
        if (pesquisando.value == false && searchValue.value != '') {
            loading.value = !loading.value;

            pesquisando.value = true;
            // PAUSA DE 2 SEGUNDOS
            searchTimeout = setTimeout(async () => {
                const formData = new FormData();

                formData.append('valor', searchValue.value.toLocaleUpperCase());

                const response = await axios.post<Encomenda[]>(
                    '/encomenda/search',
                    formData,
                );
                console.log(encomendaPesquisa.value);
                encomendaPesquisa.value = response.data;

                loading.value = false;

                // SE NÃO ACHAR NADA
                if (encomendaPesquisa.value.length == 0) {
                    toast.warning('Nada Encontrado!...');
                }
            }, 500);
        } else {
            encomendaPesquisa.value = [];
            loading.value = !loading.value;
            toast.warning('Pesquisa vazia!...');
        }
    } catch ($error) {
        console.log($error);
    } finally {
        loading.value = false;
        pesquisando.value = false;
    }
};
</script>

<template>
    <AppLayout page="Encomendas">
        <LoadingBar :loading="loading" />
         <AlertDialog :open="showAlert.active">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle
                        >Deseja realmente deletar?</AlertDialogTitle
                    >
                    <AlertDialogDescription>
                        Esta ação será irreversivel e a encomenda será perdida,
                        tem certeza?
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel
                        @click="
                            ((showAlert.active = false),
                            (showAlert.idEncomenda = 0))
                        "
                        >Voltar</AlertDialogCancel
                    >
                    <AlertDialogAction
                        @click="deleteEncomenda(showAlert.idEncomenda)"
                        >Deletar</AlertDialogAction
                    >
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

        <Tabs v-model="tab">
            <div
                class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between"
            >
                <!-- Tabs -->
                <TabsList
                    class="flex w-full justify-start gap-1 overflow-x-auto whitespace-nowrap md:w-fit"
                >
                    <TabsTrigger value="todos">Todos</TabsTrigger>
                    <TabsTrigger value="em_progresso">Em progresso</TabsTrigger>
                    <TabsTrigger value="concluido">Concluído</TabsTrigger>
                    <TabsTrigger value="cancelado">Cancelado</TabsTrigger>
                </TabsList>

                <ButtonGroup class="w-full md:w-100">
                    <Input
                        placeholder="Digite o código do pedido..."
                        v-model="searchValue"
                        @input="serachEncomenda"
                    />
                    <Button
                        variant="outline"
                        aria-label="Search"
                        @click="serachEncomenda"
                    >
                        <SearchIcon />
                    </Button>
                </ButtonGroup>
            </div>
            <TabsContent
                v-for="(tab, index) in tabsValues"
                :key="index"
                :value="tab"
            >
                <div
                    class="flex w-full flex-row flex-wrap gap-10"
                    v-if="encomendaPesquisa.length == 0"
                >
                    <CardEncomenda
                        v-for="(encomenda, index) in encomendasFiltradas"
                        :key="index"
                        :encomenda="encomenda"
                        @updateStatus="updateStauts"
                         @deleteencomenda="
                            ((showAlert.idEncomenda = encomenda.id),
                            (showAlert.active = true))
                        "
                    />
                </div>
                <div class="flex w-full flex-row flex-wrap gap-3" v-else>
                   <CardEncomenda
                        v-for="(encomenda, index) in encomendaPesquisa"
                        :key="index"
                        :encomenda="encomenda"
                    />
                </div>
            </TabsContent>
             <Empty
                v-if="encomendasFiltradas.length == 0 && encomendaPesquisa.length == 0"
                msg="Você não tem encomendas!"
            />
        </Tabs>
    </AppLayout>
</template>
