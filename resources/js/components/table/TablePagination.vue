<template>
  <div class="flex justify-between px-6">
    <div class="flex items-center gap-x-3">
      <label class="text-xs">Rows:</label>
      <SelectInput
        :items="[10, 25, 50, 100]"
        :model-value="data.per_page"
        dropdown-direction="top"
        @update:model-value="(value) => emit('rows', value)"
      />
    </div>
    <ul class="flex items-center gap-x-[2px]">
      <li
        class="w-8 h-8 rounded-lg flex items-center justify-center cursor-pointer"
        :class="[
          data.current_page === 1
            ? 'opacity-50 pointer-events-none'
            : 'hover:text-white hover:bg-primary',
        ]"
        @click="emit('paginate', data.current_page - 1)"
      >
        <ArrowLeftIcon class="w-4" />
      </li>
      <li
        v-for="page in data.last_page"
        :key="page"
        class="w-8 h-8 rounded-lg flex items-center justify-center text-xs cursor-pointer hover:text-white hover:bg-primary"
        :class="{
          'text-white bg-primary': page === data.current_page,
        }"
        @click="emit('paginate', page)"
      >
        {{ page }}
      </li>
      <li
        class="w-8 h-8 rounded-lg flex items-center justify-center cursor-pointer"
        :class="[
          data.current_page === data.last_page
            ? 'opacity-50 pointer-events-none'
            : 'hover:text-white hover:bg-primary',
        ]"
        @click="emit('paginate', data.current_page + 1)"
      >
        <ArrowRightIcon class="w-4" />
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { SelectInput } from '@/components/form'
import { ArrowLeftIcon, ArrowRightIcon } from '@heroicons/vue/24/outline'

defineProps({
  data: {
    type: Object,
    default: () => ({
      // page: 1,
      // per_page: 10,
      // totalItems: 1,
      // totalPages: 1,

      current_page: 1,
      last_page: 1,
      next_page_url: null,
      per_page: 5,
      prev_page_url: null,
      total: 5,
    }),
  },
})

const emit = defineEmits(['rows', 'paginate'])
</script>
