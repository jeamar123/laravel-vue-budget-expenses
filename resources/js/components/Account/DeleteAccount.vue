<template>
  <Alert
    :show="show"
    :message="`Are you sure you want to delete this account?`"
    @close="emit('close')"
    @confirm="deleteAccount"
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

const deleteAccount = async () => {
  let { status } = await dispatch('REQUEST_DELETE_ACCOUNT', {
    id: props.model.id,
  })
  if (status === 200) {
    dispatch('SHOW_NOTIF_ALERT', { message: 'Account deleted.' })
    emit('confirm')
  }
}
</script>
