<template>
  <section class="md:py-2 lg:py-5 md:px-2 lg:px-8 grid md:grid-cols-2">
    <Card class="!p-2 md:!p-4">
      <div class="mb-3 flex items-center justify-between gap-x-2">
        <Heading as="h3">Accounts</Heading>
        <div class="flex items-start gap-x-2">
          <Button class="!p-2" @click="isCreateModalShown = true">
            <Icon name="PlusIcon" class="w-5" />
          </Button>
        </div>
      </div>

      <Table
        id="account-table"
        class=""
        :headers="headers"
        :data="categories"
        :show-checkbox="false"
        :show-items-info="false"
        :pagination="pagination"
        @edit="
          (item) => {
            selectedAccount = item
            isEditModalShown = true
          }
        "
        @delete="
          (item) => {
            selectedAccount = item
            isDeleteAlertShown = true
          }
        "
      />
    </Card>
  </section>

  <CreateAccountModal
    :show="isCreateModalShown"
    @close="isCreateModalShown = false"
    @success="
      () => {
        getAccounts()
        isCreateModalShown = false
      }
    "
  />

  <UpdateAccountModal
    v-if="isEditModalShown"
    :show="isEditModalShown"
    :model="selectedAccount"
    @close="isEditModalShown = false"
    @success="
      () => {
        getAccounts()
        isEditModalShown = false
      }
    "
  />

  <DeleteAccount
    v-if="isDeleteAlertShown"
    :show="isDeleteAlertShown"
    :model="selectedAccount"
    @close="isDeleteAlertShown = false"
    @confirm="
      () => {
        getAccounts()
        isDeleteAlertShown = false
      }
    "
  />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Card, Button, Icon, Heading } from '@/components/common'
import { Table } from '@/components/table'
import {
  CreateAccountModal,
  UpdateAccountModal,
  DeleteAccount,
} from '@/components/Account'
import { useStore } from 'vuex'

const store = useStore()
const dispatch = store.dispatch

const headers = computed(() => store.state.accounts.headers)
const categories = computed(() => {
  return store.state.accounts.items.map((item) => {
    item.showActions = !item.user_id ? false : true
    return item
  })
})
const pagination = computed(() => store.state.accounts.pagination)

const selectedAccount = ref({})
const isCreateModalShown = ref(false)
const isEditModalShown = ref(false)
const isDeleteAlertShown = ref(false)

onMounted(() => {
  getAccounts()
})

const getAccounts = () => {
  dispatch('REQUEST_GET_ACCOUNTS')
}
</script>

<style>
#account-table table tbody tr td:first-child {
  text-transform: capitalize;
}
</style>
