<template>
  <section class="md:py-2 lg:py-5 md:px-2 lg:px-8 h-full">
    <div class="flex flex-col lg:flex-row-reverse gap-y-2 gap-x-4">
      <div class="flex-1 flex flex-col md:gap-y-2 shrink-0 lg:pt-[50px]">
        <Card class="!py-2 md:!p-5">
          <Heading as="h5" class="text-slate-800 mb-1">Income</Heading>
          <p class="text-2xl font-medium">
            {{ formatNumber(summary.income) }}
          </p>
        </Card>

        <Card class="!py-2 md:!p-5">
          <Heading as="h5" class="text-slate-800 mb-1">Expenses</Heading>
          <p class="text-2xl font-medium">
            {{ formatNumber(summary.expenses) }}
          </p>
        </Card>

        <Card class="!py-2 md:!p-5">
          <Heading as="h5" class="text-slate-800 mb-1">Balance</Heading>
          <p
            class="text-2xl font-medium"
            :class="summary.balance < 0 ? 'text-red-800' : 'text-green-800'"
          >
            {{ formatNumber(summary.balance) }}
          </p>
        </Card>
      </div>

      <div class="lg:w-9/12 h-max">
        <div
          class="px-2 md:px-0 mb-3 flex flex-row items-center justify-between gap-y-2 gap-x-2"
        >
          <div class="flex flex-row gap-y-2 gap-x-2 md:gap-x-4 md:items-center">
            <TransactionsActions
              v-if="selectedTransactionList.length"
              @action="actionChanged"
            />
          </div>

          <div class="flex md:items-center justify-end flex-1 gap-x-2">
            <Button variant="blank" class="!p-[6px] !border !border-solid !border-slate-800" @click="isFilterModalShown = true">
              <Icon name="AdjustmentsHorizontalIconOutline" class="w-6 h-6 text-slate-900" />
            </Button>
            <Button class="!p-2" @click="isCreateModalShown = true">
              <Icon name="PlusIcon" class="w-5 h-5" />
            </Button>
          </div>
        </div>

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
      </div>
    </div>
  </section>

  <TransactionFilterModal
    :show="isFilterModalShown"
    @close="isFilterModalShown = false"
    @dates-changed="(dates) => {
      dateChanged(dates)
      isFilterModalShown = false
    }"
  />

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
import { Heading, Card, Button, Icon } from '@/components/common'
import {
  CreateTransactionModal,
  TransactionsFilter,
  TransactionFilterModal,
  UpdateTransactionModal,
  DeleteTransaction,
  TransactionsActions,
  TransactionList,
} from '@/components/Transactions'
import { useStore } from 'vuex'
import { formatNumber } from '@/composables/number'

const store = useStore()
const dispatch = store.dispatch
const commit = store.commit

const transactions = computed(() => store.state.transactions.items)
const filters = computed(() => store.state.transactions.filters)
const summary = computed(() => store.state.transactions.summary)

const selectedTransaction = ref(null)
const selectedTransactionList = ref([])
const isCreateModalShown = ref(false)
const isEditModalShown = ref(false)
const isDeleteAlertShown = ref(false)
const isFilterModalShown = ref(false)

onMounted(() => {
  getTransactions()
  dispatch('REQUEST_GET_CATEGORY')
  dispatch('REQUEST_GET_ACCOUNTS')
})

const getTransactions = () => {
  dispatch('REQUEST_GET_TRANSACTIONS_SUMMARY')
  dispatch('REQUEST_GET_TRANSACTIONS')
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
