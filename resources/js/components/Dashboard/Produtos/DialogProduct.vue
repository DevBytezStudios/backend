<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
const emits = defineEmits(['closeDialog', 'saveProduct']);

import useDialogProduto from '@/stores/DialogProduto';
const dialogProduto = useDialogProduto();
const loading = ref(false);

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
import { ref } from 'vue';
import { toast, Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
import ProductOpitions from './ProductOpitions.vue';
import UploadComponent from './UploadComponent.vue';
// FECHAR O DIALOG
const closeDialog = () => {
    dialogProduto.clearDialog();
    emits('closeDialog');
};

const adicionarVariacao = () => {
    dialogProduto.variacoes.push({
        id: 0,
        id_produto: 0,
        titulo: '',
        opcoes: [
            {
                id: 0,
                id_var: 0,
                nome: ' ',
                valor: 0,
            },
        ],
    });
    // console.log(dialogProduto.produto)
};

const adicionarOpcao = (index: number) => {
    dialogProduto.variacoes[index].opcoes?.push({
        id: 0,
        id_var: 0,
        nome: '',
        valor: 0,
    });
};

const deleteVariacao = async (idVariacao: number) => {
    const response = await dialogProduto.deleteVariaco(idVariacao);
    if (response.success) {
        toast.success(response.success.titulo);
    } else {
        toast.error(response.error.titulo);
    }
};

const deleteOpcao = async (idOpcao: number) => {
    const response = await dialogProduto.deleteOpcao(idOpcao);
    if (response.success) {
        toast.success(response.success.titulo);
    } else {
        toast.error(response.error.titulo);
    }
};

const saveProduct = async () => {
    const response = await dialogProduto.saveProduto();
    console.log(response);
    if (response.success) {
        closeDialog();
        toast.success(response.success.titulo);
    } else {
        toast.error(response.error.titulo);
    }
};
</script>

<template>
    <Dialog @update:open="emits('closeDialog')">
        <Toaster />

        <DialogContent
            class="max-h-[90vh] max-w-[90vw] overflow-y-auto rounded-lg p-6 md:max-w-150"
        >
            <DialogHeader>
                <DialogTitle>Editar Produto</DialogTitle>
                <div>
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
                                            :imagem="
                                                dialogProduto.produto.imagem
                                            "
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
                                            v-model="
                                                dialogProduto.produto.descricao
                                            "
                                        />
                                    </Field>
                                    <div class="grid grid-cols-3 gap-4">
                                        <Field>
                                            <FieldLabel for="numValor">
                                                Valor do Produto
                                            </FieldLabel>
                                            <Input
                                                type="number"
                                                id="numValor"
                                                class="resize-none"
                                                v-model="
                                                    dialogProduto.produto.valor
                                                "
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
                                                v-model="
                                                    dialogProduto.produto
                                                        .valor_desc
                                                "
                                            />
                                        </Field>
                                        <Field>
                                            <FieldLabel for="slCategoria">
                                                Categoria
                                            </FieldLabel>
                                            <Select
                                                v-model="
                                                    dialogProduto.produto
                                                        .categoria
                                                "
                                            >
                                                <SelectTrigger id="slCategoria">
                                                    <SelectValue
                                                        placeholder="Ex.. Bolo"
                                                    />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem
                                                        v-for="(
                                                            categoria, index
                                                        ) in dialogProduto.categorias"
                                                        :key="index"
                                                        :value="categoria"
                                                    >
                                                        {{ categoria.titulo }}
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
                            <FieldGroup class="flex flex-row justify-between">
                                <FieldLegend>Variaçoes do produto</FieldLegend>
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
                                        variante, index
                                    ) in dialogProduto.variacoes"
                                    :key="index"
                                    @adicionar-opcao="adicionarOpcao(index)"
                                    @delete-opcao="deleteOpcao"
                                    @delete-variacao="deleteVariacao"
                                    :variante="variante"
                                />
                            </FieldGroup>
                        </FieldSet>
                    </FieldGroup>
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
