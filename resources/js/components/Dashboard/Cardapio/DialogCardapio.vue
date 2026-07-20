<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

import { FieldGroup, FieldSet } from '@/components/ui/field';
import Field from '@/components/ui/field/Field.vue';
import FieldLabel from '@/components/ui/field/FieldLabel.vue';
import FieldSeparator from '@/components/ui/field/FieldSeparator.vue';
import FieldTitle from '@/components/ui/field/FieldTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Switch } from '@/components/ui/switch';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { InfoIcon } from 'lucide-vue-next';
import 'vue-sonner/style.css';
import DatePicker from './DatePicker.vue';
import useDialogCardapio from '@/stores/Cardapio/DialogCardapioStore';
const dialogCardapio = useDialogCardapio();
</script>

<template>
    <Dialog :open="dialogCardapio.open">
        <DialogContent
            class="max-h-[90vh] max-w-[90vw] overflow-y-auto rounded-lg p-6 md:max-w-150"
        >
            <DialogHeader>
                <DialogTitle>Editar/Adiconar Cardapio</DialogTitle>
                <div>
                    <FieldGroup>
                        <FieldSet>
                            <FieldGroup>
                                <FieldGroup>
                                    <FieldGroup>
                                        <Field>
                                            <FieldLabel for="txTitulo">
                                                Titulo do cardápio
                                            </FieldLabel>
                                            <Input
                                                id="txTitulo"
                                                placeholder="Ex.. Pascoa 2026"
                                                v-model="dialogCardapio.cardapio.titulo"
                                            />
                                        </Field>
                                        <Field>
                                            <FieldLabel for="txtDesc">
                                                Datas
                                            </FieldLabel>
                                            <div
                                                class="flex w-full justify-between align-middle"
                                            >
                                                <div
                                                    class="flex flex-col items-start"
                                                >
                                                    <span>Início</span>
                                                    <DatePicker
                                                        @update:model="
                                                            (date) => {
                                                                dialogCardapio.cardapio.dt_inicio = date
                                                            }
                                                        "
                                                    />
                                                </div>
                                                <div
                                                    class="flex flex-col items-start"
                                                >
                                                    <span>Fim</span>
                                                    <DatePicker
                                                        @update:model="
                                                            (date) => {
                                                                dialogCardapio.cardapio.dt_fim = date
                                                            }
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </Field>
                                        <Field>
                                            <FieldLabel for="txtDesc">
                                                Datas
                                            </FieldLabel>
                                            <div
                                                class="flex w-full items-center justify-start gap-8 py-2"
                                            >
                                                <div
                                                    class="flex flex-col items-center gap-2"
                                                >
                                                    <span
                                                        class="text-xs font-medium tracking-wider text-muted-foreground uppercase"
                                                    >
                                                        Principal
                                                    </span>
                                                    <div
                                                        class="relative flex items-center justify-center"
                                                    >
                                                        <Input
                                                            type="color"
                                                            class="h-12 w-12 cursor-pointer rounded-full border-2 border-background p-0 shadow-md transition-transform hover:scale-110 focus-visible:ring-offset-2 [&::-moz-color-swatch]:rounded-full [&::-moz-color-swatch]:border-none [&::-webkit-color-swatch]:rounded-full [&::-webkit-color-swatch]:border-none [&::-webkit-color-swatch-wrapper]:p-0"
                                                            v-model="dialogCardapio.cardapio.cor_princ"
                                                        />
                                                    </div>
                                                </div>

                                                <div
                                                    class="flex flex-col items-center gap-2"
                                                >
                                                    <span
                                                        class="text-xs font-medium tracking-wider text-muted-foreground uppercase"
                                                    >
                                                        Secundária
                                                    </span>
                                                    <div
                                                        class="relative flex items-center justify-center"
                                                    >
                                                        <Input
                                                            type="color"
                                                            class="h-12 w-12 cursor-pointer rounded-full border-2 border-background p-0 shadow-md transition-transform hover:scale-110 focus-visible:ring-offset-2 [&::-moz-color-swatch]:rounded-full [&::-moz-color-swatch]:border-none [&::-webkit-color-swatch]:rounded-full [&::-webkit-color-swatch]:border-none [&::-webkit-color-swatch-wrapper]:p-0"
                                                            v-model="dialogCardapio.cardapio.cor_sec"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </Field>

                                        <FieldSeparator />
                                        <Field>
                                            <FieldTitle>Configurações</FieldTitle>
                                            <div class="flex items-center space-x-2">
                                                <Switch v-model="dialogCardapio.cardapio.active"/>
                                                <Label for="swAtivo"
                                                    >Ativo</Label
                                                >
                                                <TooltipProvider>
                                                    <Tooltip
                                                        :delay-duration="1"
                                                    >
                                                        <TooltipTrigger
                                                            as-child
                                                        >
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
                                                                Se ativado o
                                                                cardápio irá
                                                                aparecer para o
                                                                cliente, caso
                                                                contrário não
                                                                será mostrado
                                                            </p>
                                                        </TooltipContent>
                                                    </Tooltip>
                                                </TooltipProvider>
                                            </div>
                                        </Field>
                                    </FieldGroup>
                                </FieldGroup>
                            </FieldGroup>
                        </FieldSet>
                        <FieldSeparator />
                    </FieldGroup>
                </div>
            </DialogHeader>
            <Button @click="dialogCardapio.setCardapio"> Salvar </Button>
            <Button @click="dialogCardapio.clearDialog()"> Cancel </Button>
        </DialogContent>
    </Dialog>
</template>
