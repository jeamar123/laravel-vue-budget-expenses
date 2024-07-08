<template>
  <div>
    <Card
      class="pl-2 !pr-2 !py-2 md:!pr-4 flex items-center gap-x-4 md:!bg-[#e9e9e9]"
    >
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
      <div class="grid md:grid-cols-4 gap-x-2 flex-1">
        <!-- <div class="hidden md:block font-medium text-xs">Date</div> -->
        <div class="hidden md:block font-medium text-xs">Note</div>
        <div class="hidden md:block font-medium text-xs">Total</div>
        <div class="hidden md:block font-medium text-xs">Source</div>
        <div class="hidden md:block font-medium text-xs">Category</div>
        <div class="block md:hidden font-medium text-xs">Transactions</div>
      </div>
      <div class="font-medium text-xs w-[52px]">
        <span class="hidden md:block">Actions</span>
      </div>
    </Card>
    <div class="md:py-2 md:space-y-2 mr-[-3px] pr-[3px]">
      <template v-for="transaction in transactions" :key="transaction.date">
        <div>
          <Card
            class="pl-2 !pr-2 !py-1 md:!pr-4 flex items-center gap-x-4 cursor-pointer !bg-[#f2f2f2] mb-1"
            @click="transaction.show = !transaction.show"
          >
            <div class="shrink-0">
              <Checkbox
                :checked="
                  [...transaction.items.map((item) => item.id)].every((item) =>
                    selectedItems.includes(item),
                  )
                "
                @click.stop
                @change="
                  (value) => {
                    selectAllUnderDate(
                      value,
                      transaction.items.map((item) => item.id),
                    )
                    emit('checkbox-checked', selectedItems)
                  }
                "
              />
            </div>
            <div class="font-semibold flex-1 text-xs">
              {{ format(transaction.date, 'MMM dd, yyyy') }}
            </div>
            <div class="shrink-0">
              <Icon
                :name="transaction.show ? 'ChevronUpIcon' : 'ChevronDownIcon'"
                class="w-5"
              />
            </div>
          </Card>
          <template v-if="transaction.show">
            <Card
              v-for="item in transaction.items"
              :key="item.id"
              class="!pl-2 !pr-2 !py-2 md:!pr-4 flex items-start gap-x-4 text-[13px]"
            >
              <div class="shrink-0">
                <Checkbox
                  :checked="selectedItems.includes(item.id)"
                  @change="
                    (value) => {
                      selectItem(item.id, value)
                      emit('checkbox-checked', selectedItems)
                    }
                  "
                />
              </div>
              <div
                class="grid md:grid-cols-4 gap-y-1 gap-x-2 flex-1 items-start"
              >
                <div>{{ item.description }}</div>
                <div
                  class="font-medium text-opacity-80"
                  :class="
                    item.category?.type === 'expenses'
                      ? 'text-red-600'
                      : 'text-green-600'
                  "
                >
                  {{
                    `${item.category?.type === 'expenses' ? '-' : ''}${formatNumber(item.total)}`
                  }}
                </div>
                <div>
                  <span
                    class="inline-block bg-blue-300 py-[1px] px-[6px] rounded text-xs"
                  >
                    {{ item.source }}
                  </span>
                </div>
                <div>
                  <span
                    class="inline-block bg-indigo-300 py-[1px] px-[6px] rounded text-xs"
                  >
                    {{ item.category?.name || 'Uncategorized' }}
                  </span>
                </div>
              </div>
              <div class="flex items-center justify-end gap-x-1 w-[52px]">
                <Button
                  variant="blank"
                  class="!px-1 !py-0"
                  @click="emit('edit', item)"
                >
                  <Icon name="PencilSquareIconOutline" class="w-4" />
                </Button>
                <Button
                  variant="blank"
                  class="!px-1 !py-0"
                  @click="emit('delete', item)"
                >
                  <Icon name="TrashIconOutline" class="w-4" />
                </Button>
              </div>
            </Card>
          </template>
        </div>
      </template>

      <div v-if="!transactions.length" class="text-center px-4 py-12 text-xs">
        No items yet.
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Card, Button, Icon } from '@/components/common'
import { Checkbox } from '@/components/form'
import { format } from '@/composables/date'
import { formatNumber } from '@/composables/number'

const props = defineProps({
  transactions: {
    type: Array,
    default: () => [],
  },
})

const emit = defineEmits(['edit', 'delete', 'selected', 'checkbox-checked'])

const isSelectedAll = ref(false)
const selectedItems = ref([])

const selectAll = (selected) => {
  isSelectedAll.value = selected

  if (!selected) {
    selectedItems.value = []
  } else {
    selectedItems.value = props.transactions.reduce((res, item) => {
      res = [...res, ...item.items.map(({ id }) => id)]
      return res
    }, [])
  }

  emit('selected', selectedItems.value)
}

const selectAllUnderDate = (selected, transactions) => {
  if (!selected) {
    selectedItems.value = selectedItems.value.filter((transaction) => {
      return !transactions.includes(transaction)
    })
  } else {
    transactions.forEach((transaction) => {
      if (!selectedItems.value.includes(transaction)) {
        selectedItems.value.push(transaction)
      }
    })
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
