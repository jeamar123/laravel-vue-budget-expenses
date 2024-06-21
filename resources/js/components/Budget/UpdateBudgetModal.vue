<template>
  <Modal
    :show="show"
    title="Update Budget"
    wrapper-class="lg:max-w-[500px]"
    @close="emit('close')"
  >
    <template #body-footer>
      <BudgetForm
        api-route="REQUEST_UPDATE_BUDGET"
        :model="model"
        @close="emit('close')"
        @success="emit('success')"
      />
    </template>
  </Modal>
</template>

<script setup>
import { Modal } from '@/components/common'
import { BudgetForm } from '@/components/Budget'

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
