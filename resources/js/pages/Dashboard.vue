<script setup lang="ts">
import BarChart from '@/components/Analitycs/BarChart.vue';
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
    <AppLayout page="Home">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
           
        </div>
        <div class="min-h-[100vh] flex-1 rounded-xl bg-muted/50 md:min-h-min">
           
        </div>
    </AppLayout>
</template>

<style scoped>
.cardAnalytic {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 1rem;
    background: var(--card, #fff);
    color: var(--foreground, #000);
    border: 1px solid var(--border, #000);
}

.icon-wrapper {
    padding: 0.75rem;
    border-radius: 9999px;
    background: var(--muted, #000);
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon {
    width: 24px;
    height: 24px;
    color: #fff;
}

.text-wrapper {
    display: flex;
    flex-direction: column;
}

.label {
    font-size: 0.875rem;
    opacity: 0.7;
}

.value {
    font-size: 1.75rem;
    font-weight: bold;
    line-height: 1;
}
</style>
