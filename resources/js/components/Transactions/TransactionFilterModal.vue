<template>
  <Modal
    :show="show"
    title="Transaction Filters"
    wrapper-class="lg:!max-w-[350px]"
    @close="emit('close')"
  >
    <template #body-footer>
      <div class="space-y-4 px-6 py-6">
        <div class="">
          <label class="text-xs block font-semibold mb-1">Type</label>
          <Dropdown
            v-model="selectedView"
            class="!min-w-0"
            button-class="justify-between"
            :items="['daily', 'monthly', 'calendar']"
          />
        </div>

        <div>
          <label class="text-xs block font-semibold mb-1">Date</label>

          <div class="relative z-[1]">
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
          </div>
          

          <!-- <PopoverWrapper
            v-slot="{ close }"
            button-class="bg-white justify-between"
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
          </PopoverWrapper> -->
        </div>
      </div>

      <div class="flex items-center justify-end gap-x-4 p-4">
        <Button variant="blank"> Cancel </Button>
        <Button @click="emitChanges"> Submit </Button>
      </div>
    </template>
  </Modal>
</template>

<script setup>
import { ref, computed } from 'vue'
import {
  Button,
  Modal,
  Dropdown,
  PopoverWrapper,
  Datepicker,
} from '@/components/common'
import { format } from '@/composables/date'
import { startOfMonth, endOfMonth } from 'date-fns'

defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
})

const emit = defineEmits(['close', 'dates-changed'])

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

  // emitChanges()
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
