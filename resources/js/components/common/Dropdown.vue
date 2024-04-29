<template>
  <Menu as="div" class="min-w-16 cursor-pointer">
    <div class="relative">
      <MenuButton
        class="relative flex items-center gap-x-2 w-full rounded-lg py-2 px-3 text-left shadow-md focus:outline-none text-xs hover:opacity-90 border border-slate-500 text-slate-700 bg-white"
      >
        <slot name="button-content">
          <span class="block truncate capitalize">
            {{
              fixedPlaceholder
                ? placeholder || 'Select'
                : selectedValue
                  ? selectedValue
                  : placeholder
            }}
          </span>
          <ChevronDownIcon class="w-4 text-slate-700" aria-hidden="true" />
        </slot>
      </MenuButton>
      <transition
        leave-active-class="transition duration-100 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <MenuItems
          as="div"
          class="absolute max-h-60 border min-w-[150px] overflow-auto rounded-md bg-white z-10"
          :class="[
            dropdownDirection === 'bottom'
              ? 'bottom-10 md:bottom-auto md:top-10'
              : 'bottom-10',
          ]"
        >
          <MenuItem
            v-for="item in items"
            :key="item"
            as="div"
            class="cursor-pointer border-b border-[#e9eef4] px-3 pt-[10px] pb-[7px] text-xs text-[#3d4146] hover:bg-[#f8f9fa] capitalize"
            @click="
              () => {
                selectedValue = item
                emit('change', selectedValue)
                emit('update:model-value', selectedValue)
              }
            "
          >
            {{ item }}
          </MenuItem>
        </MenuItems>
      </transition>
    </div>
  </Menu>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
  modelValue: {
    type: [String, Boolean, Number, Object, null],
    default: null,
  },
  dropdownDirection: {
    type: String,
    default: 'bottom', // top, bottom
  },
  placeholder: {
    type: String,
    default: '',
  },
  // Think of a better key name
  fixedPlaceholder: {
    type: Boolean,
    default: () => false,
  },
})

const emit = defineEmits(['change', 'update:model-value'])
const selectedValue = ref(props.modelValue)
</script>
