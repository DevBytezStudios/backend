<script setup lang="ts">
import CardPedido from '@/components/Dashboard/Pedidos/CardPedido.vue';
import AppLayout from '@/layouts/AppLayout.vue';
</script>


<template>
    <AppLayout page="Pedidos">

        <div class="w-full flex flex-row gap-5 flex-wrap">
            <CardPedido/>
            <CardPedido/>
            <CardPedido/>
            <CardPedido/>
            <CardPedido/>
            <CardPedido/>
        </div>
    </AppLayout>
</template>