<script setup lang="ts">
import { AlertDialog, AlertDialogContent } from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import {
    Empty,
    EmptyHeader,
    EmptyMedia,
    EmptyTitle,
} from '@/components/ui/empty';
import { AlertCircleIcon, SaveIcon } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import EmptyDescription from './ui/empty/EmptyDescription.vue';
interface Props {
    open: boolean;
}

const props = defineProps<Props>();
const emits = defineEmits(['save', 'cancel']);
const open = ref(props.open);
watch(props, (newState) => {
    open.value = newState.open;
});
</script>

<template>
    <AlertDialog :open="open">
        <AlertDialogContent>
            <Empty class="w-full">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <AlertCircleIcon />
                    </EmptyMedia>
                    <EmptyTitle>Alterações não salvas...</EmptyTitle>
                    <EmptyDescription
                        >Deseja salvar as alterações antes de
                        sair?</EmptyDescription
                    >
                    <div class="flex gap-3">
                        <Button @click="emits('save')"><SaveIcon /> Salvar</Button>
                        <Button variant="secondary" @click="emits('cancel')">Não salvar</Button>
                    </div>
                </EmptyHeader>
            </Empty>
        </AlertDialogContent>
    </AlertDialog>
</template>
