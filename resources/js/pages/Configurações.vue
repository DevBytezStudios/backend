<script setup lang="ts">
import UploadComponent from '@/components/Dashboard/UploadComponent.vue';
import InputTelefone from '@/components/InputTelefone.vue';
import LoadingBar from '@/components/LoadingBar.vue';
import { Button } from '@/components/ui/button';
import Calendar from '@/components/ui/calendar/Calendar.vue';
import {
    Field,
    FieldGroup,
    FieldLabel,
    FieldSeparator,
    FieldSet,
} from '@/components/ui/field';
import FieldDescription from '@/components/ui/field/FieldDescription.vue';
import FieldLegend from '@/components/ui/field/FieldLegend.vue';
import FieldTitle from '@/components/ui/field/FieldTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import useConfeitariaStore from '@/stores/ConfeitariaStore';
import { computed, onMounted, onUnmounted, Ref, ref, watch } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { router } from '@inertiajs/vue3';

// PROPS PARA INFORMAÇÔES A MAIS
interface Props {
    limite: number;
}

const props = defineProps<Props>();
const confStore = useConfeitariaStore();
const confeitariaConfig = ref({ ...confStore.confeitaria });
watch(confeitariaConfig.value, () => {
    if (confeitariaConfig.value != confStore.confeitaria) {
        saved.value = false;
    }
});

const loading = ref(false);
const updateConf = async () => {
    try {
        loading.value = !loading.value;
        const response = await confStore.setConfeitaria(
            confeitariaConfig.value,
        );
        if (response.success) {
            loading.value = !loading.value;
            saved.value = true;
            toast.success(response.success.titulo);
        } else {
            loading.value = !loading.value;
            saved.value = true;
            toast.error(response.error.titulo);
        }
    } catch ($error) {}
};

// REFERENTE AO SALVAMENTO
const saved = ref(true);
const showAlertSave = ref(false);
const savedRoute = ref('');
const removeStartListener = router.on('before', (event) => {
    if (saved.value == false) {
        savedRoute.value = event.detail.visit.url.href;
        showAlertSave.value = true;
        event.preventDefault();
    }
});

const saveConfig = async () => {
    loading.value = !loading.value;
    showAlertSave.value = false;
    const response = await confStore.setConfeitaria(confeitariaConfig.value);
    if (response.success) {
        saved.value = true;
        loading.value = !loading.value;
        toast.success(response.success.titulo);
        router.visit(savedRoute.value);
    } else {
        loading.value = !loading.value;
        toast.error(response.error.titulo);
    }
};

const cancelSave = () => {
    saved.value = true;
    showAlertSave.value = false;
    removeStartListener();
    router.visit(savedRoute.value);
};

// AO SAIR TIRAR O LISTENER DA ROTA
onUnmounted(() => {
    removeStartListener();
});

// CALENDARIO
// VERIFICA SE  POSSUI DATAS
import type { DateValue } from '@internationalized/date';
import { getLocalTimeZone, parseDate, today } from '@internationalized/date';
import SaveAlert from '@/components/SaveAlert.vue';
import { Trash2Icon } from 'lucide-vue-next';
const currentToday = today(getLocalTimeZone());
const selectedDates = ref<DateValue[]>();
const formattedSelectedDates = computed(() => {
    if (!selectedDates.value) return ((confStore.blockDates = []), []);
    confStore.blockDates = selectedDates.value.map((d) => d.toString());
    return selectedDates.value.map((d) => d.toString());
});

onMounted(async () => {
    if (confStore.blockDates.length == 0) {
        loading.value = true;
        await confStore.getBlockDates();
        if (confStore.blockDates.length > 0) {
            selectedDates.value = confStore.blockDates.map((date: string) =>
                parseDate(date),
            );
        }
        confStore.limite = props.limite;
        loading.value = false;
    }
});
</script>

