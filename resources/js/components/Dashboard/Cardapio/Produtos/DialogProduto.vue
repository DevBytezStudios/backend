<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    Field,
    FieldGroup,
    FieldLabel,
    FieldLegend,
    FieldSeparator,
    FieldSet,
} from '@/components/ui/field';
const dialogProduto = useDialogProduto();
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';
import Input from '@/components/ui/input/Input.vue';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { ref } from 'vue';
import 'vue-sonner/style.css';
import UploadComponent from '../../Produtos/UploadComponent.vue';
import ItemComplemento from './ItemComplemento.vue';
import useDialogProduto from '@/stores/Cardapio/DialogProdutoStore';

</script>

<template>
    <Dialog :open="dialogProduto.open">
        <DialogContent
            class="max-h-[90vh] max-w-[90vw] overflow-y-auto rounded-lg p-6 md:max-w-150"
        >
            <DialogHeader class="w-full">
                <DialogTitle>Editar Produto</DialogTitle>
                <div class="flex w-ful flex-col gap-6">
                    <Tabs default-value="info">
                        <TabsList class="w-full justify-start">
                            <TabsTrigger value="info">
                                Informações
                            </TabsTrigger>
                            <TabsTrigger value="comp">
                                Complementos
                            </TabsTrigger>
                        </TabsList>
                        <TabsContent value="info" class="w-full">
                            <div class="w-full">
                                <FieldGroup>
                                    <FieldSet>
                                        <FieldGroup>
                                            <FieldGroup>
                                                <Field>
                                                    <FieldLabel>
                                                        Imagem do Produto
                                                    </FieldLabel>
                                                    <UploadComponent />
                                                </Field>
                                                <Field>
                                                    <FieldLabel for="txtNome">
                                                        Nome do Produto
                                                    </FieldLabel>
                                                    <Input
                                                        id="txtNome"
                                                        placeholder="Ex.. Trufa de chocolate"
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
                                                    />
                                                </Field>
                                                <div
                                                    class="grid grid-cols-3 gap-4"
                                                >
                                                    <Field>
                                                        <FieldLabel
                                                            for="numValor"
                                                        >
                                                            Valor do Produto
                                                        </FieldLabel>
                                                        <Input
                                                            type="number"
                                                            id="numValor"
                                                            class="resize-none"
                                                        />
                                                    </Field>
                                                    <Field>
                                                        <FieldLabel
                                                            for="numValorDesc"
                                                        >
                                                            Valor de desconto
                                                        </FieldLabel>
                                                        <Input
                                                            type="number"
                                                            id="numValorDesc"
                                                            class="resize-none"
                                                        />
                                                    </Field>
                                                    <Field>
                                                        <FieldLabel
                                                            for="slCategoria"
                                                        >
                                                            Categoria
                                                        </FieldLabel>
                                                        <!-- <Select>
                                                            <SelectTrigger
                                                                id="slCategoria"
                                                            >
                                                                <SelectValue
                                                                    placeholder="Ex.. Bolo"
                                                                />
                                                            </SelectTrigger>
                                                            <SelectContent>
                                                                <SelectItem
                                                                    v-for="(
                                                                        categoria,
                                                                        index
                                                                    ) in dialogProduto.categorias"
                                                                    :key="index"
                                                                    :value="
                                                                        categoria
                                                                    "
                                                                >
                                                                    {{
                                                                        categoria.titulo
                                                                    }}
                                                                </SelectItem>
                                                            </SelectContent>
                                                        </Select> -->
                                                    </Field>
                                                </div>
                                            </FieldGroup>
                                        </FieldGroup>
                                    </FieldSet>
                                    <FieldSeparator />
                                </FieldGroup>
                            </div>
                        </TabsContent>
                        <TabsContent value="comp">
                            <FieldGroup>
                                <FieldSet>
                                    <Accordion
                                        type="single"
                                        class="w-full"
                                        collapsible
                                    >
                                        <ItemComplemento/>
                                    </Accordion>
                                    <FieldSeparator />
                                </FieldSet>
                            </FieldGroup>
                        </TabsContent>
                    </Tabs>
                </div>
            </DialogHeader>
            <Button variant="secondary"> Salvar </Button>
            <Button @click="dialogProduto.clearDialog()"> Cancelar </Button>
        </DialogContent>
    </Dialog>
</template>

<style scoped>
.dialog {
    width: 300px;
}
</style>
