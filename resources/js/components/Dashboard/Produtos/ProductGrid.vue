<script setup lang="ts">
const props = defineProps<{
    id: number;
    nome: string;
    preco: number;
    imagem: string;
    categoria: string;
}>();

import { Button } from '@/components/ui/button';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import { EditIcon } from 'lucide-vue-next';
</script>

<template>
    <Card class="card">
        <CardHeader>
            <img src="" alt="">
        </CardHeader>
        <CardContent>
            <CardTitle>Produto</CardTitle>
        </CardContent>
        <CardFooter class="w-max flex flex-row gap-2.5">
            <Button>
                <EditIcon/>
            </Button>
            <Button class="w-full bg-red-300">
                Deletar
            </Button>
        </CardFooter>
    </Card>
</template>

<style scoped>
    .card{
        width: 180px;
        height: 240px;
    }
</style>
