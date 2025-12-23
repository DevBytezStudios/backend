<script setup lang="ts">
import { ref } from 'vue';

import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Separator } from '@/components/ui/separator';
import { Encomenda } from '@/types/types';
import axios from 'axios';
import { Trash2Icon, User2Icon } from 'lucide-vue-next';
import CardCliente from '../CardCliente.vue';

interface Props {
    encomenda: Encomenda;
}

const props = defineProps<Props>();
const statusEncomenda = ref(props.encomenda.status);
const open = ref(false);
const dialogCliente = ref(false);
const statusOptions = [
    { value: 'em_progresso', label: 'Em progresso' },
    { value: 'concluido', label: 'Concluído' },
    { value: 'cancelado', label: 'Cancelado' },
];

const emit = defineEmits(['updateStatus', 'deleteencomenda']);
const updateStatus = async () => {
    await atualizarStatus();
    emit('updateStatus', props.encomenda, statusEncomenda.value);
};

function calcularTotal(encomenda: Encomenda): number {
    return encomenda.opcoes.reduce((total, item) => {
        const valorProduto =
            item.valor !== null && item.valor !== undefined
                ? Number(item.valor)
                : Number(item.valor);

        // subtotal do item
        const subtotal =
            valorProduto + parseFloat(encomenda.estilo.valor.toString());

        return total + subtotal;
    }, 0);
}

const atualizarStatus = async () => {
    try {
        const response = await axios.post('/encomenda/updatestatus', {
            id: props.encomenda.id,
            status: statusEncomenda.value,
        });
    } catch ($error) {
        console.log($error);
    }
};

function diasRestantes(dataEntrega: string | Date): number {
    const hoje = new Date();
    const entrega = new Date(dataEntrega);

    // Zera horas pra evitar bug de fuso
    hoje.setHours(0, 0, 0, 0);
    entrega.setHours(0, 0, 0, 0);

    const minutos = entrega.getTime() - hoje.getTime();
    let dias = Math.ceil(minutos / (1000 * 60 * 60 * 24));

    if(dias < 0){
        dias = 0;
    }
    return dias;
}

</script>

<template>
    <Card class="h-fit w-full text-sm sm:w-[320px]">
        <!-- HEADER -->
        <CardHeader class="space-y-0.5 pb-3">
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <CardTitle class="text-sm font-semibold">
                        Encomenda {{ props.encomenda.code }}
                    </CardTitle>

                    <span class="text-xs text-muted-foreground">
                        Para:
                        {{
                            new Date(
                                props.encomenda.data_entrega,
                            ).toLocaleDateString('pt-BR')
                        }}
                    </span>
                </div>

                <div class="flex items-center gap-1">
                    <!-- Pagamento -->
                    <Badge variant="secondary" class="px-2 py-0 text-xs">
                        {{ encomenda.pagamento }}
                    </Badge>

                    <!-- Status (editável) -->
                    <Select
                        v-model="statusEncomenda"
                        @update:model-value="updateStatus"
                    >
                        <SelectTrigger class="h-6 border-dashed px-2 text-xs">
                            <SelectValue />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem
                                v-for="status in statusOptions"
                                :key="status.value"
                                :value="status.value"
                            >
                                {{ status.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>
        </CardHeader>
        <Separator />

        <!-- ESTILO DO BOLO -->
        <CardContent class="space-y-2 pt-3">
            <div class="flex items-center gap-3 rounded-md bg-muted/40 p-2">
                <img
                    :src="encomenda.estilo.imagem"
                    alt="Estilo do bolo"
                    class="h-12 w-12 rounded-md object-cover"
                />

                <div>
                    <p class="text-xs text-muted-foreground">Estilo</p>
                    <p class="text-sm font-medium">
                        {{ encomenda.estilo.titulo }}
                    </p>
                     <p class="text-xs text-muted-foreground">Valor</p>
                    <p class="text-sm font-medium">
                        {{  new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL',
                        }).format(encomenda.estilo.valor) }}
                    </p>
                </div>
            </div>
        </CardContent>

        <Separator />

        <!-- ITENS DA ENCOMENDA -->
        <CardContent class="max-h-44 space-y-3 overflow-auto pt-3 text-xs">
            <div
                v-for="item in encomenda.opcoes"
                :key="item.id"
                class="space-y-1 rounded-md border p-2"
            >
                <div class="flex justify-between text-muted-foreground">
                    <span>{{ item.etapa }}</span>
                    <span>{{ item.nome }}</span>
                </div>
            </div>
        </CardContent>

        <Separator />

        <!-- FOOTER -->
        <CardFooter
            class="flex flex-wrap items-center justify-between bg-muted/10 pt-3"
        >
            <div class="flex flex-col leading-tight">
                <span class="text-xs text-muted-foreground"> Total </span>
                <span class="text-sm font-semibold">
                    {{
                        new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL',
                        }).format(calcularTotal(encomenda))
                    }}
                </span>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="text-xs text-muted-foreground">
                    Dias restantes:
                </span>

                <span
                    class="text-sm font-semibold"
                    :class="
                        diasRestantes(props.encomenda.data_entrega) <= 0
                            ? 'text-red-500'
                            : diasRestantes(props.encomenda.data_entrega) <= 2
                              ? 'text-yellow-500'
                              : ''
                    "
                >
                    {{ diasRestantes(props.encomenda.data_entrega) }} dias
                </span>
            </div>

            <div class="flex items-center gap-2">
                <Button
                    variant="destructive"
                    size="icon"
                    @click="emit('deleteencomenda')"
                >
                    <Trash2Icon class="h-4 w-4" />
                </Button>

                <Button
                    variant="outline"
                    size="icon"
                    @click="dialogCliente = true"
                >
                    <User2Icon class="h-4 w-4" />
                </Button>
            </div>
        </CardFooter>

        <CardCliente
            :open="dialogCliente"
            :cliente="encomenda.cliente"
            :code="encomenda.code"
            @close="dialogCliente = false"
        />
    </Card>
</template>
