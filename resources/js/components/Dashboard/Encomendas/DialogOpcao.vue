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
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import { Switch } from '@/components/ui/switch';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import useOpcaoStore from '@/stores/Encomenda/OpcaoStore';
import { InfoIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { Toaster, toast } from 'vue-sonner';
import 'vue-sonner/style.css';

interface Props {
    open: boolean;
}

const props = defineProps<Props>();

const opcaoStore = useOpcaoStore();
const loading = ref(false);

const setOpcao = async () => {
    loading.value = !loading.value;

    const response = await opcaoStore.setOpcao();
    if (response.success) {
        loading.value = !loading.value;
        opcaoStore.clear();
        emits('close');
        toast.success(response.success.titulo);
    } else {
        opcaoStore.clear();
        emits('close');
        loading.value = !loading.value;
        toast.error(response.error.titulo);
    }
};
</script>

<template>
    <Dialog :open="props.open">
        <LoadingBar :loading="loading" />
        <Toaster theme="system" />
        <DialogContent
            class="max-h-[90vh] max-w-[90vw] overflow-y-auto rounded-lg p-6 md:max-w-150"
        >
            <DialogHeader>
                <DialogTitle>{{
                    opcaoStore.opcao.id != 0 ? 'Editar Opção' : 'Criar Opção'
                }}</DialogTitle>
                <div>
                    <FieldGroup>
                        <FieldSet>
                            <FieldGroup>
                                <FieldGroup>
                                    <Field>
                                        <FieldLabel for="txtNome">
                                            Nome da Opção
                                        </FieldLabel>
                                        <Input
                                            id="txtNome"
                                            placeholder="Ex.. Chocolate"
                                            v-model="opcaoStore.opcao.nome"
                                        />
                                    </Field>
                                    <Field>
                                        <FieldLabel for="txtDesc">
                                            Descrição do opcao
                                        </FieldLabel>
                                        <Textarea
                                            id="txtDesc"
                                            placeholder="Ex.. Feito com KitKat"
                                            class="resize-none"
                                            v-model="opcaoStore.opcao.descricao"
                                        />
                                    </Field>
                                    <div class="grid grid-cols-3 gap-4">
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
                                                        opcaoStore.opcao.valor
                                                    "
                                                />
                                            </InputGroup>
                                        </Field>
                                    </div>
                                    <Field>
                                        <FieldLabel for="slEtapa">
                                            Etapa
                                        </FieldLabel>
                                        <Select
                                            v-model="opcaoStore.opcao.etapa"
                                        >
                                            <SelectTrigger id="slEtapa">
                                                <SelectValue
                                                    placeholder="Ex.. Tamanho"
                                                />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem
                                                    v-for="(
                                                        etapa, index
                                                    ) in opcaoStore.etapas"
                                                    :key="index"
                                                    :value="etapa"
                                                >
                                                    {{ etapa.nome }}
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </Field>
                                    <FieldSeparator />
                                    <Field>
                                        <FieldTitle>Configurações</FieldTitle>
                                        <div
                                            class="flex items-center space-x-2"
                                        >
                                            <Switch
                                                id="swAtiva"
                                                v-model="
                                                    opcaoStore.opcao.active
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
                                                            Se ativada a opção
                                                            aparece para o
                                                            cliente, caso
                                                            contrario não será
                                                            mostrada
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
            <Button variant="secondary" @click="setOpcao"> Salvar </Button>
            <Button @click="(opcaoStore.clear(), emits('close'))">
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
