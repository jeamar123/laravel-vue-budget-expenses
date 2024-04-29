<template>
  <Modal
    :show="show"
    title="Create Category"
    wrapper-class="lg:max-w-[500px]"
    @close="emit('close')"
  >
    <template #body-footer>
      <CategoryForm
        api-route="REQUEST_CREATE_CATEGORY"
        :type="type"
        @close="emit('close')"
        @success="emit('success')"
      />
    </template>
  </Modal>
</template>

<script setup>
import { Modal } from '@/components/common'
import { CategoryForm } from '@/components/Category'

defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
  type: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(['close', 'success'])
</script>
