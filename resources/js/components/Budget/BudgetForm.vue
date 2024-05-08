<template>
  <form novalidate @submit.prevent="submit">
    <div class="px-6 pt-6 pb-8 space-y-4">
      <TextInput
        v-model="form.budget"
        type="number"
        label="Budget"
        :errors="form.errors?.budget"
      />
    </div>

    <div class="flex items-center justify-end gap-x-4 p-4">
      <Button variant="blank" @click="emit('close')"> Cancel </Button>
      <Button type="submit"> Confirm </Button>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import { Button } from '@/components/common'
import { TextInput } from '@/components/form'
import { useStore } from 'vuex'

const props = defineProps({
  model: {
    type: Object,
    default: () => {},
  },
  apiRoute: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(['close', 'success'])
const store = useStore()
const dispatch = store.dispatch

const form = ref({
  budget: props.model.budget,
  errors: {},
  success: false,

  ...props.model,
})

const submit = async () => {
  form.value.errors = {}
  const { data, status } = await dispatch(props.apiRoute, form.value)
  if ([200, 201].includes(status)) {
    form.value.success = true
    reset()
    dispatch('SHOW_NOTIF_ALERT', { message: 'Changes saved.' })
    emit('success')
  } else {
    form.value.errors = data.errors
    form.value.errors.name = ''
  }
}

const reset = () => {
  form.value = {
    name: null,
    errors: {},
    success: false,
  }
}
</script>
