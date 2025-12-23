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
import { Pedido } from '@/types/types';
import axios from 'axios';
import { Trash2Icon, User2Icon } from 'lucide-vue-next';
import CardCliente from '../CardCliente.vue';

interface Props {
    pedido: Pedido;
}

const props = defineProps<Props>();
const statusPedido = ref(props.pedido.status);
const open = ref(false);
const dialogCliente = ref(false);
const statusOptions = [
    { value: 'em_progresso', label: 'Em progresso' },
    { value: 'concluido', label: 'Concluído' },
    { value: 'cancelado', label: 'Cancelado' },
];

const emit = defineEmits(['updateStatus','deletePedido']);
const updateStatus = async () =>  {
    await atualizarStatus();
    emit('updateStatus', props.pedido, statusPedido.value);
};

function calcularTotal(pedido: Pedido): number {
    return pedido.pedidoItem.reduce((total, item) => {
        // valor do produto (prioriza valor_desc)
        const valorProduto =
            item.produto.valor_desc !== null &&
            item.produto.valor_desc !== undefined
                ? Number(item.produto.valor_desc)
                : Number(item.produto.valor);

        // soma das opções
        const totalOpcoes = item.opcoes.reduce(
            (soma, opcao) => soma + Number(opcao.valor),
            0,
        );

        // subtotal do item
        const subtotal = (valorProduto + totalOpcoes) * item.quantidade;

        return total + subtotal;
    }, 0);
}

const atualizarStatus = async () => {
    try {
        const response = await axios.post('/catalogo/pedidos/updatestatus', {
            id: props.pedido.id,
            status: statusPedido.value,
        });
    } catch ($error) {
        console.log($error);
    }
};

</script>

<template>
    <Card class="h-fit w-full text-sm sm:w-[300px]">
        <!-- Header -->
        <CardHeader class="space-y-0.5 pb-3">
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <CardTitle class="text-sm font-semibold">
                        Pedido {{ props.pedido.code }}
                    </CardTitle>

                    <span class="text-xs text-muted-foreground">
                        {{
                            new Date(props.pedido.data).toLocaleDateString(
                                'pt-BR',
                            )
                        }}
                    </span>
                </div>

                <div class="flex items-center gap-1">
                    <!-- Pagamento -->
                    <Badge variant="secondary" class="px-2 py-0 text-xs">
                        {{ pedido.pagamento }}
                    </Badge>

                    <!-- Status (editável) -->
                    <Select
                        v-model="statusPedido"
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

        <!-- Itens -->
        <CardContent class="h-40 space-y-2 overflow-auto pt-3 text-xs">
            <div
                v-for="item in pedido.pedidoItem"
                :key="item.id"
                class="space-y-0.5"
            >
                <div class="flex justify-between font-medium">
                    <span class="max-w-[130px] truncate">
                        {{ item.produto.nome }}
                    </span>
                    <span>x{{ item.quantidade }}</span>
                </div>

                <div
                    class="text-muted-foreground"
                    v-for="(opcao, index) in item.opcoes"
                    :key="index"
                >
                    + {{ opcao.nome }}
                </div>
            </div>
        </CardContent>

        <Separator />

        <CardFooter class="flex items-center justify-between bg-muted/10 pt-3">
            <!-- Total -->
            <div class="flex flex-col leading-tight">
                <span class="text-xs text-muted-foreground"> Total </span>
                <span class="text-sm font-semibold">
                    {{
                        new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL',
                        }).format(calcularTotal(pedido))
                    }}
                </span>
            </div>

            <!-- Ações -->
            <div class="flex items-center gap-2">
                <Button variant="destructive" class="h-10 w-10" @click="emit('deletePedido')">
                    <Trash2Icon />
                </Button>
                <Button
                    variant="outline"
                    size="sm"
                    class="h-10 w-10"
                    @click="dialogCliente = true"
                >
                    <User2Icon />
                </Button>

                <!-- <Button size="sm" class="text-xs"> Detalhes </Button> -->
            </div>
        </CardFooter>

        <CardCliente
            :open="dialogCliente"
            :cliente="pedido.cliente"
            :code="pedido.code"
            @close="dialogCliente = false"
        />
    </Card>
</template>
