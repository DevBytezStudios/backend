<script setup lang="ts">
import LoadingBar from '@/components/LoadingBar.vue';
import Button from '@/components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
const emits = defineEmits(['close']);

// CONFIGURAÇÔES DO FORM
import { FieldGroup, FieldSet } from '@/components/ui/field';
import Field from '@/components/ui/field/Field.vue';
import FieldLabel from '@/components/ui/field/FieldLabel.vue';
import FieldSeparator from '@/components/ui/field/FieldSeparator.vue';
import FieldTitle from '@/components/ui/field/FieldTitle.vue';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
    InputGroupText,
} from '@/components/ui/input-group';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Switch } from '@/components/ui/switch';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import useEstiloStore from '@/stores/Encomenda/EstiloStore';
import { InfoIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
import UploadEstilo from './UploadEstilo.vue';

interface Props {
    open: boolean;
}

const props = defineProps<Props>();

const estiloStore = useEstiloStore();
const loading = ref(false);

const setEstilo = async () => {
    loading.value = !loading.value;
    emits('close');
    const response = await estiloStore.setEstilo();
    if (response.success) {
        loading.value = !loading.value;
        estiloStore.clear();
        toast.success(response.success.titulo);
    } else {
        estiloStore.clear();
        loading.value = !loading.value;
        toast.error(response.error.titulo);
    }
};

</script>

<template>
    <Dialog :open="props.open"  @update:open="emits('close')">
        <LoadingBar :loading="loading" />
        <Toaster/>
        <DialogContent
            class="max-h-[90vh] max-w-[90vw] overflow-y-auto rounded-lg p-6 md:max-w-150"
        >
            <DialogHeader>
                <DialogTitle>{{
                    estiloStore.estilo.id != 0 ? 'Editar Opção' : 'Criar Opção'
                }}</DialogTitle>
                <div>
                    <FieldGroup>
                        <FieldSet>
                            <FieldGroup>
                                <Field>
                                    <FieldLabel> Imagem </FieldLabel>
                                    <UploadEstilo
                                        :imagem="estiloStore.estilo.imagem"
                                    />
                                </Field>
                                <FieldGroup>
                                    <Field>
                                        <FieldLabel for="txtTitulo">
                                            Titulo
                                        </FieldLabel>
                                        <Input
                                            id="txtTitulo"
                                            placeholder="Ex.. Bolo Florido, Temático"
                                            v-model="estiloStore.estilo.titulo"
                                        />
                                    </Field>
                                    <Field>
                                        <FieldLabel for="txtDesc">
                                            Descrição do estilo
                                        </FieldLabel>
                                        <Textarea
                                            id="txtDesc"
                                            placeholder="Ex.. Bolo com flores de chantilly"
                                            class="resize-none"
                                            v-model="
                                                estiloStore.estilo.descricao
                                            "
                                        />
                                    </Field>
                                    <!-- <div class="grid grid-cols-3 gap-4">
                                        <Field>
                                            <FieldLabel for="numValor">
                                                Valor
                                            </FieldLabel>
                                            <InputGroup>
                                                <InputGroupAddon>
                                                    <InputGroupText
                                                        >R$</InputGroupText
                                                    >
                                                </InputGroupAddon>
                                                <InputGroupInput
                                                    type="number"
                                                    min="0"
                                                    placeholder="9,99"
                                                    v-model="
                                                        estiloStore.estilo.valor
                                                    "
                                                />
                                            </InputGroup>
                                        </Field>
                                    </div> -->
                                    <FieldSeparator />
                                    <Field>
                                        <FieldTitle>Configurações</FieldTitle>
                                        <div
                                            class="flex items-center space-x-2"
                                        >
                                            <Switch
                                                id="swAtiva"
                                                v-model="
                                                    estiloStore.estilo.active
                                                "
                                            />

                                            <Label for="swAtiva">Ativa</Label>
                                            <TooltipProvider>
                                                <Tooltip>
                                                    <TooltipTrigger as-child>
                                                        <Button
                                                            variant="outline"
                                                        >
                                                            <InfoIcon />
                                                        </Button>
                                                    </TooltipTrigger>
                                                    <TooltipContent
                                                        class="w-80"
                                                    >
                                                        <p>
                                                            Define se o estilo
                                                            ira aparecer para o
                                                            cliente
                                                        </p>
                                                    </TooltipContent>
                                                </Tooltip>
                                            </TooltipProvider>
                                        </div>
                                    </Field>
                                </FieldGroup>
                            </FieldGroup>
                        </FieldSet>
                        <FieldSeparator />
                    </FieldGroup>
                </div>
            </DialogHeader>
            <Button variant="secondary" @click="setEstilo"> Salvar </Button>
            <Button @click="(estiloStore.clear(), emits('close'))">
                Cancel
            </Button>
        </DialogContent>
    </Dialog>
</template>

<style scoped>
.dialog {
    width: 300px;
}
</style>
