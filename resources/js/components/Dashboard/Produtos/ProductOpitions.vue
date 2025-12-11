<script setup lang="ts">
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';
import Button from '@/components/ui/button/Button.vue';
import Field from '@/components/ui/field/Field.vue';
import FieldLabel from '@/components/ui/field/FieldLabel.vue';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import Input from '@/components/ui/input/Input.vue';
import useDialogProduto from '@/stores/dialogProduto';
import { Opcao, Variacao } from '@/types/types';
import {
    Coins,
    PlusCircle,
    TextCursorIcon,
    Trash,
    Trash2,
} from 'lucide-vue-next';
const dialogProduto = useDialogProduto();

interface Props {
    variante: Variacao;
}

const emit = defineEmits(['removerVariacao', 'adicionarOpcao']);
const props = defineProps<Props>();

// CONFIGURAÇÂO DE VARIAÇÔES
const removerVariacao = (variaco: Variacao) => {
    if (variaco.id != 0) {
        dialogProduto.deleteVariaco(variaco.id);
        return;
    }

    dialogProduto.variacoes = dialogProduto.variacoes.filter(
        (v) => v.titulo !== variaco.titulo,
    );
};

const removerOpcao = (indexOpcao: number, opcao: Opcao) => {
    if (props.variante.opcoes) {
        props.variante.opcoes = props.variante.opcoes?.filter(
            (opcao, index) => index != indexOpcao,
        );
        if (opcao.id != 0) {
            dialogProduto.deleteOpcao(opcao.id);
        }
    }
};

const addOption = () => {
    emit('adicionarOpcao');
};
</script>

<template>
    <Accordion type="multiple" class="w-full gap-2 space-y-2">
        <AccordionItem value="item-1" class="rounded-lg border px-2">
            <AccordionTrigger class="flex items-end">
                <Field>
                    <FieldLabel> Nome do campo de variação </FieldLabel>
                    <Input
                        placeholder="Ex.. Sabores, Recheios, Tamanhos"
                        v-model="variante.titulo"
                    />
                </Field>
                <Button
                    type="button"
                    size="icon"
                    variant="ghost"
                    class="h-10 w-10"
                    @click="removerVariacao(variante)"
                >
                    <Trash2 class="size-4 text-red-500" />
                </Button>
            </AccordionTrigger>

            <AccordionContent class="mt-2 max-h-50 space-y-2 overflow-auto">
                <div
                    class="justify-space flex items-center gap-2"
                    v-for="(opcao, index) in variante.opcoes"
                    :key="index"
                >
                    <Field class="flex-1">
                        <FieldLabel>Título</FieldLabel>
                        <InputGroup>
                            <InputGroupInput
                                placeholder="Morango com Chocolate"
                                type="text"
                                v-model="opcao.titulo"
                            />
                            <InputGroupAddon align="inline-start">
                                <TextCursorIcon />
                            </InputGroupAddon>
                        </InputGroup>
                    </Field>

                    <Field class="flex-1">
                        <FieldLabel>Valor</FieldLabel>
                        <InputGroup>
                            <InputGroupInput
                                placeholder="99,99"
                                type="number"
                                v-model="opcao.valor"
                            />
                            <InputGroupAddon align="inline-start">
                                <Coins />
                            </InputGroupAddon>
                        </InputGroup>
                    </Field>

                    <Button
                        variant="destructive"
                        size="icon"
                        class="mt-6"
                        type="button"
                        @click="removerOpcao(index, opcao)"
                    >
                        <Trash class="h-4 w-4" />
                    </Button>
                </div>
                <Button
                    type="button"
                    variant="outline"
                    class="w-full gap-1"
                    @click="addOption"
                >
                    <PlusCircle class="size-4" /> Adicionar opção
                </Button>
            </AccordionContent>
        </AccordionItem>
    </Accordion>
</template>
