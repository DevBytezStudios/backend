<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

defineProps<{
    open: boolean;
    cliente: {
        nome: string;
        telefone: string;
        rua: string;
        numero: number;
        bairro: string;
        cidade: string;
        complemento?: string;
    };
    code: string,
}>();

defineEmits(['close']);
</script>

<template>
    <Dialog :open="open" @update:open="$emit('close')">
        <DialogContent class="max-w-sm bg-background">
            <DialogHeader>
                <DialogTitle>Dados do cliente</DialogTitle>
                <DialogDescription>
                    Informações vinculadas ao pedido <strong>{{ code }}</strong>
                </DialogDescription>
            </DialogHeader>

            <div class="space-y-3 text-sm">
                <div>
                    <p class="font-medium">{{ cliente.nome }}</p>
                    <p class="text-muted-foreground">{{ cliente.telefone }}</p>
                </div>

                <div class="leading-relaxed text-muted-foreground">
                    <p>{{ cliente.rua }}, {{ cliente.numero }}</p>
                    <p>{{ cliente.bairro }} – {{ cliente.cidade }}</p>
                    <p v-if="cliente.complemento">{{ cliente.complemento }}</p>
                </div>
            </div>

            <!-- Botão WhatsApp -->
            <Button
                class="inline-block rounded-lg bg-green-500 px-4 py-2 text-center text-white transition-colors hover:bg-green-600"
            >
                <span class="flex items-center justify-center gap-2">
                    Chamar no WhatsApp
                </span>
            </Button>
        </DialogContent>
    </Dialog>
</template>
