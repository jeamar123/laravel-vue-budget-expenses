<template>
  <Modal
    :show-header="false"
    body-class="!pt-10 !pb-6 !px-6"
    wrapper-class="!max-w-[440px]"
    :show="show"
    @close="emit('close')"
  >
    <slot>
      <div class="text-center">
        <ExclamationCircleIcon class="w-28 text-sky-800 mx-auto mb-5" />
        <Heading as="h2" class="text-3xl mb-2">{{
          title || 'Confirm'
        }}</Heading>
        <!-- eslint-disable-next-line vue/no-v-html -->
        <p class="" v-html="message || 'Are you sure?'"></p>
      </div>
    </slot>

    <template #footer>
      <div class="flex items-center justify-center gap-x-3 pb-6 pt-4 px-4 border-t">
        <Button variant="outline" @click="emit('close')">
          {{ closeButtonText }}
        </Button>
        <Button @click="emit('confirm')">{{ confirmButtonText }}</Button>
      </div>
    </template>
  </Modal>
</template>

<script setup lang="ts">
import { Modal, Button, Heading } from '@/components/common'
import { ExclamationCircleIcon } from '@heroicons/vue/24/outline'

defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
  title: {
    type: String,
    default: '',
  },
  message: {
    type: String,
    default: '',
  },

  closeButtonText: {
    type: String,
    default: 'Cancel',
  },
  confirmButtonText: {
    type: String,
    default: 'Confirm',
  },
})

const emit = defineEmits(['close', 'confirm'])
</script>
