<template>
  <Loading v-if="isLoading" />
  <Card class="w-[450px] !py-6 !px-6">
    <h5 class="text-center text-xl font-medium mb-8" v-text="`Login`" />
    <form class="space-y-5" @submit.prevent="login">
      <TextInput
        v-model="form.username"
        name="username"
        placeholder="Username"
        :errors="form.errors?.username"
      />

      <TextInput
        v-model="form.password"
        type="password"
        placeholder="Password"
        :errors="form.errors?.password"
      />

      <div class="w-full !mt-10">
        <small class="text-red-500 mb-2 block" v-text="form.errors.message" />
        <Button
          type="submit"
          btn-type="primary"
          btn-size="md"
          text-size="lg"
          class="w-full justify-center"
        >
          Go
        </Button>
      </div>

      <p class="text-center text-xs text-gray-600 !mt-10">
        Don't have account yet? <router-link :to="{ name: 'Register' }" class="underline hover:text-primary">Register</router-link>
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
})

const login = async () => {
  if (!form.value.username || !form.value.password) {
    form.value.errors.message = 'username and password is required.'
    return false
  }

  const { status, data } = await dispatch('REQUEST_AUTH_LOGIN', form.value)
  console.log(data)
  if (status === 200) {
    router.push({
      name: 'Transactions',
    })
  } else {
    form.value.errors.message = data.message
  }
}
</script>
