<template>
  <div class="flex flex-row gap-y-2 gap-x-2 md:gap-x-4 md:items-center">
    <Dropdown
      v-model="selectedView"
      class="w-max md:w-auto"
      :items="['daily', 'monthly', 'calendar']"
      @update:model-value="emitChanges"
    />
    <PopoverWrapper
      v-slot="{ close }"
      button-class="bg-white"
      panel-class="w-max"
      :button-label="dateButtonLabel"
    >
      <template v-if="selectedView === 'daily'">
        <Datepicker
          v-model="selectedDay"
          @update:model-value="
            (value) => {
              dateChanged(value, close)
            }
          "
        />
      </template>

      <template v-if="selectedView === 'monthly'">
        <Datepicker
          v-model="selectedMonth"
          :month-picker="true"
          @update:model-value="
            (value) => {
              dateChanged(value, close)
            }
          "
        />
      </template>

      <template v-if="selectedView === 'calendar'">
        <Datepicker
          v-model="selectedRange"
          :range="true"
          @update:model-value="
            (value) => {
              dateChanged(value, close)
            }
          "
        />
      </template>
    </PopoverWrapper>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Dropdown, PopoverWrapper, Datepicker } from '@/components/common'
import { format } from '@/composables/date'
import { startOfMonth, endOfMonth } from 'date-fns'

const emit = defineEmits(['dates-changed'])

const dateButtonLabel = computed(() => {
  let start = format(selectedRange.value[0], 'MMM dd, yyyy')
  let end = format(selectedRange.value[1], 'MMM dd, yyyy')
  let rangeLabel = `${start} - ${end}`

  let monthLabel = format(
    new Date(selectedMonth.value.year, selectedMonth.value.month),
    'MMM yyyy',
  )

  if (selectedView.value === 'daily')
    return format(selectedDay.value, 'MMM dd, yyyy')
  if (selectedView.value === 'monthly') return monthLabel
  if (selectedView.value === 'calendar') return rangeLabel

  return 'Date label'
})

const selectedView = ref('monthly')
const selectedDay = ref(new Date())
const selectedMonth = ref({
  month: Number(format(new Date(), 'MM')) - 1,
  year: Number(format(new Date(), 'yyyy')),
})
const selectedRange = ref([new Date(), new Date()])

// When Datepicker value is change, sync other view dates
const dateChanged = (date, close) => {
  if (selectedView.value === 'daily') {
    selectedMonth.value = {
      month: Number(format(selectedDay.value, 'M')) - 1,
      year: Number(format(selectedDay.value, 'yyyy')),
    }
    selectedRange.value = [selectedDay.value, selectedDay.value]
  }
  if (selectedView.value === 'monthly') {
    selectedDay.value = new Date(
      startOfMonth(
        new Date(selectedMonth.value.year, selectedMonth.value.month),
      ),
    )
    selectedRange.value = [
      selectedDay.value,
      new Date(endOfMonth(selectedDay.value)),
    ]
  }
  if (selectedView.value === 'calendar') {
    selectedDay.value = selectedRange.value[0]
    selectedMonth.value = {
      month: Number(format(selectedRange.value[0], 'M')) - 1,
      year: Number(format(selectedRange.value[0], 'yyyy')),
    }
  }
  close()

  emitChanges()
}

const emitChanges = () => {
  let dates = {
    start: new Date(),
    end: new Date(),
  }
  if (selectedView.value === 'daily') {
    dates.start = format(selectedDay.value, 'yyyy-MM-dd')
    dates.end = format(selectedDay.value, 'yyyy-MM-dd')
  }
  if (selectedView.value === 'monthly') {
    dates.start = format(
      startOfMonth(
        new Date(selectedMonth.value.year, selectedMonth.value.month),
      ),
      'yyyy-MM-dd',
    )
    dates.end = format(
      endOfMonth(new Date(selectedMonth.value.year, selectedMonth.value.month)),
      'yyyy-MM-dd',
    )
  }
  if (selectedView.value === 'calendar') {
    dates.start = format(selectedRange.value[0], 'yyyy-MM-dd')
    dates.end = format(selectedRange.value[1], 'yyyy-MM-dd')
  }
  emit('dates-changed', dates)
}
</script>
