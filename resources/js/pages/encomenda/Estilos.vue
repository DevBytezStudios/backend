<script setup lang="ts">
import CardEstilo from '@/components/Dashboard/Encomendas/CardEstilo.vue';
import DialogEstilo from '@/components/Dashboard/Encomendas/DialogEstilo.vue';
import Empty from '@/components/Empty.vue';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import useEstiloStore from '@/stores/Encomenda/EstiloStore';
import { Estilo } from '@/types/types';
import { PlusCircleIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';

interface Props {
    estilos: Estilo[];
}

const props = defineProps<Props>();
const estiloStore = useEstiloStore();
estiloStore.estilos = props.estilos;
const showDialog = ref(false);
const showAlert = ref(false);

const editEstilo = (estilo: Estilo) => {
    estiloStore.estilo = estilo;
    showDialog.value = true;
};

const loading = ref(false);

const deleteEstilo = async () => {
    loading.value = !loading.value;

    const response = await estiloStore.delete();

    if (response.success) {
        estiloStore.clear();
        showAlert.value = false;
        loading.value = !loading.value;
        toast.success(response.success.titulo);
    } else {
        estiloStore.clear();
        showAlert.value = false;
        loading.value = !loading.value;
        toast.error(response.error.titulo);
    }
};
</script>

<template>
    <AppLayout page="Estilos">
        <Toaster />
        <DialogEstilo @close="showDialog = false" :open="showDialog" />
        <header class="menubar">
            <Button variant="outline" type="button" @click="showDialog = true">
                <PlusCircleIcon />
            </Button>
        </header>

        <AlertDialog :open="showAlert">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle
                        >Quer mesmo deletar esse estilo?</AlertDialogTitle
                    >
                    <AlertDialogDescription>
                        Essa ação irá deletar o estilo para sempre, recomendamos
                        apenas DESATIVA-LO para evitar problemas futuros!
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel
                        @click="
                            estiloStore.clear();
                            showAlert = false;
                        "
                        >Cancelar</AlertDialogCancel
                    >
                    <AlertDialogAction @click="deleteEstilo" class="bg-red-500"
                        >Continuar</AlertDialogAction
                    >
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

        <div class="flex max-w-full flex-wrap gap-10">
            <CardEstilo
                v-for="(estilo, index) in estiloStore.estilos"
                :key="index"
                :estilo="estilo"
                @edit-estilo="editEstilo"
                @delete="
                    (id: number) => {
                        estiloStore.estilo.id = id;
                        showAlert = true;
                    }
                "
            />

            <Empty v-if="estiloStore.estilos.length == 0" />
        </div>
    </AppLayout>
</template>

<style lang="css" scoped>
.menubar {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: end;
    gap: 1rem;
    padding: 10px;
    /* border: white 1px solid; */
    border-radius: 5px;
}
</style>
