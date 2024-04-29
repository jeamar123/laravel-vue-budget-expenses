<template>
  <Loading v-if="isLoading" />
  <Card class="w-[450px] !py-6 !px-6">
    <h5 class="text-center text-xl font-medium mb-8" v-text="`Login`" />
    <form class="space-y-5" @submit.prevent="login">
      <TextInput
        v-model="form.username"
        name="username"
        placeholder="Username"
      />

      <TextInput
        v-model="form.password"
        type="password"
        placeholder="Password"
      />

      <small class="text-red-500" v-text="form.errors.name" />

      <div class="w-full !mt-10">
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
    </form>
  </Card>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Button, Card, Loading } from '@/components/common'
import { TextInput } from '@/components/form'
import { REQUEST_AUTH_LOGIN } from '@/store/modules/auth'
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
    form.value.errors.name = 'username and password is required.'
    return false
  }

  const res = await dispatch(REQUEST_AUTH_LOGIN, form.value)
  if (res.status !== 400) {
    router.push({
      name: 'Transactions',
    })
  } else {
    form.value.errors.name = res.data.message
  }
}
</script>
