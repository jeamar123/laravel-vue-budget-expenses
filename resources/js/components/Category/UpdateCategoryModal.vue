<template>
  <Modal
    :show="show"
    title="Edit Category"
    wrapper-class="lg:max-w-[500px]"
    @close="emit('close')"
  >
    <template #body-footer>
      <CategoryForm
        api-route="REQUEST_UPDATE_CATEGORY"
        :model="model"
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
  model: {
    type: Object,
    required: true,
  },
  type: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(['close', 'success'])
</script>
