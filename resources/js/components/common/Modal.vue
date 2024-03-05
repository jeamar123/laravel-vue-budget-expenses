<template>
  <TransitionRoot appear :show="show">
    <Dialog
      as="div"
      open
      class="fixed top-0 -left-[2px] z-[4] h-screen w-full overflow-y-auto"
      @close="emit('close')"
    >
      <TransitionChild
        as="template"
        enter="duration-200 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <DialogOverlay class="fixed top-0 left-0 h-full w-full bg-black bg-opacity-50" />
      </TransitionChild>

      <TransitionChild
        as="template"
        enter="duration-200 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="h-screen overflow-y-auto font-sans text-sm text-[#27272a]">
          <div
            class="flex min-h-screen justify-center pl-1 py-2 md:py-10"
            :class="{
              'items-start': verticalPosition === 'top',
              'items-center': verticalPosition === 'center'
            }"
          >
            <div
              :class="[
                'relative w-[99%] md:w-full lg:max-w-[500px] bg-white shadow-md rounded-lg',
                wrapperClass
              ]"
            >
              <slot v-if="showHeader" name="header">
                <div
                  class="flex justify-between items-center rounded-t-lg py-3 px-4 border-b"
                  :class="headerClass"
                >
                  <Heading as="h2">
                    {{ title || '' }}
                  </Heading>
                  <Button variant="blank" class="" @click="emit('close')">
                    <XMarkIcon class="w-4" />
                  </Button>
                </div>
              </slot>

              <div :class="['px-4 pt-4 pb-8', bodyClass]">
                <slot />
              </div>

              <slot v-if="showFooter" name="footer">
                <div
                  class="flex items-center justify-end gap-x-4 p-4"
                  :class="{
                    'justify-end': footerButtonsAlignment === 'right',
                    'justify-center': footerButtonsAlignment === 'center',
                    'justify-start': footerButtonsAlignment === 'left'
                  }"
                >
                  <Button variant="blank" @click="emit('close')">
                    {{ closeButtonText }}
                  </Button>
                  <Button @click="emit('confirm')">
                    {{ confirmButtonText }}
                  </Button>
                </div>
              </slot>
            </div>
          </div>
        </div>
      </TransitionChild>
    </Dialog>
  </TransitionRoot>
</template>

<script setup lang="ts">
import { TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'
import { Button, Heading } from '@/components/common'
import { XMarkIcon } from '@heroicons/vue/24/outline'

defineProps({
  show: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: ''
  },
  bodyClass: {
    type: String,
    default: ''
  },
  wrapperClass: {
    type: String,
    default: ''
  },
  verticalPosition: {
    type: String,
    default: 'center' // top, center
  },

  showHeader: {
    type: Boolean,
    default: true
  },
  headerClass: {
    type: String,
    default: ''
  },

  showFooter: {
    type: Boolean,
    default: true
  },
  footerButtonsAlignment: {
    type: String,
    default: 'right' // left, center, right
  },
  closeButtonText: {
    type: String,
    default: 'Cancel'
  },
  confirmButtonText: {
    type: String,
    default: 'Confirm'
  }
})

const emit = defineEmits(['close', 'confirm'])
</script>
