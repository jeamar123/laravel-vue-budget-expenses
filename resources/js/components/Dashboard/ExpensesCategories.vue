<template>
  <Card>
    <Heading as="h3" class="text-slate-800 mb-2">Categories</Heading>

    <div class="flex items-center justify-center">
      <DonutChart
        v-if="total > 0"
        :labels="transaction_categories.labels"
        :data="transaction_categories.data"
      />

      <div v-else class="flex items-center justify-center min-h-[200px]">
        <p class="text-center text-center italic">No Transactions yet</p>
      </div>
    </div>
  </Card>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Heading, Card } from '@/components/common'
import { useStore } from 'vuex'
import { formatNumber } from '@/composables/number'
import { DonutChart } from '@/components/charts'

const store = useStore()
const dispatch = store.dispatch

const total = computed(() => store.state.transactions.categories.reduce((total, item) => total + Number(item.total), 0))

const transaction_categories = computed(() => {
  return {
    labels: store.state.transactions.categories
      .filter(({ total }) => total !== 0)
      .map(({ name }) => name),
    data: store.state.transactions.categories
      .filter(({ total }) => total !== 0)
      .map(({ total }) => total),
  }
})
</script>
