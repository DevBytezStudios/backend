<script setup lang="ts">
import {
    Empty,
    EmptyContent,
    EmptyDescription,
    EmptyHeader,
    EmptyMedia,
    EmptyTitle,
} from '@/components/ui/empty';
import { BlocksIcon, FolderCode } from 'lucide-vue-next';

interface Props {
    msg?: string;
}

const props = defineProps<Props>();
</script>

<template>
    <Empty>
        <EmptyHeader>
            <EmptyMedia variant="icon">
                <BlocksIcon />
            </EmptyMedia>
            <EmptyTitle>NADA ENCONTRADO</EmptyTitle>
            <EmptyDescription>
                {{ msg != null ? msg.toUpperCase() : "VOCÊ AINDA NÃO POSSUI NADA NESTA PÁGINA" }}
            </EmptyDescription>
        </EmptyHeader>
    </Empty>
</template>
