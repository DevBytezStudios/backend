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
import useConfeitariaStore from '@/stores/ConfeitariaStore';
import { Confeitaria } from '@/types/types';
import { Icon } from '@iconify/vue';
import { useColorMode } from '@vueuse/core';
import Button from './ui/button/Button.vue';
import Switch from './ui/switch/Switch.vue';

interface Props {
    confeitaria: Confeitaria;
}
const props = defineProps<Props>();

const { isMobile } = useSidebar();

const confeitariaStore = useConfeitariaStore();

const mode = useColorMode();

function toggleTheme() {
    mode.value = mode.value === 'dark' ? 'light' : 'dark';
}
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
                    <DropdownMenuGroup class="space-y-3">
                        <!-- Notificações -->
                        <div
                            class="flex w-full items-center justify-between gap-3"
                        >
                            <div class="flex flex-col leading-tight">
                                <span
                                    class="flex items-center gap-2 text-sm font-medium"
                                >
                                    Notificações
                                    <BellIcon class="h-4 w-4" />
                                </span>

                                <span class="text-xs text-muted-foreground">
                                    {{
                                        confeitariaStore.notification
                                            ? 'Ativadas'
                                            : 'Desativadas'
                                    }}
                                </span>
                            </div>

                            <Switch
                                id="swNotificacao"
                                v-model="confeitariaStore.notification"
                            />
                        </div>

                        <!-- Tema -->
                        <div
                            class="flex w-full items-center justify-between gap-3"
                        >
                            <div class="flex flex-col leading-tight">
                                <span class="text-sm font-medium">Tema</span>
                                <span class="text-xs text-muted-foreground">
                                    {{ mode === 'dark' ? 'Escuro' : 'Claro' }}
                                </span>
                            </div>

                            <Button
                                variant="outline"
                                size="icon"
                                @click="toggleTheme"
                                class="relative"
                            >
                                <Icon
                                    icon="radix-icons:moon"
                                    class="h-[1.2rem] w-[1.2rem] scale-100 rotate-0 transition-all dark:scale-0 dark:-rotate-90"
                                />

                                <Icon
                                    icon="radix-icons:sun"
                                    class="absolute h-[1.2rem] w-[1.2rem] scale-0 rotate-90 transition-all dark:scale-100 dark:rotate-0"
                                />
                            </Button>
                        </div>
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
