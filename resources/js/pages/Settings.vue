<template>
  <div class="container md:py-2 lg:py-5 md:px-2 lg:px-8">
    <div class="flex flex-col md:flex-row gap-x-10 gap-y-5 w-full">
      <template v-if="user">
        <AccountSettings :model="user" />
        <ChangePassword :model="user" />
      </template>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Card, Button, Heading, Icon } from '@/components/common'
import { TextInput } from '@/components/form'
import { useStore } from 'vuex'
import { AccountSettings, ChangePassword } from '@/components/Settings'

const store = useStore()
const dispatch = store.dispatch

const user = computed(() => store.state.auth.user)

onMounted(() => fetchUser())

const fetchUser = () => dispatch('FETCH_CURRENT_USER')
</script>
