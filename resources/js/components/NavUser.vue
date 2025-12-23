<script setup lang="ts">
import { BellIcon, ChevronsUpDown, LogOut } from 'lucide-vue-next';

import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { Confeitaria } from '@/types/types';
import Label from './ui/label/Label.vue';
import Switch from './ui/switch/Switch.vue';
import useConfeitariaStore from '@/stores/ConfeitariaStore';

interface Props {
    confeitaria: Confeitaria;
}
const props = defineProps<Props>();

const { isMobile } = useSidebar();

const confeitariaStore = useConfeitariaStore();
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton
                        size="lg"
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                    >
                        <Avatar class="h-8 w-8 rounded-lg">
                            <AvatarImage
                                :src="confeitaria.logo"
                                :alt="confeitaria.nome"
                            />
                            <AvatarFallback class="rounded-lg">
                                CN
                            </AvatarFallback>
                        </Avatar>
                        <div
                            class="grid flex-1 text-left text-sm leading-tight"
                        >
                            <span class="truncate font-medium">{{
                                confeitaria.nome
                            }}</span>
                            <span class="truncate text-xs">{{
                                confeitaria.email
                            }}</span>
                        </div>
                        <ChevronsUpDown class="ml-auto size-4" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    class="w-[--reka-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                    :side="isMobile ? 'bottom' : 'right'"
                    align="end"
                    :side-offset="4"
                >
                    <DropdownMenuLabel class="p-0 font-normal">
                        <div
                            class="flex items-center gap-2 px-1 py-1.5 text-left text-sm"
                        >
                            <Avatar class="h-8 w-8 rounded-lg">
                                <AvatarImage
                                    :src="confeitaria.logo"
                                    :alt="confeitaria.nome"
                                />
                                <AvatarFallback class="rounded-lg">
                                    CN
                                </AvatarFallback>
                            </Avatar>
                            <div
                                class="grid flex-1 text-left text-sm leading-tight"
                            >
                                <span class="truncate font-semibold">{{
                                    confeitaria.nome
                                }}</span>
                                <span class="truncate text-xs">{{
                                    confeitaria.email
                                }}</span>
                            </div>
                        </div>
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuGroup>
                        <!-- <DropdownMenuItem> -->
                            <div class="flex items-center space-x-2">
                                <Switch id="swNotificacao" v-model="confeitariaStore.notification"/>
                                <Label for="swNotificacao">Notificações <BellIcon class="w-4"/></Label>
                            </div>
                        <!-- </DropdownMenuItem> -->
                    </DropdownMenuGroup>
                    <DropdownMenuSeparator />

                    <a href="/auth/logout">
                        <DropdownMenuItem>
                            <LogOut />
                            Sair
                        </DropdownMenuItem>
                    </a>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
