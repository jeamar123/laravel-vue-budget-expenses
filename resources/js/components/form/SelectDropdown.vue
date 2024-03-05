<template>
  <Listbox
    as="div"
    v-model="selectedValue"
    class="cursor-pointer"
    @update:model-value="(value) => emit('update:model-value', value)"
  >
    <div class="relative">
      <ListboxButton
        class="relative w-full rounded-lg bg-white px-2 py-3 text-left focus:outline-none border-2 border-form-border bg-slate-100 text-slate-800"
      >
        <span class="block truncate">{{ selectedValue }}</span>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
          <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </span>
      </ListboxButton>

      <transition
        leave-active-class="transition duration-100 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <ListboxOptions
          class="absolute max-h-60 border border-primary w-full overflow-auto rounded-md bg-white"
          :class="[
            dropdownDirection === 'bottom'
              ? 'bottom-[50px] md:bottom-auto md:top-[50px]'
              : 'bottom-[50px]'
          ]"
        >
          <ListboxOption
            v-slot="{ active, selected }"
            v-for="item in items"
            :key="item.id"
            :value="item"
            as="template"
          >
            <li
              :class="[
                active || selected ? 'bg-primary text-white' : 'text-gray-900',
                'relative select-none p-2'
              ]"
              v-text="item"
            />
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { Listbox, ListboxButton, ListboxOptions, ListboxOption } from '@headlessui/vue'
import { ChevronUpDownIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  items: {
    type: Object,
    required: true
  },
  modelValue: {
    type: [String, Boolean, Number, Object, null],
    default: null
  },
  dropdownDirection: {
    type: String,
    default: 'bottom' // top, bottom
  }
})

const emit = defineEmits(['update:model-value', 'change'])
const selectedValue = ref(props.modelValue || props.items[0])
</script>
