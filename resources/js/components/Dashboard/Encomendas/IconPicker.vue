<script setup lang="ts">
import { computed, ref } from 'vue'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import Icon from './Icon.vue'

const props = defineProps<{
  modelValue: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

const allIcons = [
  'candy',
]

const search = ref('')
const itemsPerPage = 50
const page = ref(1)

const filteredIcons = computed(() => {
  if (!search.value)
    return allIcons
  return allIcons.filter(name => name.toLowerCase().includes(search.value.toLowerCase()))
})

const visibleIcons = computed(() => {
  return filteredIcons.value.slice(0, page.value * itemsPerPage)
})

function loadMore() {
  if (page.value * itemsPerPage < filteredIcons.value.length)
    page.value++
}

const popoverOpen = ref(false)

function selectIcon(name: string) {
  emit('update:modelValue', `lucide:${name}`)
  popoverOpen.value = false
}
</script>

<template>
  <Popover v-model:open="popoverOpen">
    <PopoverTrigger as-child>
      <Button variant="outline">
        <Icon :name="props.modelValue" />
        <span v-if="props.modelValue"></span>
        <span v-else>Selecionar um icone</span>
      </Button>
    </PopoverTrigger>
    <PopoverContent class="w-[320px]">
      <div class="flex flex-col gap-2">
        <div
          class="grid grid-cols-6 max-h-[300px] gap-2 overflow-auto border rounded-md p-2"
          @scroll.passive="(e) => {
            const el = e.target as HTMLElement
            if (el.scrollTop + el.clientHeight >= el.scrollHeight - 50) loadMore()
          }"
        >
          <div
            v-for="name in visibleIcons"
            :key="name"
            class="flex cursor-pointer items-center justify-center border rounded p-2 hover:bg-accent"
            @click="selectIcon(name)"
          >
            <Icon :name="`lucide:${name}`" class="h-5 w-5" />
          </div>
        </div>
      </div>
    </PopoverContent>
  </Popover>
</template>