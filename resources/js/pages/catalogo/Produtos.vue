<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
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
import { Produto } from '@/types/types';
import { GridIcon, ListIcon, PlusCircleIcon } from 'lucide-vue-next';

const filterValue = ref('nome');

interface Props {
    produtos: Array<Produto>;
}

const showDialog = ref(false);
const props = defineProps<Props>();
import useDialogProduto from '@/stores/DialogProduto';
const dialogProduto = useDialogProduto();


const addProduto = async () => {
    await dialogProduto.getCategorias();
    showDialog.value = true;
};
</script>

<template>
    <AppLayout>
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

            <!-- PAGINAÇÃO -->
            <Pagination
                v-slot="{ page }"
                :items-per-page="10"
                :total="30"
                :default-page="2"
            >
                <PaginationContent v-slot="{ items }">
                    <PaginationPrevious />
                    <template v-for="(item, index) in items" :key="index">
                        <PaginationItem
                            v-if="item.type === 'page'"
                            :value="item.value"
                            :is-active="item.value === page"
                        >
                            {{ item.value }}
                        </PaginationItem>
                    </template>
                    <PaginationEllipsis :index="4" />
                    <PaginationNext />
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
