<template>
  <Alert
    :show="show"
    :message="`Are you sure you want to delete this category?`"
    @close="emit('close')"
    @confirm="deleteCategory"
  />
</template>

<script setup>
import { Alert } from '@/components/common'
import { useStore } from 'vuex'

const props = defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
  model: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['close', 'confirm'])

const store = useStore()
const dispatch = store.dispatch

const deleteCategory = async () => {
  let { status } = await dispatch('REQUEST_DELETE_CATEGORY', {
    id: props.model.id,
  })
  if (status === 200) {
    dispatch('SHOW_NOTIF_ALERT', { message: 'Category deleted.' })
    emit('confirm')
  }
}
</script>
