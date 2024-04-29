<template>
  <section class="py-5 px-4 lg:px-8">
    <div class="mb-3 flex items-center justify-between gap-x-2">
      <div class="flex items-center gap-x-2">
        <Button @click="isCreateModalShown = true">Create</Button>
      </div>
    </div>
    <div class="flex flex-col-reverse lg:flex-row gap-y-2 gap-x-4">
      <Card class="lg:w-5/12 h-max">
        <Table
          id="account-table"
          class=""
          :headers="headers"
          :data="categories"
          :show-pagination="true"
          :show-checkbox="false"
          :show-items-info="false"
          :pagination="pagination"
          :actions="{
            enable: false,
            edit: true,
            delete: true,
          }"
          @rows="rows"
          @paginate="paginate"
          @show="
            (item) => {
              selectedAccount = item
            }
          "
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
    </div>
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
import { Card, Button } from '@/components/common'
import { Table } from '@/components/table'
import {
  CreateAccountModal,
  UpdateAccountModal,
  DeleteAccount,
} from '@/components/Account'
import { useStore } from 'vuex'

const store = useStore()
const dispatch = store.dispatch
const commit = store.commit

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

const rows = (rows) => {
  commit('UPDATE_ACCOUNT_STATE', {
    ...pagination,
    pagination: {
      per_page: rows,
      current_page: 1,
    },
  })
  getAccounts()
}
const paginate = (page) => {
  commit('UPDATE_ACCOUNT_STATE', {
    ...pagination,
    pagination: {
      current_page: page,
    },
  })
  getAccounts()
}
</script>

<style>
#account-table table tbody tr td:first-child {
  text-transform: capitalize;
}
</style>
