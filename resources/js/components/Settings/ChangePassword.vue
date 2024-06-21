<template>
  <Card class="md:max-w-[400px] flex-1 h-max">
    <div class="mb-3 flex items-center justify-between gap-x-2">
      <Heading as="h3">Change Password</Heading>
    </div>

    <form novalidate class="space-y-4" @submit.prevent="updatePassword">
      <TextInput
        v-model="form.current_password"
        name="current_password"
        type="password"
        label="Current Password*"
        :errors="form.errors?.current_password"
      />

      <TextInput
        v-model="form.new_password"
        name="new_password"
        type="password"
        label="New Password*"
        :errors="form.errors?.new_password"
      />

      <TextInput
        v-model="form.confirm_password"
        type="password"
        name="confirm_password"
        label="Confirm Password*"
        :errors="form.errors?.confirm_password"
      />

      <div class="w-full !mt-5">
        <small class="text-red-500 block mb-2" v-text="form.errors?.message" />
        <!-- :disabled="!form.current_password || !form.new_password || !form.confirm_password" -->
        <Button
          type="submit"
          btn-type="primary"
          btn-size="md"
          text-size="lg"
          class="w-full justify-center"
        >
          Update
        </Button>
      </div>
    </form>
  </Card>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Card, Button, Heading, Icon } from '@/components/common'
import { TextInput } from '@/components/form'
import { useStore } from 'vuex'

const store = useStore()
const dispatch = store.dispatch

const form = ref({
  current_password: null,
  new_password: null,
  confirm_password: null,
  errors: {},
  success: '',
})

const reset = () => {
  form.value = {
    current_password: null,
    new_password: null,
    confirm_password: null,
    errors: {},
    success: '',
  }
}

const updatePassword = async () => {
  form.value.errors = {}

  if (form.value.new_password !== form.value.confirm_password) {
    form.value.errors.message = 'Passwords does not match.'
    return false
  }

  const { status, data } = await dispatch('UPDATE_PASSWORD', form.value)
  if (status === 200) {
    form.value.success = true
    reset()
    dispatch('SHOW_NOTIF_ALERT', { message: 'Changes saved.' })
  } else {
    form.value.errors = data.errors || data
    form.value.errors.name = ''
  }
}
</script>
