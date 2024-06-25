<template>
  <div
    class="z-50 flex h-full w-full items-center justify-center"
    :class="{
      'fixed top-0 left-0 bg-[rgba(0,0,0,0.1)]': placement === 'external',
    }"
  >
    <div
      class="rounded-md px-6 py-3 text-center text-xs"
      :class="{
        'bg-transparent': placement === 'external',
        'bg-white': placement === 'internal',
      }"
    >
      <slot name="icon">
        <svg
          class="loading-animation fill-cyan-500 w-14 h-14"
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          viewBox="0 0 100 100"
          enable-background="new 0 0 0 0"
          xml:space="preserve"
        >
          <path
            d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50"
          ></path>
        </svg>
      </slot>
      <p v-if="showText" class="text-cyan-800 italic font-medium">
        {{ loadingText }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps({
  placement: {
    type: String,
    default: 'external',
  },
  showText: {
    type: Boolean,
    default: () => true,
  },
  loadingText: {
    type: String,
    default: 'loading',
  },
})
</script>
