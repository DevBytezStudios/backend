<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { ArrowUpDownIcon, Trash2Icon } from 'lucide-vue-next';
</script>

<template>
    <div
        class="flex flex-row items-end gap-2 rounded-xl border border-dashed border-border/80 bg-muted/5 p-2 text-left sm:p-3"
    >
        <Button
            variant="ghost"
            size="icon"
            class="h-9 w-9 shrink-0 cursor-grab text-muted-foreground active:cursor-grabbing"
        >
            <ArrowUpDownIcon class="h-4 w-4" />
        </Button>

        <div class="flex min-w-0 flex-1 flex-row items-end gap-2">
            <div class="min-w-0 flex-[3] space-y-1">
                <Label
                    for="txtNomeOpcao"
                    class="block truncate text-[10px] font-bold text-muted-foreground/80 uppercase"
                >
                    Opção
                </Label>
                <Input
                    placeholder="Ex: Nutella"
                    type="text"
                    id="txtNomeOpcao"
                    class="h-9 w-full bg-background px-2 text-sm focus-visible:ring-primary"
                />
            </div>

            <div class="min-w-[70px] flex-[1.5] space-y-1">
                <Label
                    for="numOpcaoValor"
                    class="block truncate text-[10px] font-bold text-muted-foreground/80 uppercase"
                >
                    R$
                </Label>
                <Input
                    placeholder="0,00"
                    type="number"
                    id="numOpcaoValor"
                    class="h-9 w-full bg-background px-2 text-sm focus-visible:ring-primary"
                    :min-value="0"
                />
            </div>
        </div>

        <Button
            variant="outline"
            size="icon"
            class="h-9 w-9 shrink-0 border-destructive/20 text-destructive hover:bg-destructive/10"
        >
            <Trash2Icon class="h-4 w-4" />
        </Button>
    </div>
</template>
