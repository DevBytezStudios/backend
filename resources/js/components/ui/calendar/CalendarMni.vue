<script lang="ts" setup>
import type { CalendarRootEmits, CalendarRootProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { reactiveOmit } from "@vueuse/core"
import { CalendarRoot, useForwardPropsEmits } from "reka-ui"
import { cn } from "@/lib/utils"
import { 
  CalendarCell, 
  CalendarCellTrigger, 
  CalendarGrid, 
  CalendarGridBody, 
  CalendarGridHead, 
  CalendarGridRow, 
  CalendarHeadCell, 
  CalendarHeader, 
  CalendarHeading, 
  CalendarNextButton, 
  CalendarPrevButton 
} from "."

const props = defineProps<CalendarRootProps & { class?: HTMLAttributes["class"] }>()

const emits = defineEmits<CalendarRootEmits>()

const delegatedProps = reactiveOmit(props, "class")

const forwarded = useForwardPropsEmits(delegatedProps, emits)
</script>

<template>
  <CalendarRoot
    v-slot="{ grid, weekDays }"
    :class="cn('p-3 w-fit border rounded-md shadow-sm bg-card', props.class)"
    v-bind="forwarded"
  >
    <CalendarHeader class="flex items-center justify-between pb-2">
      <CalendarPrevButton class="h-7 w-7 bg-transparent p-0 opacity-50 hover:opacity-100" />
      <CalendarHeading class="text-sm font-medium" />
      <CalendarNextButton class="h-7 w-7 bg-transparent p-0 opacity-50 hover:opacity-100" />
    </CalendarHeader>

    <div class="flex flex-col gap-y-4 sm:flex-row sm:gap-x-4 sm:gap-y-0">
      <CalendarGrid v-for="month in grid" :key="month.value.toString()" class="w-full border-collapse">
        <CalendarGridHead>
          <CalendarGridRow class="flex">
            <CalendarHeadCell
              v-for="day in weekDays" :key="day"
              class="w-9 rounded-md text-[0.8rem] font-normal text-muted-foreground"
            >
              {{ day.slice(0, 1) }} </CalendarHeadCell>
          </CalendarGridRow>
        </CalendarGridHead>
        
        <CalendarGridBody>
          <CalendarGridRow 
            v-for="(weekDates, index) in month.rows" 
            :key="`weekDate-${index}`" 
            class="flex w-full mt-1"
          >
            <CalendarCell
              v-for="weekDate in weekDates"
              :key="weekDate.toString()"
              :date="weekDate"
              class="relative h-9 w-9 p-0 text-center text-sm focus-within:relative focus-within:z-20"
            >
              <CalendarCellTrigger
                :day="weekDate"
                :month="month.value"
                :class="cn(
                  'h-9 w-9 p-0 font-normal aria-selected:opacity-100 rounded-md transition-colors',
                  'hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground',
                  'aria-selected:bg-primary aria-selected:text-primary-foreground aria-selected:hover:bg-primary aria-selected:hover:text-primary-foreground'
                )"
              >
                {{ weekDate.day }}
              </CalendarCellTrigger>
            </CalendarCell>
          </CalendarGridRow>
        </CalendarGridBody>
      </CalendarGrid>
    </div>
  </CalendarRoot>
</template>