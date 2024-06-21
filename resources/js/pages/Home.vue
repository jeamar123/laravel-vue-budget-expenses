<template>
  <section class="container py-4 md:pt-2 lg:pt-5 px-4 md:px-2 lg:px-8 h-full">
    <div class="grid lg:grid-cols-12 gap-x-5 gap-y-2 lg:gap-y-6">
      <BalanceReport class="lg:col-span-4" />
      <IncomeReport class="lg:col-span-4" />
      <ExpensesReport class="lg:col-span-4" />

      <RecentTransactions class="lg:col-span-5" />
      <ExpensesCategories class="lg:col-span-4" />
    </div>
  </section>
</template>

<script setup>
import { useStore } from 'vuex'
import { Card } from '@/components/common'
import { TransactionCategories } from '@/components/Transactions'
import {
  RecentTransactions,
  ExpensesCategories,
  BalanceReport,
  IncomeReport,
  ExpensesReport,
} from '@/components/Dashboard'
import { onMounted } from 'vue'

const store = useStore()
const commit = store.commit
const dispatch = store.dispatch

onMounted(async () => {
  dispatch('REQUEST_GET_TRANSACTIONS_SUMMARY')
  dispatch('FETCH_BALANCE_REPORT')
})
</script>
