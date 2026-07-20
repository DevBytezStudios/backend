<script setup lang="ts">
import type { SidebarProps } from '@/components/ui/sidebar';

import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Home,
    Layers,
    ListCheck,
    Palette,
    Settings2Icon,
    ShoppingBag,
    Utensils,
} from 'lucide-vue-next';

import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarRail,
} from '@/components/ui/sidebar';
import useConfeitariaStore from '@/stores/ConfeitariaStore';
import NavCardapio from './NavCardapio.vue';
import NavEncomenda from './NavEncomenda.vue';
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
            title: 'Configurações',
            url: '/configuracoes',
            icon: Settings2Icon,
        },
    ],

    // navCardapios: [
    //     {
    //         title: 'Cardápios',
    //         url: '/cardapios',
    //         icon: Utensils,
    //     },
    // ],
    navEncomenda: [
        {
            icon: Layers,
            title: 'Etapas',
            url: '/encomenda/etapas',
        },
        {
            icon: ListCheck,
            title: 'Opções',
            url: '/encomenda/opcoes',
        },
        {
            icon: Palette,
            title: 'Estilos',
            url: '/encomenda/estilos',
        },
        {
            icon: ShoppingBag,
            title: 'Encomendas',
            url: '/encomenda/encomendas',
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
            <!-- <NavCardapio :items="data.navCardapios" /> -->
            <NavEncomenda :items="data.navEncomenda" />
        </SidebarContent>
        <SidebarFooter>
            <NavUser :confeitaria="data.user" />
        </SidebarFooter>
        <SidebarRail />
    </Sidebar>
</template>
