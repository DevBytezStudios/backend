<script lang="ts" setup>
import Badge from '@/components/ui/badge/Badge.vue';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import useDialogProduto from '@/stores/Cardapio/DialogProdutoStore';
import { BadgeCheck, MoreVertical, Trash2 } from 'lucide-vue-next';
const dialogProduto = useDialogProduto();
</script>

<template>
    <Card
        class="group relative overflow-hidden border-primary/20 bg-card/50 transition-all hover:border-primary/50"
    >
        <div class="flex items-start gap-3 p-3 sm:gap-4 sm:p-4">
            <div
                class="relative h-16 w-16 shrink-0 overflow-hidden rounded-lg border border-border/50 bg-muted sm:h-20 sm:w-20"
            >
                <img
                    src="https://images.unsplash.com/photo-1578985545062-69928b1d9587"
                    alt="Bolo Festivo"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                />
            </div>

            <div
                class="flex min-w-0 flex-1 flex-col"
                @click="dialogProduto.open = !dialogProduto.open"
            >
                <div
                    class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between sm:gap-2"
                >
                    <h3
                        class="truncate text-sm leading-tight font-bold tracking-tight text-foreground sm:text-base"
                    >
                        Bolo Festivo de Chocolate Belga
                    </h3>

                    <div class="flex shrink-0 items-center gap-2">
                        <span
                            class="text-[10px] font-medium text-muted-foreground line-through sm:text-xs"
                        >
                            R$ 180,00
                        </span>
                        <span
                            class="text-xs font-black text-primary sm:text-sm"
                        >
                            R$ 155,00
                        </span>
                    </div>
                </div>

                <p
                    class="mt-1 line-clamp-2 text-[11px] leading-relaxed text-muted-foreground/80 sm:text-xs"
                >
                    Chocolate belga 70% cacau, recheio trufado e cobertura de
                    ganache. Serve 15 pessoas.
                </p>
            </div>

            <div class="flex flex-col items-end justify-between self-stretch">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button
                            variant="ghost"
                            size="icon"
                            class="h-8 w-8 text-muted-foreground"
                        >
                            <MoreVertical class="h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-40">
                        <DropdownMenuItem
                            class="gap-2 text-destructive focus:text-destructive"
                        >
                            <Trash2 class="h-4 w-4" /> Excluir
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>

                <div class="flex flex-col items-center gap-0.5 sm:gap-1">
                    <Badge
                        variant="secondary"
                        class="pointer-events-none ml-2 border-none bg-green-500 text-[10px] text-secondary"
                    >
                        Ativo
                        <BadgeCheck class="w-3" />
                    </Badge>
                    <!-- <Badge
                        variant="secondary"
                        class="pointer-events-none ml-2 border-none bg-red-500 text-[10px] text-secondary"
                    >
                        Oculto
                        <EyeOffIcon class="ml-1 w-3" />
                    </Badge> -->
                </div>
            </div>
        </div>
    </Card>
</template>
