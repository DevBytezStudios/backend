<script setup lang="ts">
import { computed } from 'vue'
import * as LucideIcons from 'lucide-vue-next'

const props = defineProps<{
  name: string
}>()

const icon = computed(() => {
  /**
   * Aceita:
   * - "cake"
   * - "lucide:cake"
   */
  const rawName = props.name.includes(':')
    ? props.name.split(':')[1]
    : props.name

  // transforma cake -> Cake
  const pascalName =
    rawName.charAt(0).toUpperCase() + rawName.slice(1)

  return (LucideIcons as any)[pascalName] || null
})
</script>

<template>
  <component
    v-if="icon"
    :is="icon"
    class="h-5 w-5"
  />
</template>
