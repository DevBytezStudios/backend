<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Separator } from '@/components/ui/separator';

const props = defineProps<{
    open: boolean;
}>();
</script>

<template>
    <Dialog :open="open">
        <DialogContent class="max-w-lg">
            <!-- Header -->
            <DialogHeader>
                <div class="flex items-center justify-between">
                    <DialogTitle> Pedido </DialogTitle>

                    <Badge variant="secondary"> em progresso </Badge>
                </div>

                <DialogDescription> </DialogDescription>
            </DialogHeader>

            <Separator />

            <!-- ITENS -->
            <div class="space-y-3 text-sm">
                <h4 class="font-medium">Itens do pedido</h4>

                <div class="flex justify-between">
                    <div>
                        <p class="font-medium"></p>
                        <p class="text-xs text-muted-foreground"></p>
                    </div>

                    <div class="text-right">
                        <p>x1</p>
                        <p class="text-xs text-muted-foreground">R$ 123</p>
                    </div>
                </div>
            </div>

            <Separator />

            <!-- CLIENTE -->
            <div class="space-y-1 text-sm">
                <h4 class="font-medium">Cliente</h4>
                <p></p>
                <p class="text-muted-foreground"></p>
            </div>

            <Separator />

            <!-- STATUS -->
            <div class="space-y-2">
                <h4 class="text-sm font-medium">Status do pedido</h4>

                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Selecione o status" />
                    </SelectTrigger>

                    <SelectContent>
                        <SelectItem value="em progresso">
                            em progresso
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>

            <!-- FOOTER -->
            <DialogFooter class="mt-4">
                <Button variant="outline"> Cancelar </Button>

                <Button> Salvar status </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
