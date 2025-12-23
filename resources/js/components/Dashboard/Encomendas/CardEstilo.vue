<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Estilo } from '@/types/types';
import { Edit2Icon, Trash2Icon } from 'lucide-vue-next';

interface Props {
    estilo: Estilo;
}

const props = defineProps<Props>();

const emit = defineEmits(['editEstilo','delete'])

// dados fake para teste
// const estilo = {
//   nome: 'Tema Floral',
//   descricao: 'Decoração delicada com flores artificiais ou naturais.',
//   imagem: 'https://images.unsplash.com/photo-1607478900766-efe13248b125',
//   valor: 99.99
// }
</script>

<template>
    <Card class="h-fit w-full rounded-lg border text-sm sm:w-[300px]">
        <!-- Header com imagem -->
        <CardHeader class="p-0">
            <img
                :src="estilo.imagem"
                alt="Estilo do bolo"
                class="h-50 w-full rounded-sm object-cover"
            />
        </CardHeader>

        <div class="space-y-2 p-4">
            <CardTitle class="text-base">
                {{ estilo.titulo }}
            </CardTitle>

            <CardDescription
                class="line-clamp-2 text-sm leading-snug text-wrap"
            >
                {{ estilo.descricao }}
            </CardDescription>

            <div class="pt-1 text-sm font-medium">
                <span class="text-muted-foreground">Valor:</span>
                <span class="ml-1"
                    >{{
                        estilo.valor != 0
                            ? new Intl.NumberFormat('pt-BR', {
                                  style: 'currency',
                                  currency: 'BRL',
                              }).format(estilo.valor)
                            : '-'
                    }}
                </span>
            </div>

            <div class="pt-1 text-sm font-medium">
                <span class="text-muted-foreground">Ativo:</span>
                <span class="ml-1">
                    <Badge
                        variant="secondary"
                        class="bg-green-500 dark:bg-green-600"
                        v-if="estilo.active == true"
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
                </span>
            </div>
        </div>

        <CardFooter
            class="flex items-center justify-between gap-2 px-4 pt-0 pb-4"
        >
            <Button size="sm" class="flex-1" @click="emit('editEstilo',props.estilo)">
                <Edit2Icon class="mr-1 h-4 w-4" />
                Editar
            </Button>

            <Button size="icon" variant="destructive" class="h-9 w-9" @click="emit('delete',props.estilo.id)">
                <Trash2Icon class="h-4 w-4" />
            </Button>
        </CardFooter>
    </Card>
</template>
