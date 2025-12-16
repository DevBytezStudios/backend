<script setup lang="ts">
import type { SidebarProps } from '@/components/ui/sidebar';

import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { BookOpen, Bot, Home, InfoIcon } from 'lucide-vue-next';
import SystemLogo from './SystemLogo.vue';

import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarRail,
} from '@/components/ui/sidebar';
import NavProduto from './NavProduto.vue';
import useConfeitariaStore from '@/stores/ConfeitariaStore';
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
            title: 'Catálogo',
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
        // {
        //     title: 'Encomenda',
        //     url: '#',
        //     icon: BookOpen,
        //     items: [
        //         {
        //             title: 'Pedidos',
        //             url: '#',
        //         },
        //         {
        //             title: 'Informações',
        //             url: '#',
        //         },
        //     ],
        // },
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
