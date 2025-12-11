<script setup lang="ts">
import ProductGrid from './ProductGrid.vue';
import { Produto } from '@/types/types';

// Recebe todos os produtos juntos
const props = defineProps<{
    produtos: Produto[]
}>()
</script>

<template>
    <div class="space-y-6">
        <!-- Grid de produtos da categoria -->
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <ProductGrid
                v-for="p in produtos"
                :key="p.id"
                :nome="p.nome"
                :imagem="p.imagem"
                :categoria="p.categoria"
                :id="p.id"
                :preco="p.valor"
                />
        </div>
    </div>
</template>
