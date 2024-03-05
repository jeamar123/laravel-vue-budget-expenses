<template>
  <Modal
    :show-header="false"
    body-class="pt-5 !pb-5"
    wrapper-class="!max-w-[440px]"
    :show="show"
    @close="emit('close')"
  >
    <div class="text-center">
      <ExclamationCircleIcon class="w-28 text-sky-800 mx-auto" />
      <Heading as="h2" class="text-3xl">{{ title || 'Confirm' }}</Heading>
      <p class="" v-html="message || 'Are you sure?'"></p>
    </div>

    <template #footer>
      <div class="flex items-center justify-center gap-x-3 pb-6 pt-4 px-4">
        <Button variant="outline" @click="emit('close')">
          {{ closeButtonText }}
        </Button>
        <Button @click="emit('confirm')">{{ confirmButtonText }}</Button>
      </div>
    </template>
  </Modal>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Modal, Button, Heading } from '@/components/common'
import { ExclamationCircleIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  show: {
    type: Boolean,
    default: () => false
  },
  title: {
    type: String,
    default: ''
  },
  message: {
    type: String,
    default: ''
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
