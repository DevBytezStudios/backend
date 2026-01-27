<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

import { Badge } from '@/components/ui/badge';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';

import DialogEtapa from '@/components/Dashboard/Encomendas/DialogEtapa.vue';
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
import Button from '@/components/ui/button/Button.vue';
import useEtapaStore from '@/stores/Encomenda/EtapaStore';
import { Etapa } from '@/types/types';
import {
    ArrowDownSquareIcon,
    ArrowUpSquareIcon,
    BadgeAlertIcon,
    BadgeCheckIcon,
    BadgeXIcon,
    Edit2Icon,
    InfoIcon,
    PlusCircleIcon,
    Trash2,
} from 'lucide-vue-next';
import { ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';

import Empty from '@/components/Empty.vue';
import LoadingBar from '@/components/LoadingBar.vue';
import DialogOpcao from '@/components/Dashboard/Encomendas/DialogOpcao.vue';

const showDialog = ref(false);

interface Props {
    etapas: Etapa[];
}

const props = defineProps<Props>();
const etapaStore = useEtapaStore();
etapaStore.etapas = props.etapas;

const editEtapa = (etapa: Etapa) => {
    etapaStore.etapa = etapa;
    showDialog.value = true;
};

const upItem = async (index: number) => {
    if (index === 0) return;

    const etapas = etapaStore.etapas;

    const current = etapas[index];
    const previous = etapas[index - 1];

    etapas[index - 1] = current;
    etapas[index] = previous;

    current.ordem = index;
    previous.ordem = index + 1;

    const response = await etapaStore.setOrdem(current, previous);
    if (response.success) {
        toast.success(response.success.titulo);
    } else {
        toast.error(response.error.titulo);
    }
};

const downItem = async (index: number) => {
    const etapas = etapaStore.etapas;

    if (index === etapas.length - 1) return;

    const current = etapas[index];
    const next = etapas[index + 1];

    etapas[index + 1] = current;
    etapas[index] = next;

    current.ordem = index + 2;
    next.ordem = index + 1;
    const response = await etapaStore.setOrdem(current, next);
    if (response.success) {
        toast.success(response.success.titulo);
    } else {
        toast.error(response.error.titulo);
    }
};

// excluir etapa
const showAlertDialog = ref({
    id: 0,
    active: false,
});

const loading = ref(false);
const deleteEtapa = async () => {
    loading.value = !loading.value;

    showAlertDialog.value.active = false;
    const response = await etapaStore.delete(showAlertDialog.value.id);

    if (response.success) {
        showAlertDialog.value.id = 0;
        showAlertDialog.value.active = false;
        loading.value = !loading.value;
        etapaStore.clear();
        toast.success(response.success.titulo);
    } else {
        loading.value = !loading.value;
        toast.error(response.error.titulo);
    }
};

// PARA OPCOES
interface DialogOpcao{
    active: boolean,
    etapa: Etapa | null,
}
const showDialogOpcao = ref<DialogOpcao>({
    active: false,
    etapa: null
});

const addOpcoa = (etapa:Etapa) => {
    showDialogOpcao.value.active = true;
    showDialogOpcao.value.etapa = etapa;
}
</script>

<template>
    <AppLayout page="Etapas">
        <Toaster />
        <LoadingBar :loading="loading" />

        <DialogEtapa :open="showDialog" @close="showDialog = false" />
        <DialogOpcao v-model:open="showDialogOpcao.active" @close="showDialogOpcao.active = false" @update:open="showDialogOpcao.active = false" :etapa="showDialogOpcao.etapa" @added-opcao="(id:Number)=>etapaStore.addCountOpcao(id)"/>

        <AlertDialog :open="showAlertDialog.active">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle
                        >Deseja deletar essa etapa?</AlertDialogTitle
                    >
                    <AlertDialogDescription>
                        Essa ação irá deletar a etapa PARA SEMPRE, tem certeza?
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
                    <AlertDialogAction @click="deleteEtapa"
                        >Continuar</AlertDialogAction
                    >
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

        <header class="menubar">
            <Button variant="outline" @click="showDialog = true" type="button">
                <PlusCircleIcon />
            </Button>
        </header>

        <div class="w-full overflow-x-auto">
            <Table v-if="etapaStore.etapas.length > 0">
                <TableHeader>
                    <TableRow>
                        <TableHead>Ordem</TableHead>
                        <TableHead> Nome </TableHead>
                        <TableHead class="hidden md:table-cell"
                            >Obrigatório</TableHead
                        >
                        <TableHead class="hidden md:table-cell">
                            Multiplas escolhas
                        </TableHead>
                        <TableHead>Mover</TableHead>
                        <TableHead>Opcões</TableHead>
                        <TableHead>
                            Status
                            <TooltipProvider>
                                <Tooltip :delay-duration="1">
                                    <TooltipTrigger as-child>
                                        <Button
                                            variant="ghost"
                                            class="h-10 w-10"
                                            ><InfoIcon />
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        <p>
                                            Este status indica se a etapa está
                                            pronta para uso.<br />
                                            Etapas incompletas não aparecem para
                                            o cliente no pedido.
                                        </p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </TableHead>
                        <TableHead class="text-right"></TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="(etapa, index) in etapaStore.etapas"
                        :key="index"
                    >
                        <TableCell class="font-medium">
                            {{ etapa.ordem }}</TableCell
                        >
                        <TableCell class="capitalize">{{
                            etapa.nome
                        }}</TableCell>
                        <TableCell class="hidden md:table-cell">
                            <Badge
                                variant="secondary"
                                v-if="etapa.required == true"
                                class="bg-blue-500 text-white dark:bg-blue-600"
                            >
                                Sim
                            </Badge>
                            <Badge
                                v-else
                                variant="secondary"
                                class="bg-red-500 text-white dark:bg-red-600"
                            >
                                Não
                            </Badge>
                        </TableCell>
                        <TableCell class="hidden md:table-cell">
                            <Badge
                                variant="secondary"
                                v-if="etapa.multiple == true"
                                class="bg-blue-500 text-white dark:bg-blue-600"
                            >
                                Sim
                            </Badge>
                            <Badge
                                v-else
                                variant="secondary"
                                class="bg-red-500 text-white dark:bg-red-600"
                            >
                                Não
                            </Badge>
                        </TableCell>
                        <TableCell class="">
                            <div class="flex gap-5">
                                <Button
                                    variant="secondary"
                                    v-if="index != 0"
                                    @click="upItem(index)"
                                >
                                    <ArrowUpSquareIcon />
                                </Button>

                                <Button
                                    variant="secondary"
                                    v-if="index != etapaStore.etapas.length - 1"
                                    @click="downItem(index)"
                                >
                                    <ArrowDownSquareIcon />
                                </Button>
                            </div>
                        </TableCell>
                        <TableCell class="hidden font-medium md:table-cell">
                            {{ etapa.opcoes_count }}
                        </TableCell>
                        <TableCell class="hidden md:table-cell">
                            <Badge
                                v-if="etapa.opcoes_count == 0"
                                variant="secondary"
                                class="bg-red-500 text-white uppercase dark:bg-red-600"
                            >
                                <BadgeXIcon class="w-5" />
                                Não configurada
                            </Badge>
                            <Badge
                                v-if="etapa.opcoes_count == 1"
                                class="bg-yellow-500 text-white uppercase dark:bg-yellow-600"
                            >
                                <BadgeAlertIcon class="w-5" />

                                Incompleta
                            </Badge>
                            <Badge
                                variant="secondary"
                                v-if="etapa.opcoes_count >= 2"
                                class="bg-green-500 text-white uppercase dark:bg-green-600"
                            >
                                <BadgeCheckIcon class="w-5" />

                                Configurada
                            </Badge>
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
                                    <DropdownMenuItem @click="editEtapa(etapa)"
                                        ><Edit2Icon /> Editar</DropdownMenuItem
                                    >
                                    <DropdownMenuItem @click="addOpcoa(etapa)"
                                        ><PlusCircleIcon /> Adicionar
                                        Opcão</DropdownMenuItem
                                    >
                                    <DropdownMenuItem
                                        class="bg-red-500"
                                        @click="
                                            ((showAlertDialog.id = etapa.id),
                                            (showAlertDialog.active = true))
                                        "
                                        ><Trash2 />Deletar</DropdownMenuItem
                                    >
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            <Empty
                v-if="etapaStore.etapas.length == 0"
                msg="Nehuma etapa encontrada"
            />
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
