<script setup lang="ts">
import AccordionContent from '@/components/ui/accordion/AccordionContent.vue';
import AccordionItem from '@/components/ui/accordion/AccordionItem.vue';
import AccordionTrigger from '@/components/ui/accordion/AccordionTrigger.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import { Categoria } from '@/types/types';
import { ArrowDown, ArrowUp, EditIcon, PlusCircle } from 'lucide-vue-next';
import CardProduto from './CardProduto.vue';
import DialogProduto from './DialogProduto.vue';
import useDialogCategoria from '@/stores/Cardapio/DialogCategoriaStore';

interface Props {
    color: {
        princ: string;
        sec: string;
    };
    categoria: Categoria;
}

const props = defineProps<Props>();
const emits = defineEmits(['addProduto','up','down','edit']);
const dialogCategoria = useDialogCategoria();



</script>

<template>
    <AccordionItem
        :value="categoria.titulo"
        class="overflow-hidden rounded-xl border border-primary bg-muted/10 shadow-sm"
        :style="{ borderColor: props.color.sec }"
    >
        <AccordionTrigger class="border-b-1 px-4 py-3 hover:no-underline">
            <div class="flex w-full items-center justify-between pr-2">
                <div class="flex items-center gap-3">
                    <span class="text-lg font-bold">{{
                        categoria.titulo
                    }}</span>
                    <Badge
                        variant="secondary"
                        class="ml-2 bg-muted-foreground/10 text-[10px]"
                    >
                        0 Itens
                    </Badge>
                </div>

                <div class="mr-5 flex items-center gap-1">
                    <Button
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 hover:bg-primary/10"
                        @click.stop="emits('up')"
                    >
                        <ArrowUp class="h-4 w-4" />
                    </Button>
                    <Button
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 hover:bg-primary/10"
                        @click.stop="$emit('down', 'bolos')"
                    >
                        <ArrowDown class="h-4 w-4" />
                    </Button>
                    <Button
                        variant="ghost"
                        size="icon"
                        class="w-fit p-2 hover:bg-primary/10"
                        @click.stop="()=>{
                            dialogCategoria.categoria = {...props.categoria }
                            dialogCategoria.open = true
                        }"
                    >
                        <EditIcon class="h-4 w-4" /> Editar
                    </Button>
                </div>
            </div>
        </AccordionTrigger>
        <AccordionContent class="p-5 px-4 pb-4">
            <CardProduto :color="props.color" />

            <div class="space-y-4 pt-2">
                <Button
                    @click="emits('addProduto')"
                    variant="ghost"
                    class="flex h-full w-full gap-2 rounded-lg border border-dashed border-primary/20 bg-muted/30 bg-none p-4"
                >
                    <PlusCircle class="h-4 w-4" />
                    Adicionar Produto em {{ categoria.titulo }}
                </Button>
            </div>
        </AccordionContent>
    </AccordionItem>
</template>
