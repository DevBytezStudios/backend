<script lang="ts">
export const description = 'A sidebar that collapses to icons.';
export const iframeHeight = '800px';
export const containerClass = 'w-full h-full';
</script>

<script setup lang="ts">
import AppSidebar from '@/components/AppSidebar.vue';
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
} from '@/components/ui/breadcrumb';
import { Separator } from '@/components/ui/separator';
import {
    SidebarInset,
    SidebarProvider,
    SidebarTrigger,
} from '@/components/ui/sidebar';
import useConfeitariaStore from '@/stores/ConfeitariaStore';
import { useColorMode } from '@vueuse/core';
import { onMounted } from 'vue';
import { toast, Toaster } from 'vue-sonner';

interface Props {
    page: string;
}

const props = defineProps<Props>();
const mode = useColorMode();
const confeitariaStore = useConfeitariaStore();
mode.value = confeitariaStore.theme;

onMounted(() => {
    const audio = new Audio('/assets/notification.mp3');
    window.Echo.channel(`confeitaria.${confeitariaStore.confeitaria.id}`)
        .listen('NewPedido', () => {
            if (confeitariaStore.notification == true) {
                audio.play();
                toast.warning('Novo pedido!');
            }
        })
        .listen('NewEncomenda', () => {
            if (confeitariaStore.notification == true) {
                audio.play();
                toast.warning('Nova Encomenda!');
            }
        });
});
</script>

<template>
    <SidebarProvider>
        <AppSidebar />
        <SidebarInset>
            <header
                class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12"
            >
                <div class="flex items-center gap-2 px-4">
                    <SidebarTrigger class="-ml-1" />
                    <Separator
                        orientation="vertical"
                        class="mr-2 data-[orientation=vertical]:h-4"
                    />
                    <Breadcrumb>
                        <BreadcrumbList>
                            <BreadcrumbItem class="hidden md:block">
                                <BreadcrumbLink href="#">
                                    {{ props.page }}
                                </BreadcrumbLink>
                            </BreadcrumbItem>
                        </BreadcrumbList>
                    </Breadcrumb>
                </div>
            </header>
            <div class="flex flex-1 flex-col">
                <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
                    <Toaster position="bottom-center" />

                    <slot />
                </div>
            </div>
        </SidebarInset>
    </SidebarProvider>
</template>
