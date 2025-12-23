<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';

import LoadingBar from '@/components/LoadingBar.vue';
import {
    Field,
    FieldGroup,
    FieldLabel,
    FieldSeparator,
    FieldSet,
} from '@/components/ui/field';
import FieldDescription from '@/components/ui/field/FieldDescription.vue';
import FieldTitle from '@/components/ui/field/FieldTitle.vue';
import { Input } from '@/components/ui/input';
import Label from '@/components/ui/label/Label.vue';
import {
    Select,
    SelectContent,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import { Switch } from '@/components/ui/switch';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import useEtapaStore from '@/stores/Encomenda/EtapaStore';
import { InfoIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
import IconPicker from './IconPicker.vue';
interface Props {
    open: boolean;
}
const loading = ref(false);

const props = defineProps<Props>();
const emit = defineEmits(['close']);

const icon = ref('');

const etapaStore = useEtapaStore();
const setEtapa = async () => {
    loading.value = true;
    emit('close');

    const response = await etapaStore.setEtapa();
    etapaStore.clear();
    if (response.success) {
        loading.value = !loading.value;
        toast.success(response.success.titulo);
    } else {
        loading.value = !loading.value;
        toast.error(response.error.titulo);
    }
};
</script>

<template>
    <Toaster theme="system" />

    <LoadingBar :loading="loading" />
    <Sheet :modal="true" v-model:open="props.open">
        <SheetContent>
            <SheetHeader>
                <SheetTitle>{{
                    etapaStore.etapa.id != 0 ? 'Editar Etapa' : 'Criar Etapa'
                }}</SheetTitle>
                <SheetDescription>
                    Configure a etapa que ira aparecer para os clientes
                </SheetDescription>
            </SheetHeader>

            <div>
                <FieldGroup>
                    <FieldSet>
                        <FieldGroup>
                            <FieldGroup>
                                <Field>
                                    <FieldTitle>Icone</FieldTitle>
                                    <div class="w-100">
                                        <IconPicker v-model="icon" />
                                    </div>
                                </Field>
                                <Field>
                                    <FieldLabel for="txtNome">
                                        Nome da Etapa
                                    </FieldLabel>
                                    <Input
                                        id="txtNome"
                                        placeholder="Ex.. Tamahos, Recheios"
                                        v-model="etapaStore.etapa.nome"
                                    />
                                </Field>
                                <Field>
                                    <FieldTitle
                                        >Configurações Extras</FieldTitle
                                    >

                                    <div class="flex items-center space-x-2">
                                        <Switch
                                            id="swObrigatorio"
                                            v-model="etapaStore.etapa.required"
                                        />

                                        <Label for="swObrigatorio"
                                            >Obrigatorio</Label
                                        >
                                        <TooltipProvider>
                                            <Tooltip>
                                                <TooltipTrigger as-child>
                                                    <Button variant="outline">
                                                        <InfoIcon />
                                                    </Button>
                                                </TooltipTrigger>
                                                <TooltipContent class="w-80">
                                                    <p>
                                                        Se estiver ativado o
                                                        cliente terá que
                                                        escolher ao menos uma
                                                        opção para a proxima
                                                        etapa da encomenda
                                                    </p>
                                                </TooltipContent>
                                            </Tooltip>
                                        </TooltipProvider>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <Switch
                                            id="swMulti"
                                            v-model="etapaStore.etapa.multiple"
                                        />

                                        <Label for="swMulti"
                                            >Multiplas escolhas</Label
                                        >
                                        <TooltipProvider>
                                            <Tooltip>
                                                <TooltipTrigger as-child>
                                                    <Button variant="outline">
                                                        <InfoIcon />
                                                    </Button>
                                                </TooltipTrigger>
                                                <TooltipContent class="w-80">
                                                    <p>
                                                        Se ativo, permite que os
                                                        clientes escolham mais
                                                        de uma opção nesta etapa
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

                    <FieldSet> </FieldSet>
                </FieldGroup>
            </div>

            <SheetFooter>
                <SheetClose @click="(etapaStore.clear(), emit('close'))">
                    <Button variant="outline"> Voltar </Button>
                </SheetClose>
                <Button type="submit" @click="setEtapa()"> Salvar </Button>
            </SheetFooter>
        </SheetContent>
    </Sheet>
</template>
