<template>
  <div
    class="z-50 flex h-full w-full items-center justify-center"
    :class="{
      'fixed top-0 left-0 bg-[rgba(0,0,0,0.3)]': placement === 'external'
    }"
  >
    <div
      class="rounded-md px-6 py-3 text-center text-xs"
      :class="{
        'bg-white': placement === 'external',
        '': placement === 'internal'
      }"
    >
      <slot name="icon">
        <!-- <FontAwesomeIcon
          :icon="['fal', 'spinner']"
          class="mx-auto mb-3 block text-3xl text-primary"
          spin
        /> -->

        <!-- <svg
          class="fill-gray-400 w-32 h-32"
          version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
          viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
          <path d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
            <animateTransform 
              attributeName="transform" 
              attributeType="XML" 
              type="rotate"
              dur="1s" 
              from="0 50 50"
              to="360 50 50" 
              repeatCount="indefinite" />
          </path>
        </svg> -->

        <svg
          class="w-20 h-20 mb-3"
          version="1.1"
          id="L3"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          viewBox="0 0 100 100"
          enable-background="new 0 0 0 0"
          xml:space="preserve"
        >
          <circle
            class="stroke-[#94A3B8]"
            fill="none"
            stroke="#fff"
            stroke-width="3"
            cx="50"
            cy="50"
            r="44"
            style="opacity: 0.3"
          />
          <circle
            class="stroke-[#94A3B8]"
            fill="#fff"
            stroke="#e74c3c"
            stroke-width="3"
            cx="8"
            cy="54"
            r="6"
            style="opacity: 0.8"
          >
            <animateTransform
              attributeName="transform"
              dur="2s"
              type="rotate"
              from="0 50 48"
              to="360 50 52"
              repeatCount="indefinite"
            />
          </circle>
        </svg>
      </slot>
      <p>Loading...</p>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps({
  placement: {
    type: String,
    default: 'external'
  }
})
</script>
