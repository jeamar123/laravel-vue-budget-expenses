<template>
  <div class="fixed top-10 right-5 z-[99] space-y-2">
    <transition
      enter-active-class="transform ease-out duration-300 transition"
      enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
      enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
      leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isNotificationShown"
        class="relative min-w-[250px] max-w-[400px] min-h-[65px] overflow-hidden rounded bg-white py-3 px-5 text-sm shadow"
        data-test="alert-container"
      >
        <div class="absolute top-0 left-0 h-full w-[5px] bg-primary"></div>
        <a class="absolute top-1 right-2 cursor-pointer" @click="hideNotif">
          <XMarkIcon class="w-4 h-4 text-slate-500 hover:text-slate-300" />
        </a>

        <h3 class="font-medium text-primary" v-text="title || 'Success'" />
        <p class="font-normal text-[#3d4146]" v-text="message" />
      </div>
    </transition>
  </div>
</template>

<script setup>
import { watch, ref } from 'vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
  title: {
    type: [String, null],
    default: null,
  },
  message: {
    type: [String, Object, null],
    default: null,
  },
})

const emit = defineEmits(['hide'])

let timeout = null
const isNotificationShown = ref(props.show)

const hideNotif = () => {
  isNotificationShown.value = false
  clearTimeout(timeout)
  emit('hide')
}

watch(
  () => props.show,
  async (value) => {
    if (value) {
      isNotificationShown.value = true
      timeout = setTimeout(() => {
        hideNotif()
      }, 5000)
    } else {
      hideNotif()
    }
  },
)
</script>
