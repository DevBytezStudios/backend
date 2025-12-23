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
import useDialogProduto from '@/stores/DialogProduto';
import { Produto } from '@/types/types';
import { Edit2Icon, TrashIcon } from 'lucide-vue-next';
import DialogProduct from './DialogProduct.vue';

const dialogProduto = useDialogProduto();

const props = defineProps<{
    produtos: Produto[];
}>();

// DIALOGS DOS PRODUTOS
const showDialog = ref(false);

// Produto escolhido
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

const editProduto = async (produto: Produto) => {
    loading.value = !loading.value;

    dialogProduto.produto = produto;
    await dialogProduto.getVariacao();
    showDialog.value = true;
    loading.value = !loading.value;
};

import LoadingBar from '@/components/LoadingBar.vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
const loading = ref(false);
// DELETAR PRODUTO
const alertDialog = ref(false);

const deletarProduto = async () => {
    try {
        loading.value = !loading.value;
        const response = await dialogProduto.deleteProduto();
        if (response.success) {
            alertDialog.value = false;
            dialogProduto.produto.id = 0;
            loading.value = !loading.value;

            toast.success(response.success.titulo);
        } else {
            loading.value = !loading.value;

            toast.error(response.error.titulo);
        }
    } catch ($error) {}
};
</script>

<template>
    <LoadingBar :loading="loading" />
    <div class="w-full overflow-x-auto">
        <Toaster />
        <DialogProduct :open="showDialog" @close-dialog="showDialog = false" />
        <AlertDialog :open="alertDialog">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle
                        >Deseja deletar esse produto?</AlertDialogTitle
                    >
                    <AlertDialogDescription>
                        Essa ação irá deletar este produto PERMANENTEMENTE,
                        deseja deletar?
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel
                        @click="
                            ((dialogProduto.produto.id = 0),
                            (alertDialog = false))
                        "
                        >Cancelar</AlertDialogCancel
                    >
                    <AlertDialogAction @click="deletarProduto"
                        >Continuar</AlertDialogAction
                    >
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
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
                    <TableHead class="text-right"></TableHead>
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
                        {{
                            new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                            }).format(produto.valor)
                        }}
                    </TableCell>

                    <TableCell class="hidden md:table-cell">
                        {{ produto.valor_desc }}
                    </TableCell>

                    <TableCell class="flex justify-end gap-2 text-right">
                        <DropdownMenu>
                            <DropdownMenuTrigger
                                class="flex items-center gap-2 rounded-md border border-muted-foreground/20 bg-muted/40 px-4 py-2 text-sm font-medium transition-colors hover:bg-muted/60"
                            >
                                <span>Ações</span>
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
                                <DropdownMenuItem @click="editProduto(produto)"
                                    ><Edit2Icon /> Editar</DropdownMenuItem
                                >
                                <DropdownMenuItem
                                    class="bg-red-500"
                                    @click="
                                        ((dialogProduto.produto.id =
                                            produto.id),
                                        (alertDialog = true))
                                    "
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
