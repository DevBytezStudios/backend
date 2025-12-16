<script setup lang="ts">
import UploadComponent from '@/components/Dashboard/UploadComponent.vue';
import LoadingBar from '@/components/LoadingBar.vue';
import { Button } from '@/components/ui/button';
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
import { ref } from 'vue';

import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';

const confStore = useConfeitariaStore();

const loading = ref(false);
const updateConf = async () => {
    try {
        loading.value = !loading.value;
        const response = await confStore.setConfeitaria();
        if (response.success) {
            loading.value = !loading.value;

            toast.success(response.success.titulo);
        } else {
            loading.value = !loading.value;

            toast.error(response.error.titulo);
        }
    } catch ($error) {}
};
</script>

<template>
    <AppLayout page="Informações">
        <LoadingBar :loading="loading" />
        <Toaster />
        <form>
            <FieldGroup>
                <FieldSet>
                    <FieldGroup>
                        <Field>
                            <FieldTitle>Logo</FieldTitle>
                            <UploadComponent
                                :imagem="confStore.confeitaria.logo"
                            />
                        </Field>
                    </FieldGroup>
                    <FieldGroup>
                        <Field>
                            <FieldLabel for="checkout-7j9-card-name-43j">
                                Nome da confeitaria
                            </FieldLabel>
                            <Input
                                type="text"
                                v-model="confStore.confeitaria.nome"
                            />
                        </Field>
                    </FieldGroup>
                    <FieldGroup>
                        <Field>
                            <FieldLegend>Cores da confeitaria</FieldLegend>
                            <FieldDescription>
                                Escolha as cores dos botões e demais
                            </FieldDescription>
                            <FieldLabel for="checkout-7j9-card-name-43j">
                                Cor principal
                            </FieldLabel>
                            <input
                                type="color"
                                class="colorPicker"
                                name="corPrincipal"
                                v-model="confStore.confeitaria.cor_princ"
                            />
                            <FieldLabel for="checkout-7j9-card-name-43j">
                                Cor segundaria
                            </FieldLabel>
                            <input
                                type="color"
                                class="colorPicker"
                                name="corSecundaria"
                                v-model="confStore.confeitaria.cor_sec"
                            />
                        </Field>
                    </FieldGroup>
                </FieldSet>
                <FieldSeparator />
                <Field orientation="horizontal">
                    <Button type="button" @click="updateConf()">
                        Salvar
                    </Button>
                    <Button variant="outline" type="button"> Cancelar </Button>
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
