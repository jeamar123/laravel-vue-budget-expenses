<template>
  <section class="container py-4 md:pt-2 lg:pt-5 px-4 md:px-2 lg:px-8 h-full">
    <div
      class="px-2 md:px-0 mb-3 flex flex-row items-start md:items-center justify-between gap-y-2 gap-x-2"
    >
      <div
        class="flex flex-col md:flex-row gap-y-5 gap-x-2 md:gap-x-4 md:items-center"
      >
        <div class="flex items-center gap-x-2">
          <span class="text-xs">Filters: </span>
          <div class="flex gap-x-2">
            <div
              v-if="
                Object.keys(filters).includes('start') &&
                Object.keys(filters).includes('end')
              "
              class="bg-gray-200 rounded py-[2px] px-2 text-[11px]"
            >
              {{ format(filters['start'], 'MMM dd, yyyy') }} -
              {{ format(filters['end'], 'MMM dd, yyyy') }}
            </div>
          </div>
        </div>
      </div>

      <div class="flex md:items-center justify-end flex-1 gap-x-2">
        <Button
          variant="blank"
          class="!p-[6px] !border !border-solid !border-slate-800"
          @click="isFilterModalShown = true"
        >
          <Icon
            name="AdjustmentsHorizontalIconOutline"
            class="w-6 h-6 text-slate-900"
          />
        </Button>
      </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-x-5 gap-y-2 lg:gap-y-6">
      <BalanceReport class="lg:col-span-4" />
      <IncomeReport class="lg:col-span-4" />
      <ExpensesReport class="lg:col-span-4" />

      <RecentTransactions class="lg:col-span-5" />
      <ExpensesCategories class="lg:col-span-4" />
      <TransactionCategories class="lg:col-span-4" />
    </div>
  </section>

  <TransactionFilterModal
    v-if="isFilterModalShown"
    :show="isFilterModalShown"
    @close="isFilterModalShown = false"
    @dates-changed="
      (dates) => {
        dateChanged(dates)
        isFilterModalShown = false
      }
    "
  />
</template>

<script setup>
import { useStore } from 'vuex'
import { Card, Button, Icon } from '@/components/common'
import {
  TransactionCategories,
  TransactionFilterModal,
} from '@/components/Transactions'
import {
  RecentTransactions,
  ExpensesCategories,
  BalanceReport,
  IncomeReport,
  ExpensesReport,
} from '@/components/Dashboard'
import { ref, computed, onMounted } from 'vue'
import { format } from '@/composables/date'

const store = useStore()
const commit = store.commit
const dispatch = store.dispatch

const filters = computed(() => store.state.dashboard.filters)

const isFilterModalShown = ref()

onMounted(() => {
  getTransactions()
})

const getTransactions = () => {
  dispatch('FETCH_BALANCE_REPORT')
  dispatch('REQUEST_GET_TRANSACTIONS_SUMMARY')
  dispatch('REQUEST_GET_TRANSACTIONS_BY_CATEGORY')
}

const dateChanged = (dates) => {
  const params = {
    filters: {
      ...filters.value,
      start: dates.start,
      end: dates.end,
    },
  }
  commit('UPDATE_DASHBOARD_STATE', params)
  commit('UPDATE_TRANSACTIONS_STATE', params)
  getTransactions()
}
</script>
