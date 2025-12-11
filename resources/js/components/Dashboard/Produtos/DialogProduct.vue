<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
const emits = defineEmits(['closeDialog', 'saveProduct']);

// FECHAR O DIALOG
const closeDialog = () => {
    emits('closeDialog');
};

import useDialogProduto from '@/stores/dialogProduto';
const dialogProduto = useDialogProduto();

// CONFIGURAÇÔES DO FORM
import { FieldGroup, FieldSet } from '@/components/ui/field';
import Field from '@/components/ui/field/Field.vue';
import FieldLabel from '@/components/ui/field/FieldLabel.vue';
import FieldLegend from '@/components/ui/field/FieldLegend.vue';
import FieldSeparator from '@/components/ui/field/FieldSeparator.vue';
import Input from '@/components/ui/input/Input.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { PlusSquareIcon } from 'lucide-vue-next';
import UploadComponent from './UploadComponent.vue';

import { onUpdated, ref } from 'vue';
import ProductOpitions from './ProductOpitions.vue';
import { toast, Toaster } from 'vue-sonner';


onUpdated(() => {
    console.log('Atualizado', dialogProduto.variacoes);
});

const adicionarVariacao = () => {
    dialogProduto.variacoes.push({
        id: 0,
        'titulo': '',
        opcoes:[
            {
                id: 0,
                titulo: ' ',
                valor: 0
            }
        ]
    })
    // console.log(dialogProduto.produto)
};

const adicionarOpcao = (index:number) =>{
    console.log(index)
    dialogProduto.variacoes[index].opcoes?.push({
        id:0,
        titulo: '',
        valor: 0
    })
}


const saveProduct = () => {
    toast.success('Produto Salvo com sucesso')
    console.log(dialogProduto.produto,dialogProduto.variacoes);
};

import 'vue-sonner/style.css'

</script>

<template>
    <Dialog>
        <Toaster theme="system"/>
        <DialogContent class="max-h-[90vh] max-w-[90vw] md:max-w-150 overflow-y-auto rounded-lg p-6">
            <DialogHeader>
                <DialogTitle>Editar Produto</DialogTitle>
                <div>
                    <form>
                        <FieldGroup>
                            <FieldSet>
                                <FieldGroup>
                                    <FieldSet>
                                        <FieldLegend
                                            >Informações do produto</FieldLegend
                                        >
                                    </FieldSet>
                                    <FieldGroup>
                                        <Field>
                                            <FieldLabel>
                                                Imagem do Produto
                                            </FieldLabel>
                                            <UploadComponent
                                                :imagem="dialogProduto.produto.imagem"
                                            />
                                        </Field>
                                        <Field>
                                            <FieldLabel for="txtNome">
                                                Nome do Produto
                                            </FieldLabel>
                                            <Input
                                                id="txtNome"
                                                placeholder="Ex.. Trufa de chocolate"
                                                v-model="dialogProduto.produto.nome"
                                                required
                                            />
                                        </Field>
                                        <Field>
                                            <FieldLabel for="txtDesc">
                                                Descrição do produto
                                            </FieldLabel>
                                            <Textarea
                                                id="txtDesc"
                                                placeholder="Trufa de chocolate de 50g"
                                                class="resize-none"
                                                v-model="dialogProduto.produto.descricao"
                                            />
                                        </Field>
                                        <div class="grid grid-cols-3 gap-4">
                                            <Field>
                                                <FieldLabel for="numValor">
                                                    Valor do Produto
                                                </FieldLabel>
                                                <Input
                                                    value="0"
                                                    type="number"
                                                    id="numValor"
                                                    class="resize-none"
                                                    v-model="dialogProduto.produto.valor"
                                                />
                                            </Field>
                                            <Field>
                                                <FieldLabel for="numValorDesc">
                                                    Valor de desconto
                                                </FieldLabel>
                                                <Input
                                                    type="number"
                                                    id="numValorDesc"
                                                    class="resize-none"
                                                    v-model="dialogProduto.produto.valorDesc"
                                                />
                                            </Field>
                                            <Field>
                                                <FieldLabel for="slCategoria">
                                                    Categoria
                                                </FieldLabel>
                                                <Select
                                                    default-value=""
                                                    v-model="dialogProduto.produto.categoria"
                                                >
                                                    <SelectTrigger
                                                        id="slCategoria"
                                                    >
                                                        <SelectValue
                                                            placeholder="Ex.. Bolo"
                                                        />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        <SelectItem
                                                            value="Doce"
                                                        >
                                                            Doce
                                                        </SelectItem>
                                                    </SelectContent>
                                                </Select>
                                            </Field>
                                        </div>
                                    </FieldGroup>
                                </FieldGroup>
                            </FieldSet>
                            <FieldSeparator />
                            <FieldSet>
                                <FieldGroup
                                    class="flex flex-row justify-between"
                                >
                                    <FieldLegend
                                        >Variaçoes do produto</FieldLegend
                                    >
                                    <Button
                                        class="max-w-fit"
                                        type="button"
                                        @click="adicionarVariacao"
                                        ><PlusSquareIcon
                                    /></Button>
                                </FieldGroup>
                                <FieldGroup>
                                    <ProductOpitions
                                        v-for="(
                                            variation, index
                                        ) in dialogProduto.variacoes"
                                        :key="index"
                                        @adicionar-opcao="adicionarOpcao(index)"
                                        :variante="variation"
                                    />
                                    <!-- <ProductOpitions />
                                    <ProductOpitions />
                                    <ProductOpitions /> -->
                                </FieldGroup>
                            </FieldSet>
                        </FieldGroup>
                    </form>
                </div>
            </DialogHeader>
            <Button variant="secondary" @click="saveProduct"> Salvar </Button>
            <Button @click="closeDialog"> Cancel </Button>
        </DialogContent>
    </Dialog>
</template>

<style scoped>
.dialog {
    width: 300px;
}
</style>
