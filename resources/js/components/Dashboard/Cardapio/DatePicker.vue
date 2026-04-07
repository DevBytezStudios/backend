<script setup lang="ts">
import type { DateValue } from '@internationalized/date'
import { DateFormatter, getLocalTimeZone, today } from '@internationalized/date'

import { CalendarIcon } from 'lucide-vue-next'
import { cn } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import Calendar from '@/components/ui/calendar/CalendarMni.vue'
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import { Ref, ref } from 'vue'
const emits = defineEmits(['update:model'])

const defaultPlaceholder = today(getLocalTimeZone())
const date = ref() as Ref<DateValue>
const df = new DateFormatter('pt-BR', {
  dateStyle: 'short',
});

</script>

<template>
  <Popover>
    <PopoverTrigger as-child>
      <Button
        variant="outline"
        :class="cn('w-full justify-start text-left font-normal md:w-[240px]', !date && 'text-muted-foreground')"
      >
        <CalendarIcon />
        {{ date ? df.format(date.toDate(getLocalTimeZone())) : "Escolha a data" }}
      </Button>
    </PopoverTrigger>
    <PopoverContent class="w-auto p-0" align="start">
      <Calendar
        v-model="date"
        
        :default-placeholder="defaultPlaceholder"
        layout="month-and-year"
        initial-focus
        locale="pt-BR"
        :min-value="defaultPlaceholder"
        @update:model-value="emits('update:model',date.toString())"
      />
    </PopoverContent>
  </Popover>
</template>
