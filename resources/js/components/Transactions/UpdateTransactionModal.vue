<template>
  <Modal
    :show="show"
    title="Edit Transaction"
    wrapper-class="lg:max-w-[500px]"
    @close="emit('close')"
  >
    <template #body-footer>
      <TransactionForm
        api-route="REQUEST_UPDATE_TRANSACTION"
        :model="model"
        @close="emit('close')"
        @success="emit('success')"
      />
    </template>
  </Modal>
</template>

<script setup>
import { Modal } from '@/components/common'
import { TransactionForm } from '@/components/Transactions'

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

const emit = defineEmits(['close', 'confirm', 'success'])
</script>
