<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

import {
    Field,
    FieldGroup,
    FieldLabel,
    FieldSeparator,
    FieldSet,
} from '@/components/ui/field'; 
import Input from '@/components/ui/input/Input.vue';
import useDialogCategoria from '@/stores/Cardapio/DialogCategoriaStore';

const emits = defineEmits(['closeDialog', 'saveProduct']);
const dialogCategoria = useDialogCategoria();

</script>

<template>
    <Dialog :open="dialogCategoria.open">
        <DialogContent
            class="max-h-[90vh] max-w-[90vw] overflow-y-auto rounded-lg p-6 md:max-w-150"
        >
            <DialogHeader class="w-full">
                <DialogTitle>Editar categoria</DialogTitle>
                <div class="w-ful flex flex-col gap-6">
                    <FieldGroup>
                        <FieldSet>
                            <FieldGroup>
                                <FieldGroup>
                                    <Field>
                                        <FieldLabel for="txtTitulo">
                                            Titulo da Categoria
                                        </FieldLabel>
                                        <Input
                                            id="txtTitulo"
                                            placeholder="Ex.. Bolos, Doces"
                                            v-model="dialogCategoria.categoria.titulo"
                                            required
                                        />
                                    </Field>
                                </FieldGroup>
                            </FieldGroup>
                        </FieldSet>
                        <FieldSeparator />
                    </FieldGroup>
                </div>
            </DialogHeader>
            <Button variant="secondary"> Salvar </Button>
            <Button @click="dialogCategoria.open = !dialogCategoria.open,dialogCategoria.clearDialog()"> Cancel </Button>
        </DialogContent>
    </Dialog>
</template>

<style scoped>
.dialog {
    width: 300px;
}
</style>
