<template>
  <Popover v-slot="{ open, close }" class="relative" :class="containerClass">
    <PopoverButton
      class="relative flex items-center gap-x-2 w-full rounded py-2 px-3 text-left focus:outline-none text-xs hover:opacity-90 border border-slate-400 text-slate-700"
      :class="[open ? '' : '', buttonClass]"
    >
      <slot name="button-value">
        <span class="block truncate capitalize">{{ buttonLabel }}</span>
        <ChevronDownIcon class="w-4 text-slate-700" aria-hidden="true" />
      </slot>
    </PopoverButton>

    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="translate-y-1 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="translate-y-0 opacity-100"
      leave-to-class="translate-y-1 opacity-0"
    >
      <PopoverPanel
        class="absolute z-[10] bg-white left-0 top-[38px] w-full rounded bg-white border"
        :class="panelClass"
      >
        <slot :close="close"></slot>
      </PopoverPanel>
    </transition>
  </Popover>
</template>

<script setup>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/24/outline'

defineProps({
  containerClass: {
    type: [String, Array, Object],
    default: '',
  },
  buttonLabel: {
    type: String,
    default: '',
  },
  buttonClass: {
    type: [String, Array, Object],
    default: '',
  },
  panelClass: {
    type: [String, Array, Object],
    default: '',
  },
})
</script>
