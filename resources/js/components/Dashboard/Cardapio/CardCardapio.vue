<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Cardapio } from '@/types/types';
import { Link } from '@inertiajs/vue3';
import {
    Calendar1Icon,
    Edit2Icon,
    Trash2Icon,
    UtensilsCrossedIcon,
} from 'lucide-vue-next';

interface Props {
    cardapio: Cardapio;
}

const props = defineProps<Props>();
const formatDate = (dataStr: string) => {
    const date = new Date(dataStr + 'T03:00:00');
    return date.toLocaleDateString('pt-BR');
};
const emits = defineEmits(['edit', 'delete']);
</script>

<template>
    <Card
        class="group h-fit w-full overflow-hidden rounded-xl border bg-card text-card-foreground shadow-lg transition-all hover:shadow-md sm:w-[300px]"
        :style="{
            borderColor: cardapio.cor_princ,
            boxShadow: `0 10px 15px -3px ${cardapio.cor_princ}44, 0 4px 6px -4px ${cardapio.cor_princ}44`,
        }"
    >
        <Link
            :href="`/cardapios/${cardapio.titulo.trim()}`"
            class="block h-full w-full cursor-pointer focus:outline-none"
        >
            <div
                class="relative flex h-40 w-full items-center justify-center bg-muted/50 transition-colors group-hover:bg-muted/70"
            >
                <Badge
                    variant="default"
                    v-if="
                        props.cardapio.active
                    "
                    class="pointer-events-none absolute top-3 right-3 bg-green-500 text-[10px] font-bold uppercase"
                >
                    Ativo
                </Badge>
                <Badge
                    v-else
                    variant="default"
                    class="pointer-events-none absolute top-3 right-3 bg-red-500 text-[10px] font-bold uppercase"
                >
                    Oculto
                </Badge>

                <div
                    class="flex h-16 w-16 items-center justify-center rounded-full border bg-background shadow-sm transition-transform group-hover:scale-105"
                    :style="{ background: cardapio.cor_princ }"
                >
                    <UtensilsCrossedIcon
                        class="h-8 w-8 text-muted-foreground"
                    />
                </div>
            </div>

            <div class="space-y-4 p-5">
                <CardHeader class="p-0">
                    <CardTitle
                        class="text-lg font-bold tracking-tight transition-colors group-hover:text-primary"
                    >
                        {{ cardapio.titulo }}
                    </CardTitle>
                </CardHeader>

                <div
                    class="flex items-center gap-2 text-xs text-muted-foreground"
                >
                    <Calendar1Icon class="h-4 w-4" />
                    <span
                        >{{ formatDate(cardapio.dt_inicio) }} — {{ formatDate(cardapio.dt_fim) }}</span
                    >
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex -space-x-2">
                        <div
                            class="h-7 w-7 rounded-full border-2 border-background shadow-sm"
                            :style="{ backgroundColor: cardapio.cor_princ }"
                        ></div>

                        <div
                            class="h-7 w-7 rounded-full border-2 border-background shadow-sm"
                            :style="{ backgroundColor: cardapio.cor_sec }"
                        ></div>
                    </div>
                </div>
            </div>
        </Link>

        <CardFooter
            class="relative z-10 grid grid-cols-2 overflow-hidden border-t p-0"
            :style="{ borderColor: `${cardapio.cor_princ}33` }"
        >
            <Button
                variant="ghost"
                class="flex h-full items-center justify-center gap-2 rounded-none border-r bg-transparent py-6 text-sm font-semibold transition-colors hover:bg-muted"
                :style="{ borderColor: `${cardapio.cor_princ}33` }"
                @click="$emit('edit', cardapio)"
            >
                <Edit2Icon class="h-4 w-4" />
                Editar
            </Button>

            <Button
                variant="ghost"
                class="flex h-full items-center justify-center gap-2 rounded-none bg-transparent py-6 text-sm font-semibold text-destructive transition-colors hover:bg-destructive/10"
                @click="$emit('delete', cardapio.id)"
            >
                <Trash2Icon class="h-4 w-4" />
                Deletar
            </Button>
        </CardFooter>
    </Card>
</template>
