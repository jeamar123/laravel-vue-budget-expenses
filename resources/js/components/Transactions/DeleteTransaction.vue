<template>
  <Alert
    :show="show"
    :message="`Are you sure you want to delete this transaction?`"
    @close="emit('close')"
    @confirm="deleteTransaction"
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
    type: [Object, Array],
    required: true,
  },
})

const emit = defineEmits(['close', 'confirm'])

const store = useStore()
const dispatch = store.dispatch

const deleteTransaction = async () => {
  let { status } = await dispatch('REQUEST_DELETE_TRANSACTION', {
    id: props.model.id,
  })
  if (status === 200) {
    dispatch('SHOW_NOTIF_ALERT', { message: 'Transaction deleted.' })
    emit('confirm')
  }
}
</script>
