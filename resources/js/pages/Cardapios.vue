<script setup lang="ts">
import CardCardapio from '@/components/Dashboard/Cardapio/CardCardapio.vue';
import CardNewCardapio from '@/components/Dashboard/Cardapio/CardNewCardapio.vue';
import DialogCardapio from '@/components/Dashboard/Cardapio/DialogCardapio.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Cardapio } from '@/types/types';
import { ref } from 'vue';

const listaCardapios = ref<Cardapio[]>([
    {
        id: 1,
        id_con: 10,
        titulo: 'Coleção de Verão 2026',
        cor_princ: '#FF8C94',
        cor_sec: '#FFAAA5',
        dt_inicio: '2026-01-01',
        dt_fim: '2026-03-31',
        active: true,
    },
    {
        id: 2,
        id_con: 10,
        titulo: 'Especial Páscoa',
        cor_princ: '#B19CD9',
        cor_sec: '#FFB7B2',
        dt_inicio: '2026-03-15',
        dt_fim: '2026-04-12',
        active: false,
    },
    {
        id: 3,
        id_con: 10,
        titulo: 'Cardápio Clássico',
        cor_princ: '#4A2C2A',
        cor_sec: '#D4AF37',
        dt_inicio: '2026-01-01',
        dt_fim: '2026-12-31',
        active: true,
    },
    {
        id: 4,
        id_con: 10,
        titulo: 'Festival de Inverno',
        cor_princ: '#2C3E50',
        cor_sec: '#ECF0F1',
        dt_inicio: '2026-06-01',
        dt_fim: '2026-08-31',
        active: false,
    },
    {
        id: 5,
        id_con: 10,
        titulo: 'Doces Finos Wedding',
        cor_princ: '#FDF5E6',
        cor_sec: '#FFD700',
        dt_inicio: '2026-01-01',
        dt_fim: '2026-12-31',
        active: true,
    },
]);
</script>

<template>
    <AppLayout page="Cardápios">
        <DialogCardapio/>
        <div class="flex max-w-full flex-wrap gap-10">
            <CardNewCardapio/>
            <CardCardapio v-for="(cardapio, index) in listaCardapios" :cardapio="cardapio" :key="index"/>
        </div>
    </AppLayout>
</template>
