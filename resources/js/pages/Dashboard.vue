<script setup lang="ts">
import CardPedido from '@/components/Dashboard/Home/CardPedido.vue'; //CARD DE PEDIDO PAR A HOME
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import useCofeitariaStrore from '@/stores/ConfeitariaStore';
import { Confeitaria, Pedido } from '@/types/types';
import { CalendarIcon, PackageIcon, ShoppingBagIcon } from 'lucide-vue-next';
import { computed, onMounted, ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
const confeitariaStore = useCofeitariaStrore();
interface Data {
    totalpedidos: number;
    pedidoshoje: number;
    totalprodutos: number;
}

interface Props {
    confeitaria: Confeitaria;
    pedidos: Pedido[];
    data: Data;
}

const props = defineProps<Props>();
confeitariaStore.confeitaria = props.confeitaria;
const totalPedidos = props.data.totalpedidos;
const pedidosHoje = props.data.pedidoshoje;
const totalProdutos = props.data.totalprodutos;

// CONFIGURAR OS PEDIDOS

const pedidos = ref([...props.pedidos]);
const arrPedidos = computed(() => {
    return pedidos.value.filter((pedido) => pedido.status == 'em_progresso');
});

const updateStauts = (pedido: Pedido, status: string) => {
    pedido.status = status;
    arrPedidos;
    return;
};

const audio = new Audio('/assets/notification.mp3');

console.log(window.Echo);
onMounted(() => {
    window.Echo.channel(`confeitaria.1`).listen('NewPedido', () => {
        audio.play();

        toast.warning('Novo pedido! Atualize a página!');
    });
});
</script>

<template>
    <AppLayout page="Home">
        <Toaster position="bottom-center" />
        <!-- CARDS -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Total de pedidos -->
            <Card class="rounded-xl">
                <CardHeader
                    class="flex flex-row items-center justify-between pb-2"
                >
                    <CardTitle class="text-sm font-medium">
                        Pedidos totais
                    </CardTitle>
                    <PackageIcon class="h-5 w-5 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ totalPedidos }}
                    </div>
                </CardContent>
            </Card>
            <!-- Pedidos hoje -->
            <Card class="rounded-xl">
                <CardHeader
                    class="flex flex-row items-center justify-between pb-2"
                >
                    <CardTitle class="text-sm font-medium">
                        Pedidos hoje
                    </CardTitle>
                    <CalendarIcon class="h-5 w-5 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ pedidosHoje }}
                    </div>
                </CardContent>
            </Card>
            <!-- Produtos cadastrados -->
            <Card class="rounded-xl">
                <CardHeader
                    class="flex flex-row items-center justify-between pb-2"
                >
                    <CardTitle class="text-sm font-medium">
                        Produtos ativos
                    </CardTitle>
                    <ShoppingBagIcon class="h-5 w-5 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ totalProdutos }}
                    </div>
                </CardContent>
            </Card>
        </div>
        <div class="flex w-full flex-col gap-3">
            <!-- Título -->
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold">Pedidos do dia</h2>
                <span class="text-xs text-muted-foreground">
                    {{ arrPedidos.length }} pedidos
                </span>
            </div>
            <!-- Lista de cards -->
            <div
                v-if="arrPedidos.length > 0"
                class="flex max-w-full snap-x snap-mandatory flex-row gap-3 overflow-x-auto pb-4 whitespace-nowrap md:flex-wrap"
            >
                <CardPedido
                    v-for="pedido in arrPedidos"
                    :key="pedido.id"
                    :pedido="pedido"
                    @update-status="updateStauts"
                />
            </div>
            <!-- Estado vazio -->
            <div
                v-else
                class="flex items-center justify-center rounded-lg border border-dashed p-6 text-sm text-muted-foreground"
            >
                Nenhum pedido hoje 🍰
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.cardAnalytic {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 1rem;
    background: var(--card, #fff);
    color: var(--foreground, #000);
    border: 1px solid var(--border, #000);
}

.icon-wrapper {
    padding: 0.75rem;
    border-radius: 9999px;
    background: var(--muted, #000);
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon {
    width: 24px;
    height: 24px;
    color: #fff;
}

.text-wrapper {
    display: flex;
    flex-direction: column;
}

.label {
    font-size: 0.875rem;
    opacity: 0.7;
}

.value {
    font-size: 1.75rem;
    font-weight: bold;
    line-height: 1;
}
</style>
