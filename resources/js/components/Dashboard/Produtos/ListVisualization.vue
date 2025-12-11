<script setup lang="ts">
import { ref } from 'vue';

import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Edit2Icon, TrashIcon } from 'lucide-vue-next';
import DialogProduct from './DialogProduct.vue';
import { Produto } from '@/types/types';
import useDialogProduto from '@/stores/DialogProduto';

const dialogProduto = useDialogProduto();

const props = defineProps<{
    produtos: Produto[];
}>();

// DIALOGS DOS PRODUTOS
const showDialog = ref(false);

// CONTROLE DO ALERT
// const alertDialog = ref({
//     active: false,
//     title: '',
//     msg: '',
// });

// Produto escolhido
const editProduto = async (produto: Produto) => {
     dialogProduto.produto = produto;
     await dialogProduto.getVariacao();
     showDialog.value = true;
};

</script>

<template>
    <div class="w-full overflow-x-auto">
        <!-- <Toaster /> -->
        <DialogProduct
            :open="showDialog"
            @close-dialog="showDialog = false"
        />

        <Table>
            <TableCaption>Lista de produtos cadastrados</TableCaption>

            <TableHeader>
                <TableRow>
                    <TableHead>Imagem</TableHead>
                    <TableHead>Nome</TableHead>
                    <!-- <TableHead>Descrição</TableHead> -->

                    <TableHead class="hidden md:table-cell"
                        >Categoria</TableHead
                    >
                    <TableHead class="hidden md:table-cell">Preço</TableHead>
                    <TableHead class="hidden md:table-cell"
                        >Valor desconto</TableHead
                    >
                    <TableHead class="text-right">Ações</TableHead>
                </TableRow>
            </TableHeader>

            <TableBody>
                <TableRow
                    v-for="produto in produtos"
                    :key="produto.id"
                    class="group cursor-pointer transition-all duration-200 hover:scale-[1.00] hover:bg-muted/40 hover:shadow-sm"
                >
                    <TableCell>
                        <img
                            :src="produto.imagem"
                            class="h-12 w-12 rounded-md object-cover transition-all duration-200 group-hover:scale-105"
                        />
                    </TableCell>

                    <TableCell class="font-medium">
                        {{ produto.nome }}
                    </TableCell>

                    <TableCell class="hidden md:table-cell">
                        {{ produto.categoria?.titulo }}
                    </TableCell>

                    <TableCell class="hidden md:table-cell">
                        {{new Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(produto.valor,)}}
                    </TableCell>

                    <TableCell class="hidden md:table-cell">
                        {{ produto.valor_desc }}
                    </TableCell>

                    <TableCell class="flex justify-end gap-2 text-right">
                        <DropdownMenu>
                            <DropdownMenuTrigger
                                class="flex items-center gap-2 rounded-md border border-muted-foreground/20 bg-muted/40 px-4 py-2 text-sm font-medium transition-colors hover:bg-muted/60"
                            >
                                <span>Opção</span>
                                <svg
                                    class="h-4 w-4 opacity-70"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <path
                                        d="M7 10L12 15L17 10"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                    />
                                </svg>
                            </DropdownMenuTrigger>

                            <DropdownMenuContent>
                                <DropdownMenuItem
                                    @click="
                                        editProduto(produto)
                                    "
                                    ><Edit2Icon /> Editar</DropdownMenuItem
                                >
                                <DropdownMenuItem
                                    ><TrashIcon />Deletar</DropdownMenuItem
                                >
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