<template>
    <AppLayout page="Informações">
        <LoadingBar :loading="loading" />
        <SaveAlert
            :open="showAlertSave"
            @save="saveConfig"
            @cancel="cancelSave"
        />
        <form>
            <FieldGroup @vue:updated="">
                <FieldSet>
                    <FieldGroup>
                        <Field class="w-full">
                            <FieldTitle>Logo</FieldTitle>
                            <UploadComponent
                                :imagem="confStore.confeitaria.logo_url"
                            />
                        </Field>
                    </FieldGroup>
                    <FieldGroup>
                        <Field class="w-fit">
                            <FieldTitle>Gestão de Disponibilidade</FieldTitle>
                            <span>Toque/Clique para bloquear datas</span>
                            <div>
                                <Button
                                    @click="
                                        ((selectedDates = []), (saved = false))
                                    "
                                    type="button">
                                    <Trash2Icon/>Limpar todas as datas
                                </Button>
                            </div>
                            <Calendar
                                v-model="selectedDates"
                                multiple
                                class="rounded-md border shadow-sm [&_[data-selected]]:bg-white [&_[data-selected]]:text-black [&_[data-selected]]:opacity-100 [&_[data-selected]]:hover:bg-white/90"
                                layout="month-and-year"
                                locale="pt-BR"
                                :min-value="currentToday"
                                :block-dates="formattedSelectedDates"
                            />
                            <div class="h-3 w-3"></div>
                        </Field>
                        <Field>
                            <div class="flex w-full flex-row gap-2">
                                <FieldLabel> Limite diário </FieldLabel>
                                <TooltipProvider :delay-duration="0">
                                    <Tooltip>
                                        <TooltipTrigger>
                                            <div
                                                type="button"
                                                variant="outline"
                                                class="h-7 w-7"
                                            >
                                                <InfoIcon />
                                            </div>
                                        </TooltipTrigger>
                                        <TooltipContent class="w-80">
                                            <p>
                                                O limite de encomendas que você
                                                ira receber por dia. Bloqueia
                                                automaticamente a data caso
                                                atinja o limite
                                            </p>
                                        </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </div>
                            <Input type="number" v-model="confStore.limite" />
                        </Field>
                    </FieldGroup>
                    <FieldGroup>
                        <Field>
                            <FieldLabel> Nome da confeitaria </FieldLabel>
                            <Input
                                type="text"
                                v-model="confeitariaConfig.nome"
                            />
                        </Field>
                        <Field>
                            <FieldLabel> Telefone </FieldLabel>
                            <InputTelefone
                                v-model="confeitariaConfig.telefone"
                            />
                        </Field>
                    </FieldGroup>
                    <FieldGroup>
                        <Field>
                            <FieldLegend>Cores</FieldLegend>
                            <FieldDescription>
                                Escolha as cores dos botões e demais
                            </FieldDescription>
                            <FieldLabel> Cor principal </FieldLabel>
                            <input
                                type="color"
                                class="colorPicker"
                                name="corPrincipal"
                                v-model="confeitariaConfig.cor_princ"
                            />
                            <FieldLabel> Cor segundaria </FieldLabel>
                            <input
                                type="color"
                                class="colorPicker"
                                name="corSecundaria"
                                v-model="confeitariaConfig.cor_sec"
                            />
                        </Field>
                    </FieldGroup>
                </FieldSet>
                <FieldSeparator />
                <Field orientation="horizontal">
                    <Button type="button" @click="updateConf()">
                        Salvar
                    </Button>
                </Field>
            </FieldGroup>
        </form>
    </AppLayout>
</template>

<style scoped>
.cardAnalytic {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 1rem;
    background: var(--card, #fff);
    color: var(--foreground, #000);
    border: 1px solid var(--border, #000);
}

.icon-wrapper {
    padding: 0.75rem;
    border-radius: 9999px;
    background: var(--muted, #000);
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon {
    width: 24px;
    height: 24px;
    color: #fff;
}

.text-wrapper {
    display: flex;
    flex-direction: column;
}

.label {
    font-size: 0.875rem;
    opacity: 0.7;
}

.value {
    font-size: 1.75rem;
    font-weight: bold;
    line-height: 1;
}

form {
    width: 50%;
}

.colorPicker {
    width: 30px;
    height: 30px;
    border: none;
    background: transparent;
    padding: 0;
    cursor: pointer;
    border-radius: 5px;
}
</style>
