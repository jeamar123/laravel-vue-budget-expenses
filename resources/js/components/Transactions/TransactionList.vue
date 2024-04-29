<template>
  <div>
    <Card class="!px-2 !py-3 md:!p-4 flex items-center gap-x-5 !bg-slate-200">
      <div class="shrink-0">
        <Checkbox
          :checked="isSelectedAll"
          @change="
            (value) => {
              selectAll(value)
              emit('checkbox-checked', selectedItems)
            }
          "
        />
      </div>
      <div class="grid md:grid-cols-5 gap-x-2 flex-1">
        <div class="hidden md:block font-medium text-xs">Date</div>
        <div class="hidden md:block font-medium text-xs">Note</div>
        <div class="hidden md:block font-medium text-xs">Total</div>
        <div class="hidden md:block font-medium text-xs">Source</div>
        <div class="hidden md:block font-medium text-xs">Category</div>
        <div class="block md:hidden font-medium text-xs">Transactions</div>
      </div>
      <div class="font-medium text-xs w-[52px]">Actions</div>
    </Card>
    <div class="py-2 space-y-2 overflow-y-auto max-h-[calc(100vh-182px)] mr-[-3px] pr-[3px]">
      <template
        v-for="transaction in transactions"
        :key="transaction.id"
      >
        <Card class="!px-2 !py-3 md:!p-4 flex items-start gap-x-5">
          <div class="shrink-0">
            <Checkbox
              :checked="selectedItems.includes(transaction.id)"
              @change="
                (value) => {
                  selectItem(transaction.id, value)
                  emit('checkbox-checked', selectedItems)
                }
              "
            />
          </div>
          <div class="grid md:grid-cols-5 gap-y-1 gap-x-2 flex-1 items-start">
            <div>{{ format(transaction.date, 'MMM dd, yyyy') }}</div>
            <div>{{ transaction.description }}</div>
            <div
              class="font-medium"
              :class="transaction.total < 0 ? 'text-red-600' : 'text-green-600'"
            >{{ formatNumber(transaction.total) }}</div>
            <div class="capitalize">{{ transaction.source }}</div>
            <div>
              <span class="inline-block border border-slate-400 py-[1px] px-1 rounded text-xs">
                {{ transaction.category }}
              </span>
            </div>
          </div>
          <div
            class="flex items-center justify-end gap-x-1 w-[52px]"
          >
            <!-- <Button
              v-if="actions.show"
              variant="blank"
              class="!p-0"
              @click="emit('show', row)"
            >
              <DocumentMagnifyingGlassIcon class="w-5" />
            </Button> -->
            <Button
              variant="blank"
              class="!px-1 !py-0"
              @click="emit('edit', transaction)"
            >
              <PencilSquareIcon class="w-4" />
            </Button>
            <Button
              variant="blank"
              class="!px-1 !py-0"
              @click="emit('delete', transaction)"
            >
              <TrashIcon class="w-4" />
            </Button>
          </div>
        </Card>
      </template>

      <div v-if="!transactions.length" class="text-center px-4 py-3 text-xs">
        No items yet.
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Card, Button } from '@/components/common'
import { Checkbox } from '@/components/form'
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { format } from '@/composables/date'
import { formatNumber } from '@/composables/number'

const props = defineProps({
  transactions: {
    type: Array,
    default: () => [],
  },
})

const emit = defineEmits([
  'edit',
  'delete',
  'selected',
  'checkbox-checked',
])

const isSelectedAll = ref(false)
const selectedItems = ref([])

const selectAll = (selected) => {
  isSelectedAll.value = selected

  if (!selected) {
    selectedItems.value = []
  } else {
    selectedItems.value = props.transactions.map(({ id }) => id)
  }

  emit('selected', selectedItems.value)
}

const selectItem = (item, selected) => {
  isSelectedAll.value = false

  if (!selected) {
    selectedItems.value = selectedItems.value.filter(
      (itemVal) => itemVal !== item,
    )
  } else if (!selectedItems.value.includes(item)) {
    selectedItems.value.push(item)
  }

  emit('selected', selectedItems.value)
}
</script>
