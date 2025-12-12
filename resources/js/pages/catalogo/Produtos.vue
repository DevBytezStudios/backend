<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';

import {
    Pagination,
    PaginationContent,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import { ref } from 'vue';

import DialogProduct from '@/components/Dashboard/Produtos/DialogProduct.vue';
import ListVisualization from '@/components/Dashboard/Produtos/ListVisualization.vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import useDialogProduto from '@/stores/DialogProduto';
import { Paginator, Produto } from '@/types/types';
import { GridIcon, ListIcon, PlusCircleIcon } from 'lucide-vue-next';
import PaginationEllipsis from '@/components/ui/pagination/PaginationEllipsis.vue';

interface Props {
    produtos: Produto[];
    paginator: Paginator;
}

const showDialog = ref(false);
const props = defineProps<Props>();
const dialogProduto = useDialogProduto();
const filterValue = ref('nome');

console.log(props.paginator);
const addProduto = async () => {
    await dialogProduto.getCategorias();
    showDialog.value = true;
};

const navigate = (url: string | null) => {
    if (!url) return;
    router.get(url);
};
</script>

<template>
    <AppLayout page="Produtos">
        <DialogProduct :open="showDialog" @close-dialog="showDialog = false" />

        <header class="menubar">
            <label class="containerSearch" for="inputSearch">
                <Input
                    type="text"
                    placeholder="Pesquisar produto"
                    name="inputSearch"
                    id="inputSearch"
                    class="w-full"
                />
            </label>

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

        <div class="flex flex-col gap-6">
            <Tabs default-value="list" class="w-full">
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
                    <!-- <GridVisualization :produtos="props.produtos" /> -->
                </TabsContent>
            </Tabs>
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
                    <PaginationNext @click="navigate(props.paginator.next_page_url)" />
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

.containerSearch {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.searchIcon {
    width: 10%;
}
</style>
