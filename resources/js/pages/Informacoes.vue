<script setup lang="ts">
import UploadComponent from '@/components/Dashboard/Produtos/UploadComponent.vue';
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
</script>

<template>
    <AppLayout page="Informações da confeitaria">
        <!-- <SystemLogo />         -->

        <form>
            <FieldGroup>
                <FieldSet>
                    <FieldGroup>
                        <Field>
                            <FieldTitle>Logo</FieldTitle>
                            <UploadComponent />
                        </Field>
                    </FieldGroup>
                    <FieldGroup>
                        <Field>
                            <FieldLabel for="checkout-7j9-card-name-43j">
                                Nome da confeitaria
                            </FieldLabel>
                            <Input type="text"/>
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
                            />
                            <FieldLabel for="checkout-7j9-card-name-43j">
                                Cor segundaria
                            </FieldLabel>
                            <input
                                type="color"
                                class="colorPicker"
                                name="corSecundaria"
                            />
                        </Field>
                    </FieldGroup>
                </FieldSet>
                <FieldSeparator />
                <Field orientation="horizontal">
                    <Button type="submit"> Salvar </Button>
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
