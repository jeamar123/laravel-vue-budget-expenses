<template>
  <Modal
    :show="show"
    title="Create Transaction"
    wrapper-class="lg:max-w-[600px]"
    @close="emit('close')"
  >
    <template #body-footer>
      <TransactionForm
        api-route="REQUEST_CREATE_TRANSACTION"
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
})

const emit = defineEmits(['close', 'success'])
</script>
