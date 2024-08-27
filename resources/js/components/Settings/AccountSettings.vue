<template>
  <Card class="md:max-w-[500px] flex-1">
    <div class="mb-3 flex items-center justify-between gap-x-2">
      <Heading as="h3">Account Settings</Heading>
    </div>

    <form novalidate class="space-y-4" @submit.prevent="updateSettings">
      <TextInput
        v-model="form.first_name"
        name="first_name"
        label="First Name*"
        :errors="form.errors?.first_name"
      />

      <TextInput
        v-model="form.last_name"
        name="last_name"
        label="Last Name*"
        :errors="form.errors?.last_name"
      />

      <TextInput
        v-model="form.email"
        name="email"
        label="Email*"
        :errors="form.errors?.email"
      />

      <TextInput
        v-model="form.username"
        name="username"
        label="Username*"
        :errors="form.errors?.username"
      />

      <SelectInput
        v-model="form.currency_code"
        name="currency_code"
        label="Currency Code*"
        :items="currency_codes"
        key-value="code"
        key-label="name"
        :errors="form.errors?.currency_code"
        search
      />

      <div class="w-full !mt-5">
        <small class="text-red-500 block mb-2" v-text="form.errors.message" />
        <Button
          type="submit"
          btn-type="primary"
          btn-size="md"
          text-size="lg"
          class="w-full justify-center"
          :disabled="
            !form.first_name || !form.last_name || !form.email || !form.username
          "
        >
          Update
        </Button>
      </div>
    </form>
  </Card>
</template>

<script setup>
import { ref, computed, onMounted, reactive } from 'vue'
import { Card, Button, Heading, Icon } from '@/components/common'
import { TextInput, SelectInput } from '@/components/form'
import { useStore } from 'vuex'
import { currency_codes } from '@/composables/currency'

const props = defineProps({
  model: {
    type: Object,
    required: true,
  },
})

const store = useStore()
const dispatch = store.dispatch

const form = ref({
  first_name: props.model?.first_name ?? null,
  last_name: props.model?.last_name ?? null,
  email: props.model?.email ?? null,
  username: props.model?.username ?? null,
  currency_code: props.model?.currency_code ?? null,
  errors: {},
  success: '',
})

const updateSettings = async () => {
  const { status, data } = await dispatch('UPDATE_ACCOUNT_SETTINGS', form.value)
  if (status === 200) {
    form.value.success = true
    dispatch('SHOW_NOTIF_ALERT', { message: 'Changes saved.' })
  } else {
    form.value.errors = data.errors
    form.value.errors.name = ''
  }
}
</script>
