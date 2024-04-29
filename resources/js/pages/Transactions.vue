<template>
  <section class="py-5 px-2 lg:px-8 h-full">
    <div class="mb-3 flex items-center justify-between gap-x-2">
      <div class="flex gap-x-4 items-center">
        <TransactionsActions
          v-if="selectedTransactionList.length"
          @action="actionChanged"
        />
        <TransactionsFilter
          class="flex gap-x-4 items-center"
          @dates-changed="dateChanged"
        />
      </div>

      <div class="flex items-center gap-x-2">
        <Button @click="isCreateModalShown = true">Create</Button>
      </div>
    </div>
    <div class="flex flex-col-reverse lg:flex-row gap-y-2 gap-x-4">
      <div class="lg:w-9/12 h-max">
        <TransactionList
          :transactions="transactions"
          @checkbox-checked="(items) => (selectedTransactionList = items)"
          @show="
            (item) => {
              selectedTransaction = item
            }
          "
          @edit="
            (item) => {
              selectedTransaction = item
              isEditModalShown = true
            }
          "
          @delete="
            (item) => {
              selectedTransaction = item
              isDeleteAlertShown = true
            }
          "
        />
        
        <!-- <Table
          :headers="headers"
          :data="transactions"
          :show-pagination="true"
          :show-items-info="false"
          :pagination="pagination"
          @rows="rows"
          @paginate="paginate"
          @checkbox-checked="(items) => (selectedTransactionList = items)"
          @show="
            (item) => {
              selectedTransaction = item
            }
          "
          @edit="
            (item) => {
              selectedTransaction = item
              isEditModalShown = true
            }
          "
          @delete="
            (item) => {
              selectedTransaction = item
              isDeleteAlertShown = true
            }
          "
        /> -->
      </div>

      <div class="flex-1 flex flex-col gap-y-2 shrink-0">
        <Card class="!p-5">
          <Heading as="h5" class="text-slate-800 mb-1">Income</Heading>
          <p class="text-2xl font-medium" :class="summary.income < 0 ? 'text-red-800' : 'text-green-800'">
            {{ formatNumber(summary.income) }}
          </p>
        </Card>

        <Card class="!p-5">
          <Heading as="h5" class="text-slate-800 mb-1">Expenses</Heading>
          <p class="text-2xl font-medium" :class="summary.expenses < 0 ? 'text-red-800' : 'text-green-800'">
            {{ formatNumber(summary.expenses) }}
          </p>
        </Card>

        <Card class="!p-5">
          <Heading as="h5" class="text-slate-800 mb-1">Balance</Heading>
          <p class="text-2xl font-medium" :class="summary.balance < 0 ? 'text-red-800' : 'text-green-800'">
            {{ formatNumber(summary.balance) }}
          </p>
        </Card>
      </div>
    </div>
  </section>

  <CreateTransactionModal
    :show="isCreateModalShown"
    @close="isCreateModalShown = false"
    @success="
      () => {
        getTransactions()
        isCreateModalShown = false
      }
    "
  />

  <UpdateTransactionModal
    v-if="isEditModalShown"
    :show="isEditModalShown"
    :model="selectedTransaction"
    @close="isEditModalShown = false"
    @success="
      () => {
        getTransactions()
        isEditModalShown = false
      }
    "
  />

  <DeleteTransaction
    v-if="isDeleteAlertShown"
    :show="isDeleteAlertShown"
    :model="selectedTransaction"
    @close="isDeleteAlertShown = false"
    @confirm="
      () => {
        getTransactions()
        isDeleteAlertShown = false
      }
    "
  />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Heading, Card, Button } from '@/components/common'
import { Checkbox } from '@/components/form'
import { Table } from '@/components/table'
import {
  CreateTransactionModal,
  TransactionsFilter,
  UpdateTransactionModal,
  DeleteTransaction,
  TransactionsActions,
  TransactionList
} from '@/components/Transactions'
import { useStore } from 'vuex'
import { format } from '@/composables/date'
import { formatNumber } from '@/composables/number'

const store = useStore()
const dispatch = store.dispatch
const commit = store.commit

const headers = computed(() => store.state.transactions.headers)
const transactions = computed(() => store.state.transactions.items)
const pagination = computed(() => store.state.transactions.pagination)
const filters = computed(() => store.state.transactions.filters)
const summary = computed(() => store.state.transactions.summary)

const selectedTransaction = ref(null)
const selectedTransactionList = ref([])
const isCreateModalShown = ref(false)
const isEditModalShown = ref(false)
const isDeleteAlertShown = ref(false)

onMounted(() => {
  getTransactions()
  dispatch('REQUEST_GET_CATEGORY')
  dispatch('REQUEST_GET_ACCOUNTS')
})

const getTransactions = () => {
  dispatch('REQUEST_GET_TRANSACTIONS_SUMMARY')
  dispatch('REQUEST_GET_TRANSACTIONS')
}

const rows = (rows) => {
  commit('UPDATE_TRANSACTIONS_STATE', {
    ...pagination,
    pagination: {
      per_page: rows,
      current_page: 1,
    },
  })
  getTransactions()
}
const paginate = (page) => {
  commit('UPDATE_TRANSACTIONS_STATE', {
    ...pagination,
    pagination: {
      current_page: page,
    },
  })
  getTransactions()
}

const dateChanged = (dates) => {
  commit('UPDATE_TRANSACTIONS_STATE', {
    ...filters,
    filters: {
      start: dates.start,
      end: dates.end,
    },
  })
  getTransactions()
}

const actionChanged = (action) => {
  if (action === 'delete') {
    selectedTransaction.value = selectedTransactionList.value
    isDeleteAlertShown.value = true
  }
}
</script>
