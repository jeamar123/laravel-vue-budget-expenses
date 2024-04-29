<template>
  <div class="flex flex-col gap-y-10">
    <div class="">
      <div v-if="showItemsInfo" class="flex justify-between px-4 py-2 text-xs">
        <div>
          {{ selectedItems.length }}
          selected
        </div>
        <div>
          Showing
          {{ data.length }}
          of
          {{ pagination.total }}
          results
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead>
            <tr>
              <th
                v-if="showCheckbox"
                class="sticky top-0 left-0 z-[2] bg-gray-100 pl-4 pr-2 py-2 font-normal rounded-l-md w-14"
              >
                <Checkbox
                  :checked="isSelectedAll"
                  @change="
                    (value) => {
                      selectAll(value)
                      emit('checkbox-checked', selectedItems)
                    }
                  "
                />
              </th>
              <th
                v-for="col in headers"
                :key="col.id"
                class="sticky top-0 bg-gray-100 text-left px-2 py-2 font-medium text-xs"
                :class="showCheckbox ? 'px-2' : 'px-2 first:pl-4 first:pr-2'"
              >
                <!-- @click="sortBy(idx)" -->
                <!-- <template v-if="sortEnabled">
                  <template v-if="sortColumn == idx">
                    <i v-if="sortOrder == 'desc'" class="icofont-arrow-up icofont-md active"></i>
                    <i v-else class="icofont-arrow-down icofont-md active"></i>
                  </template>
                  <template v-else>
                    <i v-if="col.sortable" class="icofont-sort icofont-md"></i>
                  </template>
                </template> -->
                <span> {{ col.label }}</span>
              </th>
              <th
                v-if="
                  actions.enable ||
                  Object.keys(actions).find((i) => actions[i] === true)
                "
                class="sticky top-0 bg-gray-100 text-right pl-2 pr-4 py-4 font-normal rounded-r-md"
              >
                <!-- Actions -->
              </th>
            </tr>
          </thead>
          <tbody>
            <template v-if="data.length">
              <tr
                v-for="row in data"
                :key="row.id"
                class="group cursor-pointer"
                @click.stop="emit('show', row)"
              >
                <td
                  v-if="showCheckbox"
                  class="sticky left-0 z-[2] pl-4 pr-2 py-3 group-even:bg-gray-50 group-odd:bg-white rounded-l-md"
                >
                  <Checkbox
                    :checked="selectedItems.includes(row.id)"
                    @change="
                      (value) => {
                        selectItem(row.id, value)
                        emit('checkbox-checked', selectedItems)
                      }
                    "
                  />
                </td>
                <!-- typeof row[col.key] === 'number' && (
                      row[col.key] < 0 ? 'font-medium text-red-600' : 'font-medium text-green-600'
                    ) -->
                <td
                  v-for="col in headers"
                  :key="col.id"
                  class="py-3 whitespace-nowrap group-even:bg-gray-50"
                  :class="[
                    showCheckbox ? 'px-2' : 'px-2 first:pl-4 first:pr-2',
                  ]"
                >
                  <span v-if="['created_at', 'date'].includes(col.key)">{{
                    format(row[col.key], 'MMM dd yyyy')
                  }}</span>
                  <span
                    v-else-if="['total', 'amount', 'remaining'].includes(col.key)"
                    class=""
                    :class="
                      row[col.key] < 0 ? 'font-medium text-red-600' : 'font-medium text-green-900'
                    "
                    >{{ formatNumber(row[col.key]) }}</span
                  >
                  <span
                    v-else-if="typeof row[col.key] === 'number'"
                    >{{ formatNumber(row[col.key]) }}</span
                  >
                  <span
                    v-else-if="['category'].includes(col.key)"
                    class="inline-block border border-slate-400 py-[1px] px-1 rounded text-xs"
                  >
                    {{ row[col.key] }}
                  </span>
                  <span v-else>
                    {{ row[col.key] }}
                  </span>
                </td>
                <td class="pl-2 pr-4 group-even:bg-gray-50 rounded-r-md">
                  <div
                    v-if="actions.enable || row.showActions"
                    class="flex items-center justify-end gap-x-1"
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
                      v-if="actions.edit"
                      variant="blank"
                      class="!px-1"
                      @click="emit('edit', row)"
                    >
                      <PencilSquareIcon class="w-4" />
                    </Button>
                    <Button
                      v-if="actions.delete"
                      variant="blank"
                      class="!px-1"
                      @click="emit('delete', row)"
                    >
                      <TrashIcon class="w-4" />
                    </Button>
                  </div>
                </td>
              </tr>
            </template>
            <template v-else>
              <tr class="bg-gray-50 text-center px-6">
                <td
                  :colspan="headers.length + 1 + (actions.enable ? 1 : 0)"
                  class="py-5"
                >
                  No items yet
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>

    <TablePagination
      v-if="showPagination"
      :data="pagination"
      @rows="(rows) => emit('rows', rows)"
      @paginate="(page) => emit('paginate', page)"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import TablePagination from './TablePagination.vue'
import { Button } from '@/components/common'
import { Checkbox } from '@/components/form'
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { format } from '@/composables/date'
import { formatNumber } from '@/composables/number'

const props = defineProps({
  headers: {
    type: Array,
    default: () => [],
  },
  data: {
    type: Array,
    default: () => [],
  },
  showPagination: {
    type: Boolean,
    default: () => false,
  },
  showCheckbox: {
    type: Boolean,
    default: () => true,
  },
  pagination: {
    type: Object,
    default: () => {},
  },
  actions: {
    type: Object,
    default: () => ({
      enable: true,
      show: true,
      edit: true,
      delete: true,
    }),
  },
  showItemsInfo: {
    // TODO: Think of a better Name
    type: Boolean,
    default: () => true,
  },
})

const emit = defineEmits([
  'rows',
  'paginate',
  'edit',
  'show',
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
    selectedItems.value = props.data.map(({ id }) => id)
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
