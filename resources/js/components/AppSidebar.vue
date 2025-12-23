<script setup lang="ts">
import type { SidebarProps } from '@/components/ui/sidebar';

import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { BookOpen, Bot, CakeIcon, Home, InfoIcon } from 'lucide-vue-next';

import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarRail,
} from '@/components/ui/sidebar';
import useConfeitariaStore from '@/stores/ConfeitariaStore';
import NavProduto from './NavProduto.vue';
const confeitariaStore = useConfeitariaStore();
const props = withDefaults(defineProps<SidebarProps>(), {
    collapsible: 'icon',
});

const data = {
    user: confeitariaStore.confeitaria,
    navInfo: [
        {
            title: 'Home',
            url: '/dashboard',
            icon: Home,
        },
        {
            title: 'Informações',
            url: '/informacoes',
            icon: InfoIcon,
        },
    ],

    navProdutos: [
        {
            title: 'Menu',
            url: '#',
            icon: Bot,
            items: [
                {
                    title: 'Produtos',
                    url: '/catalogo/produtos',
                },
                {
                    title: 'Pedidos',
                    url: '/catalogo/pedidos',
                },
                {
                    title: 'Categorias',
                    url: '/catalogo/categorias',
                },
            ],
        },
        {
            title: 'Encomenda',
            url: '#',
            icon: CakeIcon,
            items: [
                {
                    title: 'Etapas',
                    url: '/encomenda/etapas',
                },
                {
                    title: 'Opcões',
                    url: '/encomenda/opcoes',
                },
                {
                    title: 'Estilos',
                    url: '/encomenda/estilos',
                },
                {
                    title: 'Encomendas',
                    url: '/encomenda/encomendas',
                },
            ],
        },
    ],
};
</script>

<template>
    <Sidebar v-bind="props">
        <SidebarHeader>
            <!-- <SystemLogo /> -->
        </SidebarHeader>
        <SidebarContent>
            <NavMain :items="data.navInfo" />
            <NavProduto :items="data.navProdutos" />
        </SidebarContent>
        <SidebarFooter>
            <NavUser :confeitaria="data.user" />
        </SidebarFooter>
        <SidebarRail />
    </Sidebar>
</template>
