<script lang="ts" setup>
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeftSquareIcon, FolderPlusIcon } from 'lucide-vue-next';
interface Props {
    cardapio: Cardapio;
}

import DialogProduto from '@/components/Dashboard/Cardapio/Produtos/DialogProduto.vue';
import ItemCategoria from '@/components/Dashboard/Cardapio/Produtos/ItemCategoria.vue';
import { Accordion } from '@/components/ui/accordion';
import { Cardapio } from '@/types/types';
import DialogItemCategoria from '@/components/Dashboard/Cardapio/Produtos/DialogItemCategoria.vue';
import useDialogProduto from '@/stores/Cardapio/DialogProdutoStore';
import useDialogCategoria from '@/stores/Cardapio/DialogCategoriaStore';
const props = defineProps<Props>();
const dialogProduto = useDialogProduto();
const dialogCategoria = useDialogCategoria();
const mockcardapio = {
    id: 1,
    id_con: 10,
    titulo: 'Coleção de Verão 2026',
    cor_princ: '#FF8C94',
    cor_sec: '#FFAAA5',
    dt_inicio: '2026-01-01',
    dt_fim: '2026-03-31',
    status: 'ativo',
};

const menuCompleto = [
    {
        id: 1,
        id_cardap: 10,
        titulo: 'Bolos',
        produtos: [
            {
                id: 101,
                nome: 'Bolo Festivo de Chocolate',
                descricao:
                    'Chocolate belga 70% cacau, recheio trufado e cobertura de ganache.',
                valor: 180.0,
                valor_desc: 155.0,
                imagem: 'https://images.unsplash.com/photo-1578985545062-69928b1d9587',
                categoria_id: 1,
            },
            {
                id: 102,
                nome: 'Red Velvet Especial',
                descricao: 'Massa aveludada com recheio de cream cheese.',
                valor: 160.0,
                valor_desc: 140.0,
                imagem: 'https://images.unsplash.com/photo-1616541823729-00fe0aacd32c',
                categoria_id: 1,
            },
        ],
    },
    {
        id: 2,
        id_cardap: 10,
        titulo: 'Doces',
        produtos: [
            {
                id: 103,
                nome: 'Brigadeiro Pistache',
                descricao: 'Feito com pistache iraniano e chocolate nobre.',
                valor: 8.5,
                valor_desc: 7.0,
                imagem: 'https://images.unsplash.com/photo-1548365328-8c6db3220e4c',
                categoria_id: 2,
            },
            {
                id: 104,
                nome: 'Macaron de Lavanda',
                descricao: 'Clássico francês com infusão natural de lavanda.',
                valor: 12.0,
                valor_desc: 10.5,
                imagem: 'https://images.unsplash.com/photo-1559181567-c3190ca9959b',
                categoria_id: 2,
            },
        ],
    },
];

</script>

<template>
    <AppLayout :page="`Cardápio: ${mockcardapio.titulo}`">
        <DialogProduto />
        <DialogItemCategoria/>
        <div
            class="flex max-w-full flex-col flex-wrap items-center gap-10 align-middle"
        >
            <div class="flex w-full flex-wrap justify-between">
                <h1 class="text-xl font-extrabold md:text-4xl">
                    {{ mockcardapio.titulo }}
                </h1>
                <Link href="/cardapios">
                    <Button :style="{ background: mockcardapio.cor_princ }">
                        <ArrowLeftSquareIcon /> Voltar</Button
                    >
                </Link>
            </div>

            <Accordion type="single" collapsible class="w-full space-y-4">
                <ItemCategoria
                    v-for="(categoria, index) in menuCompleto"
                    :key="index"
                    :categoria="categoria"
                    @add-produto="dialogCategoria.open = !dialogCategoria.open"
                    @edit="dialogCategoria.open = !dialogCategoria.open"
                    :color="{
                        princ: mockcardapio.cor_princ,
                        sec: mockcardapio.cor_sec,
                    }
                    "
                />
            </Accordion>

            <Button
                class="w-fit"
                @click="dialogCategoria.open = !dialogCategoria.open"
                :style="{ background: mockcardapio.cor_princ }"
            >
                <FolderPlusIcon /> Nova Categoria</Button
            >
        </div>
    </AppLayout>
</template>
