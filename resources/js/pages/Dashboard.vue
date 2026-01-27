<script setup lang="ts">
import CardEncomenda from '@/components/Dashboard/Home/CardEncomenda.vue';
import CardPedido from '@/components/Dashboard/Home/CardPedido.vue'; //CARD DE PEDIDO PAR A HOME
import ButtonGroup from '@/components/ui/button-group/ButtonGroup.vue';
import ButtonGroupSeparator from '@/components/ui/button-group/ButtonGroupSeparator.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import useCofeitariaStrore from '@/stores/ConfeitariaStore';
import { Confeitaria, Encomenda, Pedido } from '@/types/types';
import {
    ArrowBigRightDashIcon,
    CalendarIcon,
    CopyIcon,
    Link,
    PackageIcon,
    ShoppingBagIcon,
} from 'lucide-vue-next';
import { computed, onMounted, ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
const confeitariaStore = useCofeitariaStrore();

interface Data {
    entregasHoje: number;
    proximasEntregas: number;
    produtosTotais: number;
}

interface Props {
    confeitaria: Confeitaria;
    pedidos: Pedido[];
    data: Data;
    encomendas: Encomenda[];
}

const props = defineProps<Props>();
confeitariaStore.confeitaria = props.confeitaria;
const entregasHoje = props.data.entregasHoje;
const proximasEntregas = props.data.proximasEntregas;
const produtosTotais = props.data.produtosTotais;

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

// CONFIGURAR ENCOMENDAS
const encomendas = ref(props.encomendas);
const arrEncomendas = computed(() => {
    return encomendas.value.filter(
        (encomenda) => encomenda.status == 'em_progresso',
    );
});

const updateStatusEncomenda = (encomenda: Encomenda, status: string) => {
    encomenda.status = status;
    arrEncomendas;
    return;
};

// url para o app
const urlApp = `https://app.bakerfast.com.br/${confeitariaStore.confeitaria.slug}`;
const copyLink = async () => {
    try {
        await navigator.clipboard.writeText(urlApp);
        toast.success('Link copiado!');
    } catch (err) {
        toast.error('Erro ao copiar!');
    }
};
</script>

<template>
    <AppLayout page="Home">
        <Toaster position="bottom-center" />

        <!-- CARD PARA O LINK DO APP -->
        <Card class="rounded-xl border bg-background">
            <CardHeader
                class="flex flex-row items-center justify-between space-y-0 pb-2"
            >
                <div class="flex items-center gap-2">
                    <Link class="h-5 w-5 text-muted-foreground" />
                    <CardTitle class="text-sm font-semibold">
                        Link para o App
                    </CardTitle>
                </div>
            </CardHeader>

            <CardContent
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <!-- Texto -->
                <div class="max-w-md space-y-1">
                    <p class="text-sm text-muted-foreground">
                        Compartilhe este link com seus clientes para receber
                        <span class="font-medium text-foreground"
                            >pedidos e encomendas</span
                        >
                        diretamente no sistema.
                    </p>
                </div>

                <!-- Ações -->
                <ButtonGroup class="w-full sm:w-auto">
                    <Button variant="outline" @click="copyLink">
                        <CopyIcon class="mr-2 h-4 w-4" />
                        Copiar link
                    </Button>

                    <ButtonGroupSeparator />

                    <Button variant="secondary" as-child>
                        <a :href="urlApp" target="_blank">
                            Acessar
                            <ArrowBigRightDashIcon class="ml-2 h-4 w-4" />
                        </a>
                    </Button>
                </ButtonGroup>
            </CardContent>
        </Card>

        <!-- CARDS -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <Card class="rounded-xl">
                <CardHeader
                    class="flex flex-row items-center justify-between pb-2"
                >
                    <CardTitle class="text-sm font-medium">
                        Entregas Hoje (Pedidos + Encomendas)
                    </CardTitle>
                    <PackageIcon class="h-5 w-5 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ entregasHoje }}
                    </div>
                </CardContent>
            </Card>
            <Card class="rounded-xl">
                <CardHeader
                    class="flex flex-row items-center justify-between pb-2"
                >
                    <CardTitle class="text-sm font-medium">
                        Proxímas Entregas (até 5 dias)
                    </CardTitle>
                    <CalendarIcon class="h-5 w-5 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ proximasEntregas }}
                    </div>
                </CardContent>
            </Card>
            <Card class="rounded-xl">
                <CardHeader
                    class="flex flex-row items-center justify-between pb-2"
                >
                    <CardTitle class="text-sm font-medium">
                        Produtos Totais
                    </CardTitle>
                    <ShoppingBagIcon class="h-5 w-5 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ produtosTotais }}
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
        <div class="flex w-full flex-col gap-3">
            <!-- Título -->
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold">Encomendas</h2>
                <span class="text-xs text-muted-foreground">
                    {{ arrEncomendas.length }} Encomendas
                </span>
            </div>
            <!-- Lista de cards -->
            <div
                v-if="arrEncomendas.length > 0"
                class="flex max-w-full snap-x snap-mandatory flex-row gap-3 overflow-x-auto pb-4 whitespace-nowrap md:flex-wrap"
            >
                <CardEncomenda
                    v-for="(encomenda, index) in arrEncomendas"
                    :key="index"
                    :encomenda="encomenda"
                    @updateStatus="updateStatusEncomenda"
                />
            </div>
            <!-- Estado vazio -->
            <div
                v-else
                class="flex items-center justify-center rounded-lg border border-dashed p-6 text-sm text-muted-foreground"
            >
                Nenhuma  🎂
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
