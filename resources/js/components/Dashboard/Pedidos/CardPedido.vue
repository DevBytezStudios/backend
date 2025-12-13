<script setup lang="ts">
import { computed, ref } from 'vue';

import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { TimerIcon, User2Icon } from 'lucide-vue-next';
import CardCliente from './CardCliente.vue';

/* =========================
   DADOS FALSOS (MOCK)
   ========================= */

const pedido = {
    codigo: '123ABC',
    data: '12 Jul 2025 • 18:12',
    pagamento: 'PIX',
};

const cliente = {
    nome: 'João Silva',
    telefone: '(11) 99999-9999',
    rua: 'Rua das Flores',
    numero: 123,
    bairro: 'Centro',
    cidade: 'São Paulo',
    complemento: 'Apto 45',
};

const itens = [
    {
        id: 1,
        quantidade: 1,
        produto: {
            nome: 'Bolo de Chocolate',
            valor: 45.0,
        },
        opcao: {
            nome: 'Recheio de Morango',
            valor: 5.0,
        },
    },
    {
        id: 2,
        quantidade: 2,
        produto: {
            nome: 'Cupcake Gourmet',
            valor: 12.0,
        },
        opcao: {
            nome: 'Cobertura Extra',
            valor: 3.0,
        },
    },
];

/* ========================= */

const open = ref(false);

const total = computed(() =>
    itens.reduce((acc, item) => {
        const base = item.produto.valor;
        const extra = item.opcao?.valor ?? 0;
        return acc + (base + extra) * item.quantidade;
    }, 0),
);

const dialogCliente = ref(false);
</script>

<template>
    <Card class="w-full text-sm sm:w-[280px]">
        <!-- Header -->
        <CardHeader class="space-y-0.5 pb-3">
            <div class="flex items-center justify-between">
                <CardTitle class="text-sm font-semibold">
                    Pedido {{ pedido.codigo }}
                </CardTitle>

                <div class="flex items-center gap-1">
                    <Badge variant="secondary" class="px-2 py-0 text-xs">
                        {{ pedido.pagamento }}
                    </Badge>

                    <Badge
                        variant="outline"
                        class="flex items-center gap-1 px-2 py-0 text-xs"
                    >
                        <TimerIcon class="h-3 w-3" />
                        Em prog.
                    </Badge>
                </div>
            </div>

            <CardDescription class="text-xs">
                {{ pedido.data }}
            </CardDescription>
        </CardHeader>

        <Separator />

        <!-- Itens -->
        <CardContent class="space-y-2 pt-3 text-xs">
            <div v-for="item in itens" :key="item.id" class="space-y-0.5">
                <div class="flex justify-between font-medium">
                    <span class="max-w-[130px] truncate">
                        {{ item.produto.nome }}
                    </span>
                    <span>x{{ item.quantidade }}</span>
                </div>

                <div class="text-muted-foreground">+ {{ item.opcao.nome }}</div>
            </div>
        </CardContent>

        <Separator />

        <CardFooter class="flex items-center justify-between pt-3 bg-muted/10">
            <!-- Total -->
            <div class="flex flex-col leading-tight">
                <span class="text-xs text-muted-foreground"> Total </span>
                <span class="text-sm font-semibold">
                    R$ {{ total.toFixed(2) }}
                </span>
            </div>

            <!-- Ações -->
            <div class="flex items-center gap-2">
                <Button
                    variant="outline"
                    size="sm"
                    class="text-xs"
                    @click="dialogCliente = true"
                >
                    <User2Icon class="h-4 w-4" />
                </Button>

                <!-- <Button size="sm" class="text-xs"> Detalhes </Button> -->
            </div>
        </CardFooter>

        <CardCliente
            :open="dialogCliente"
            :cliente="cliente"
            :code="pedido.codigo"
            @close="dialogCliente = false"
        />
    </Card>
</template>
