<template>
  <Modal
    :show="show"
    title="Create Account"
    wrapper-class="lg:max-w-[500px]"
    @close="emit('close')"
  >
    <template #body-footer>
      <AccountForm
        api-route="REQUEST_CREATE_ACCOUNT"
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
})

const emit = defineEmits(['close', 'success'])
</script>
