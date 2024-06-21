<template>
  <Card v-if="!isLoading" class="lg:col-span-2">
    <Heading as="h4" class="mb-3">Recent Transactions</Heading>

    <table class="w-full">
      <thead>
        <tr>
          <th
            class="bg-slate-900 text-white text-xs text-left font-semibold border-b py-[6px] px-2 rounded-l"
          >
            Note
          </th>
          <th
            class="bg-slate-900 text-white text-xs text-left font-semibold border-b py-[6px] px-2"
          >
            Total
          </th>
          <th
            class="bg-slate-900 text-white text-xs text-left font-semibold border-b py-[6px] px-2 rounded-r"
          >
            Date
          </th>
        </tr>
      </thead>
      <tbody>
        <template v-for="transaction in transactions" :key="transaction.id">
          <tr>
            <td class="text-xs py-[6px] px-2">
              <span v-if="!transaction.description" class="italic">N/A</span>
              <span v-else>{{ transaction.description }}</span>
            </td>
            <td class="text-xs py-[6px] px-2">
              {{ formatNumber(transaction.total) }}
            </td>
            <td class="text-xs py-[6px] px-2">
              {{ format(transaction.date, 'MMM dd yyyy') }}
            </td>
          </tr>
        </template>

        <tr v-if="!transactions.length">
          <td colspan="3" class="text-xs py-14 px-2 text-center italic">
            No Transactions yet
          </td>
        </tr>
      </tbody>
    </table>
  </Card>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Heading, Card } from '@/components/common'
import { useStore } from 'vuex'
import { format } from '@/composables/date'
import { formatNumber } from '@/composables/number'

const store = useStore()
const commit = store.commit
const dispatch = store.dispatch

const transactions = computed(() => store.state.transactions.items.slice(0, 6))

const isLoading = ref(true)

onMounted(async () => {
  isLoading.value = true
  await getAllTransactions()
})

const getAllTransactions = async () => {
  await dispatch('REQUEST_GET_TRANSACTIONS', { all: true })
  isLoading.value = false
}
</script>
