<template>
  <Modal
    :show="show"
    title="Edit Account"
    wrapper-class="lg:max-w-[500px]"
    @close="emit('close')"
  >
    <template #body-footer>
      <AccountForm
        api-route="REQUEST_UPDATE_ACCOUNT"
        :model="model"
        @close="emit('close')"
        @success="emit('success')"
      />
    </template>
  </Modal>
</template>

<script setup>
import { Modal } from '@/components/common'
import { AccountForm } from '@/components/Account'

defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
  model: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['close', 'success'])
</script>
