<template>
  <Loading v-if="isLoading" />
  <Card class="w-[450px] !py-6 !px-6">
    <h5 class="text-center text-xl font-medium mb-8" v-text="`Register`" />
    <form class="space-y-5" @submit.prevent="register">
      <TextInput
        v-model="form.first_name"
        name="first_name"
        placeholder="First Name*"
        :errors="form.errors?.first_name"
      />
      
      <TextInput
        v-model="form.last_name"
        name="last_name"
        placeholder="Last Name*"
        :errors="form.errors?.last_name"
      />

      <TextInput
        v-model="form.email"
        name="email"
        placeholder="Email*"
        :errors="form.errors?.email"
      />

      <TextInput
        v-model="form.username"
        name="username"
        placeholder="Username*"
        :errors="form.errors?.username"
      />

      <TextInput
        v-model="form.password"
        name="password"
        type="password"
        placeholder="Password*"
        :errors="form.errors?.password"
      />

      <TextInput
        v-model="form.confirm_password"
        type="password"
        name="confirm_password"
        placeholder="Confirm Password*"
        :errors="form.errors?.confirm_password"
      />

      

      <div class="w-full !mt-10">
        
        <small class="text-red-500 block mb-2" v-text="form.errors.message" />
        <Button
          type="submit"
          btn-type="primary"
          btn-size="md"
          text-size="lg"
          class="w-full justify-center"
          :disabled="form.success !== ''"
        >
          Submit
        </Button>
        <small class="text-green-600 block mt-2 w-full text-center" v-text="form.success" />
      </div>

      <p class="text-center text-xs text-gray-600 !mt-10">
        Already have an account? <router-link :to="{ name: 'Login' }" class="underline hover:text-primary">Go to Login</router-link>
      </p>
    </form>
  </Card>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Button, Card, Loading } from '@/components/common'
import { TextInput } from '@/components/form'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'

const store = useStore()
const dispatch = store.dispatch
const router = useRouter()

const isLoading = computed(() => store.state.auth.isLoading)

const form = ref({
  username: null,
  password: null,
  errors: {},
  success: ''
})

const register = async () => {
  form.value.errors.message = ''
  if (!form.value.first_name || !form.value.last_name || !form.value.email || !form.value.username || !form.value.password) {
    form.value.errors.message = 'Please input required (*) fields.'
    return false
  }

  if (form.value.password !== form.value.confirm_password) {
    form.value.errors.message = 'Passwords does not match.'
    return false
  }

  const { status, data } = await dispatch('REQUEST_AUTH_REGISTER', form.value)
  console.log(data)
  if (status === 201) {
    form.value.success = 'Registration successful. You can now login.'
  } else {
    form.value.errors = data.errors
    form.value.errors.message = data.message
  }
}
</script>
