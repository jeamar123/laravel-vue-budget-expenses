<template>
  <Card class="!px-0 !pb-0">
    <div v-if="title !== undefined" class="relative bottom-[-2px]">
      <Sparkline
        :title="{
          text: formatNumber(title),
          offsetX: 30,
          style: {
            fontSize: '24px',
          },
        }"
        :subtitle="{
          text: 'Income',
          offsetX: 30,
          style: {
            fontSize: '14px',
          },
        }"
        :labels="labels"
        :data="incomeReport"
      />
    </div>

    <div v-else class="flex min-h-[170px] items-center">
      <Loading placement="internal" :show-text="false"/>
    </div>
  </Card>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Card, Loading } from '@/components/common'
import { Sparkline } from '@/components/charts'
import { useStore } from 'vuex'
import { formatNumber } from '@/composables/number'

const store = useStore()

const title = computed(
  () => store.state.dashboard.balanceReport?.current?.income,
)
const incomeReport = computed(() => {
  return (
    store.state.dashboard.balanceReport?.monthly?.map(({ income }) => income) ||
    []
  )
})
const labels = computed(() => {
  return (
    store.state.dashboard.balanceReport?.monthly?.map(({ label }) => label) ||
    []
  )
})
</script>
