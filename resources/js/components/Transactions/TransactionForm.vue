<template>
  <form novalidate @submit.prevent="submit">
    <div class="space-y-4 px-6 pt-6 pb-8">
      <SelectInput
        v-model="form.type"
        label="Type"
        :items="['income', 'expenses']"
        :errors="form.errors?.type"
        @update:model-value="form.category = null"
      />
      <TextInput
        v-model="form.total"
        label="Amount"
        type="number"
        :errors="form.errors?.total"
      />
      <TextInput
        v-model="form.description"
        label="Note"
        :errors="form.errors?.description"
      />
      <SelectInput
        v-model="form.category"
        label="Category"
        :items="categories.filter(({ type }) => type === form.type)"
        :errors="form.errors?.category"
      />
      <SelectInput
        v-model="form.source"
        label="Source"
        :items="sources"
        :errors="form.errors?.source"
      />
      <DatepickerInput
        v-model="form.date"
        label="Date"
        :errors="form.errors?.date"
      />
    </div>

    <div class="flex items-center justify-end gap-x-4 p-4">
      <Button variant="blank" @click="emit('close')"> Cancel </Button>
      <Button type="submit"> Submit </Button>
    </div>
  </form>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import { Button } from '@/components/common'
import { TextInput, SelectInput, DatepickerInput } from '@/components/form'
import { useStore } from 'vuex'
import { format } from '@/composables/date'

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

const sources = computed(() => store.state.accounts.items)
const categories = computed(() => store.state.category.items)

const form = ref({
  type: 'expenses',
  source: null,
  total: null,
  description: null,
  category: null,
  date: new Date(),
  errors: {},
  success: false,

  ...props.model,
})

const submit = async () => {
  form.value.errors = {}
  if (form.value.date)
    form.value.date = format(new Date(form.value.date), 'yyyy-MM-dd HH:mm:ss')
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
    source: null,
    total: null,
    description: null,
    category: null,
    date: new Date(),
    errors: {},
    success: false,
  }
}
</script>
