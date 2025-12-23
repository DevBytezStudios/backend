<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

import {
    Pagination,
    PaginationContent,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

import { Badge } from '@/components/ui/badge';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';

import { Edit2Icon, PlusCircle, Trash2 } from 'lucide-vue-next';

import DialogOpcao from '@/components/Dashboard/Encomendas/DialogOpcao.vue';
import { ButtonGroup } from '@/components/ui/button-group';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import useOpcaoStore from '@/stores/Encomenda/OpcaoStore';
import { EncomendaOpcoes, OpcaoEtapa, Paginator } from '@/types/types';
import { SearchIcon } from 'lucide-vue-next';
import { ref } from 'vue';

const showDialog = ref(false);
const loading = ref(false);

interface Props {
    opcoes: OpcaoEtapa[];
    paginator: Paginator;
}
// NAGEVAÇÂO DE PAGINAS
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { toast } from 'vue-sonner';
import { Toaster } from '@/components/ui/sonner';
const navigate = (url: string | null) => {
    if (!url) return;
    router.get(url);
};

const props = defineProps<Props>();
const opcaoStore = useOpcaoStore();
opcaoStore.opcoes = props.opcoes;

const filterValue = ref('nome');
const searchValue = ref('');
const pesquisando = ref(false);
const opcoesPesquisa = ref<OpcaoEtapa[]>([]);
let searchTimeout: number | null = null;

const searchOpcoes = async () => {
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
                formData.append('filtro', filterValue.value);

                const response = await axios.post<OpcaoEtapa[]>(
                    '/encomenda/opcoes/search',
                    formData,
                );

                console.log(response.data)
                opcoesPesquisa.value = response.data;

                loading.value = false;

                // SE NÃO ACHAR NADA
                if (opcoesPesquisa.value.length == 0) {
                    toast.warning('Nada Encontrado!...');
                }
            }, 500);
        } else {
            opcoesPesquisa.value = [];
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
    <AppLayout page="Opções">
        <Toaster theme="system"/>
        <DialogOpcao :open="showDialog" @close="showDialog = false" />
        <header class="menubar">
            <ButtonGroup class="w-full">
                <Input placeholder="Pesquisar..." v-model="searchValue" @input="searchOpcoes" />
                <Button variant="outline" aria-label="Search" @click="searchOpcoes">
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
                        <SelectItem value="etapa"> Etapa </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
            <Button
                variant="outline"
                @click="(opcaoStore.getEtapas(), (showDialog = true))"
                type="button"
            >
                <PlusCircle />
            </Button>
        </header>

        <div class="h-full w-full overflow-x-auto">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Etapa</TableHead>
                        <TableHead> Nome </TableHead>
                        <TableHead> Valor </TableHead>
                        <TableHead class="hidden md:table-cell">
                            Descrição
                        </TableHead>
                        <TableHead class="hidden md:table-cell"
                            >Ativa</TableHead
                        >
                        <TableHead class="text-right"></TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-if="opcoesPesquisa.length == 0"
                        v-for="(opcao, index) in opcaoStore.opcoes"
                        :key="index"
                    >
                        <TableCell class="font-medium"
                            >{{ opcao.etapa.nome }}
                        </TableCell>
                        <TableCell>{{ opcao.nome }}</TableCell>
                        <TableCell>
                            {{
                            
                                  opcao.valor != 0 ? new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                                }).format(opcao.valor) : "-"
                                
                            }}
                        </TableCell>
                        <TableCell class="hidden md:table-cell">
                            {{ opcao.descricao }}
                        </TableCell>
                        <TableCell class="hidden md:table-cell">
                            <Badge
                                variant="secondary"
                                class="bg-green-500 dark:bg-green-600"
                                v-if="opcao.active == true"
                            >
                                Sim
                            </Badge>

                            <Badge
                                variant="secondary"
                                class="bg-red-500 dark:bg-red-600"
                                v-else
                            >
                                Não
                            </Badge>
                        </TableCell>
                        <TableCell class="hidden md:table-cell"> </TableCell>
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
                                    <DropdownMenuItem
                                        @click="
                                            ((opcaoStore.opcao = opcao),
                                            opcaoStore.getEtapas(),
                                            (showDialog = true))
                                        "
                                        ><Edit2Icon /> Editar</DropdownMenuItem
                                    >
                                    <DropdownMenuItem class="bg-red-500"
                                        ><Trash2 />Deletar</DropdownMenuItem
                                    >
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                    <TableRow
                        v-if="opcoesPesquisa.length != 0"
                        v-for="(opcao, index) in opcoesPesquisa"
                        :key="index"
                    >
                        <TableCell class="font-medium"
                            >{{ opcao.etapa.nome }}
                        </TableCell>
                        <TableCell>{{ opcao.nome }}</TableCell>
                        <TableCell>
                            {{
                            
                                  opcao.valor != 0 ? new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                                }).format(opcao.valor) : "-"
                                
                            }}
                        </TableCell>
                        <TableCell class="hidden md:table-cell">
                            {{ opcao.descricao }}
                        </TableCell>
                        <TableCell class="hidden md:table-cell">
                            <Badge
                                variant="secondary"
                                class="bg-green-500 dark:bg-green-600"
                                v-if="opcao.active == true"
                            >
                                Sim
                            </Badge>

                            <Badge
                                variant="secondary"
                                class="bg-red-500 dark:bg-red-600"
                                v-else
                            >
                                Não
                            </Badge>
                        </TableCell>
                        <TableCell class="hidden md:table-cell"> </TableCell>
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
                                    <DropdownMenuItem
                                        @click="
                                            ((opcaoStore.opcao = opcao),
                                            opcaoStore.getEtapas(),
                                            (showDialog = true))
                                        "
                                        ><Edit2Icon /> Editar</DropdownMenuItem
                                    >
                                    <DropdownMenuItem class="bg-red-500"
                                        ><Trash2 />Deletar</DropdownMenuItem
                                    >
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
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
