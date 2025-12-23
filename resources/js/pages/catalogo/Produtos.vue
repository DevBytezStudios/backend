<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

import { ButtonGroup } from '@/components/ui/button-group';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { SearchIcon } from 'lucide-vue-next';
import DialogProduct from '@/components/Dashboard/Produtos/DialogProduct.vue';
import ListVisualization from '@/components/Dashboard/Produtos/ListVisualization.vue'; 
import {
    Pagination,
    PaginationContent,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import useDialogProduto from '@/stores/DialogProduto';
import { Paginator, Produto } from '@/types/types';
import axios from 'axios';
import { PlusCircleIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
import LoadingBar from '@/components/LoadingBar.vue';

interface Props {
    produtos: Produto[];
    paginator: Paginator;
}

const loading = ref(false);

const showDialog = ref(false);
const props = defineProps<Props>();
const dialogProduto = useDialogProduto();

const addProduto = async () => {
    loading.value = !loading.value;
    await dialogProduto.getCategorias();
    showDialog.value = true;
    loading.value = !loading.value;
};

const navigate = (url: string | null) => {
    if (!url) return;
    router.get(url);
};

// PESQUISA
const filterValue = ref('nome');
const searchValue = ref('');
const pesquisando = ref(false);
const produtosPesquisa = ref<Produto[]>([]);
let searchTimeout: number | null = null;

const searchProdutos = async () => {
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

                formData.append('valor', searchValue.value);
                formData.append('filtro', filterValue.value);

                const response = await axios.post<Produto[]>(
                    '/catalogo/produto/search',
                    formData,
                );

                produtosPesquisa.value = response.data;
                // SE NÃO ACHAR NADA
                if (produtosPesquisa.value.length == 0) {
                    toast.warning('Nada Encontrado!...');
                }
            }, 500);
        } else {
            produtosPesquisa.value = [];
            loading.value = !loading.value;

            toast.warning('Pesquisa vazia!...');
        }
    } catch ($error) {
        loading.value = !loading.value;

        console.log($error);
    } finally {
        loading.value = !loading.value;

        pesquisando.value = false;
    }
};
</script>

<template>
    <LoadingBar :loading="loading"/>
    <Toaster />
    <AppLayout page="Produtos">
        <DialogProduct :open="showDialog" @close-dialog="showDialog = false" />
        
        <header class="menubar">
            <ButtonGroup class="w-full">
                <Input
                    placeholder="Pesquisar..."
                    v-model="searchValue"
                    @input="searchProdutos"
                />
                <Button
                    variant="outline"
                    aria-label="Search"
                    @click="searchProdutos"
                >
                    <SearchIcon />
                </Button>
            </ButtonGroup>

            <Select v-model="filterValue">
                <SelectTrigger class="w-[180px]">
                    <SelectValue :placeholder="'Filtrar por: ' + filterValue" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem value="nome"> Nome </SelectItem>
                        <SelectItem value="cat"> Categoria </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>

            <Button variant="outline" @click="addProduto()" type="button">
                <PlusCircleIcon />
            </Button>
        </header>

        <div class="flex flex-col gap-6 h-full">
            <ListVisualization
                v-if="produtosPesquisa?.length == 0"
                :produtos="props.produtos"
                :open-dialog="showDialog"
            />
            <!-- SE TIVER PESQUISA -->
            <ListVisualization
                v-if="produtosPesquisa.length != 0"
                :produtos="produtosPesquisa"
                :open-dialog="showDialog"
            />

            <!-- ADICIONAR VISUALIZAÇÔES DIFERENTES DEPOIS -->
            <!-- <Tabs default-value="list" class="w-full">
                <TabsList>
                    <TabsTrigger value="list">
                        <ListIcon />
                    </TabsTrigger>
                    <TabsTrigger value="grid"> <GridIcon /> </TabsTrigger>
                </TabsList>
                <TabsContent value="list">
                    <ListVisualization
                        :produtos="props.produtos"
                        :open-dialog="showDialog"
                    />
                </TabsContent>
                <TabsContent value="grid">
                    <GridVisualization :produtos="props.produtos" /> 
                </TabsContent>
            </Tabs> -->
            <!-- VISUALIZAÇÂO -->
        </div>

        <div class="flex flex-col gap-6">
            <Pagination
                v-slot="{ page }"
                :items-per-page="props.paginator.per_page"
                :total="props.paginator.total"
                :default-page="props.paginator.current_page"
            >
                <PaginationContent v-slot="{ items }">
                    <PaginationPrevious
                        @click="navigate(props.paginator.prev_page_url)"
                    />

                    <template
                        v-for="(link, index) in props.paginator.links"
                        :key="index"
                    >
                        <template
                            v-if="
                                !link.label.includes('Previous') &&
                                !link.label.includes('Next')
                            "
                        >
                            <PaginationItem
                                :value="link.page"
                                :is-active="link.active"
                                @click="navigate(link.url)"
                            >
                                {{ link.label }}
                            </PaginationItem>
                        </template>
                    </template>
                    <PaginationNext

                        @click="navigate(props.paginator.next_page_url)"
                    />
                </PaginationContent>
            </Pagination>
        </div>
    </AppLayout>
</template>

<style scoped>
.menubar {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 10px;
    border: white 1px solid;
    border-radius: 5px;
}
</style>
