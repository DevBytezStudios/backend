<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

import CardPedido from '@/components/Dashboard/Pedidos/CardPedido.vue';
import { ButtonGroup } from '@/components/ui/button-group';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Pedido } from '@/types/types';
import { SearchIcon } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    pedidos: Pedido[];
}

const props = defineProps<Props>();
const loading = ref(false);

const pedidos = ref([...props.pedidos]);
// const pedidosFiltrados = ref<Pedido[]>(props.pedidos);
const tab = ref<'todos' | 'em_progresso' | 'concluido' | 'cancelado'>('todos');
const tabsValues = ['todos', 'em_progresso', 'concluido', 'cancelado'];
const pedidosFiltrados = computed(() => {
    if (tab.value === 'todos') {
        return pedidos.value;
    }

    return pedidos.value.filter((pedido) => pedido.status == tab.value);
});

const updateStauts = (pedido: Pedido, status: string) => {
    loading.value = true;
    pedido.status = status;
    pedidosFiltrados;
    loading.value = !loading.value;
    return;
};

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

import axios from 'axios';

const showAlert = ref({
    idPedido: 0,
    active: false,
});

import LoadingBar from '@/components/LoadingBar.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';

const deletePedido = async (idPedido: number) => {
    try {
        loading.value = !loading.value;

        const response = await axios.post('/catalogo/pedidos/delete', {
            id: idPedido,
        });

        if (response.data.success) {
            pedidos.value = pedidos.value.filter(
                (pedido) => pedido.id != idPedido,
            );
            showAlert.value.idPedido = 0;
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

// PESQUISA DE PEDIDOS
const searchValue = ref('');
const pesquisando = ref(false);
const pedidosPesquisa = ref<Pedido[]>([]);
let searchTimeout: number | null = null;
const searchPedido = async () => {
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

                const response = await axios.post<Pedido[]>(
                    '/catalogo/pedidos/search',
                    formData,
                );
                console.log(pedidosPesquisa.value);
                pedidosPesquisa.value = response.data;

                loading.value = !loading.value;

                // SE NÃO ACHAR NADA
                if (pedidosPesquisa.value.length == 0) {
                    toast.warning('Nada Encontrado!...');
                }
            }, 500);
        } else {
            pedidosPesquisa.value = [];
            loading.value = !loading.value;

            toast.warning('Pesquisa vazia!...');
        }
    } catch ($error) {
        console.log($error);
    } finally {
        loading.value = !loading.value;

        pesquisando.value = false;
    }
};
</script>

<template>
    <AppLayout page="Pedidos">
        <LoadingBar :loading="loading" />
        <Toaster />
        <AlertDialog :open="showAlert.active">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle
                        >Deseja realmente deletar?</AlertDialogTitle
                    >
                    <AlertDialogDescription>
                        Esta ação será irreversivel e o pedido sera perdido, tem
                        certeza?
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel
                        @click="
                            ((showAlert.active = false),
                            (showAlert.idPedido = 0))
                        "
                        >Voltar</AlertDialogCancel
                    >
                    <AlertDialogAction @click="deletePedido(showAlert.idPedido)"
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
                        @input="searchPedido"
                    />
                    <Button
                        variant="outline"
                        aria-label="Search"
                        @click="searchPedido"
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
                    class="flex w-full flex-row flex-wrap gap-3"
                    v-if="pedidosPesquisa.length == 0"
                >
                    <CardPedido
                        v-for="(pedido, index) in pedidosFiltrados"
                        :key="index"
                        :pedido="pedido"
                        @updateStatus="updateStauts"
                        @deletePedido="
                            ((showAlert.idPedido = pedido.id),
                            (showAlert.active = true))
                        "
                    />
                </div>
                <div class="flex w-full flex-row flex-wrap gap-3" v-else>
                    <CardPedido
                        v-for="(pedido, index) in pedidosPesquisa"
                        :key="index"
                        :pedido="pedido"
                        @updateStatus="updateStauts"
                        @deletePedido="
                            ((showAlert.idPedido = pedido.id),
                            (showAlert.active = true))
                        "
                    />
                </div>
            </TabsContent>
        </Tabs>
    </AppLayout>
</template>
