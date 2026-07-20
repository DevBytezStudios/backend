<script setup lang="ts">
import {
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Edit, Trash2Icon } from 'lucide-vue-next';
import ItemOpcao from './ItemOpcao.vue';

const emit = defineEmits(['deleteVariacao', 'adicionarOpcao', 'deleteOpcao']);
</script>

<template>
    <AccordionItem
        value="item-1"
        class="group overflow-hidden rounded-xl border border-border/60 bg-card shadow-sm transition-all duration-200 hover:shadow-md"
    >
        <AccordionTrigger
            class="px-4 py-4 hover:no-underline focus-visible:ring-0 data-[state=open]:bg-muted/30"
        >
            <div class="flex w-full items-center justify-between gap-2">
                <div class="flex flex-col items-start gap-1">
                    <Input
                        type="text"
                        class="w-full"
                        placeholder="Nome do complemento"
                    />
                    <span
                        class="text-[10px] font-medium tracking-wider text-muted-foreground/70 uppercase"
                    >
                        Configuração de itens
                    </span>
                </div>

                <div class="flex items-start gap-2 pr-2">
                    <Button
                        variant="secondary"
                        size="icon"
                        class="h-9 w-9 shrink-0 rounded-lg shadow-sm transition-transform active:scale-95"
                        @click.stop="console.log('Edit')"
                    >
                        <Edit class="h-4 w-4 text-primary" />
                    </Button>
                    <Button
                        variant="destructive"
                        size="icon"
                        class="h-9 w-9 shrink-0 rounded-lg shadow-sm transition-transform active:scale-95"
                        @click.stop="console.log('Delete')"
                    >
                        <Trash2Icon class="h-4 w-4" />
                    </Button>
                </div>
            </div>
        </AccordionTrigger>

        <AccordionContent class="flex flex-col gap-2 px-4 pt-2 pb-4">
            <div class="gap- mb-3 flex items-center justify-between">
                <h3
                    class="text-xs font-bold tracking-widest text-muted-foreground uppercase"
                >
                    Opções Disponíveis
                </h3>
                <span class="ml-4 h-[1px] flex-1 bg-border/40"></span>
            </div>
            
            <ItemOpcao/>

            <Button
                variant="ghost"
                size="sm"
                class="mt-4 h-10 w-full border-2 border-dashed text-muted-foreground hover:text-primary"
            >
                + Adicionar nova opção
            </Button>
        </AccordionContent>
    </AccordionItem>
</template>
