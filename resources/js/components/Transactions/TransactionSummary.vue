<template>
  <div class="flex flex-col md:gap-y-2">
    <Card class="!py-2 md:!p-5">
      <Heading as="h5" class="text-slate-800 mb-1">Balance</Heading>
      <p
        class="text-2xl font-semibold"
        :class="summary.balance < 0 ? 'text-red-800' : 'text-green-800'"
      >
        {{ formatNumber(summary.balance) }}
      </p>
    </Card>

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
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { Heading, Card } from '@/components/common'
import { useStore } from 'vuex'
import { formatNumber } from '@/composables/number'

const store = useStore()

const summary = computed(() => store.state.transactions.summary)
</script>
