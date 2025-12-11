<script setup lang="ts">
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import type { LucideIcon } from 'lucide-vue-next';

defineProps<{
    items: {
        title: string;
        url: string;
        icon?: LucideIcon;
        isActive?: boolean;
        items?: {
            title: string;
            url: string;
        }[];
    }[];
}>();
</script>

<template>
    <SidebarGroup>
        <SidebarGroupLabel>Inicio</SidebarGroupLabel>
        <SidebarMenuItem v-for="item in items" :key="item.title">
            <SidebarMenuButton as-child>
                <a :href="item.url">
                    <component :is="item.icon" />
                    <span>{{ item.title }}</span>
                </a>
            </SidebarMenuButton>
        </SidebarMenuItem>
    </SidebarGroup>
</template>
