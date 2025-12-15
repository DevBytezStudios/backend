<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import Input from '@/components/ui/input/Input.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import useDialogCategoria from '@/stores/DialogCategoria';
import { Categoria } from '@/types/types';
import { Edit2Icon, PlusCircleIcon, TrashIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';

interface Props {
    categorias: Categoria[];
}

const props = defineProps<Props>();

const dialogCategoria = useDialogCategoria();
console.log(dialogCategoria);
const showDialog = ref(false);

const saveCategoria = async () => {
    const response = await dialogCategoria.setCategoria();
    if (response.success) {
        showDialog.value = false;
        dialogCategoria.clearDialog();
        toast.success(response.success.titulo);
    } else {
        toast.error(response.error.titulo);
    }
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

const showAlertDialog = ref({
    id: 0,
    active: false,
});

const deletarCategoria = async () => {
    const response = await dialogCategoria.deleteCategoria(
        showAlertDialog.value.id,
    );
    if (response.success) {
        showAlertDialog.value.id = 0;
        showAlertDialog.value.active = false;
        dialogCategoria.clearDialog();
        toast.success(response.success.titulo);
    } else {
        toast.error(response.error.titulo);
    }
};
</script>

<template>
    <AppLayout page="Categorias">
        <Toaster />
        <Dialog :open="showDialog" theme="system">
            <DialogContent
                class="max-h-[90vh] max-w-[90vw] overflow-y-auto rounded-lg p-6 md:max-w-150"
            >
                <DialogHeader>
                    <DialogTitle>
                        {{
                            dialogCategoria.categoria.id ? 'Editar categoria' : 'Nova categoria'
                        }}
                    </DialogTitle>
                </DialogHeader>
                <div class="grid gap-4">
                    <div class="grid gap-3">
                        <Label for="categoria">Titulo da categoria</Label>
                        <Input
                            id="categoria"
                            v-model="dialogCategoria.categoria.titulo"
                            name="categoria"
                            placeholder="Ex: Bolos..."
                        />
                    </div>
                </div>
                <DialogFooter>
                    <DialogClose as-child>
                        <Button
                            variant="outline"
                            @click="
                                (dialogCategoria.clearDialog(),
                                (showDialog = false))
                            "
                        >
                            Cancelar
                        </Button>
                    </DialogClose>
                    <Button type="button" @click="saveCategoria">
                        Salvar
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>

        <AlertDialog :open="showAlertDialog.active">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle
                        >Deseja deletar essa categoria?</AlertDialogTitle
                    >
                    <AlertDialogDescription>
                        Essa ação irá deletar todos os PRODUTOS relacionados a
                        esta categoria tem certeza?
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel
                        @click="
                            ((showAlertDialog.id = 0),
                            (showAlertDialog.active = false))
                        "
                        >Cancelar</AlertDialogCancel
                    >
                    <AlertDialogAction @click="deletarCategoria"
                        >Continuar</AlertDialogAction
                    >
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

        <header class="menubar">
            <!-- <ButtonGroup class="w-full">
                <Input placeholder="Pesquisar..." />
                <Button variant="outline" aria-label="Search">
                    <SearchIcon />
                </Button>
            </ButtonGroup> -->

            <Button variant="outline" type="button" @click="showDialog = true">
                <PlusCircleIcon />
            </Button>
        </header>

        <div class="w-full overflow-x-auto">
            <Toaster />
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="hidden md:table-cell"
                            >Categoria</TableHead
                        >
                        <TableHead class="text-right">Ações</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow
                        v-for="(categoria, index) in props.categorias"
                        :key="index"
                        class="group cursor-pointer transition-all duration-200 hover:scale-[1.00] hover:bg-muted/40 hover:shadow-sm"
                    >
                        <TableCell class="font-medium">{{
                            categoria.titulo
                        }}</TableCell>

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
                                            ((dialogCategoria.categoria =
                                                categoria),
                                            (showDialog = true))
                                        "
                                        ><Edit2Icon /> Editar</DropdownMenuItem
                                    >
                                    <DropdownMenuItem
                                        class="bg-red-500"
                                        @click="
                                            ((showAlertDialog.id =
                                                categoria.id),
                                            (showAlertDialog.active = true))
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
    </AppLayout>
</template>

<style lang="css" scoped>
.menubar {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: end;
    gap: 1rem;
    padding: 10px;
    /* border: white 1px solid; */
    border-radius: 5px;
}
</style>
