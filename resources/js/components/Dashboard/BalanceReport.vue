<template>
  <Card class="!px-0 !pb-0">
    <div v-if="title !== undefined" class="relative bottom-[-2px]">
      <Sparkline
        :title="{
          text: formatNumber(title),
          offsetX: 30,
          style: {
            fontSize: '32px',
          },
        }"
        :subtitle="{
          text: 'Balance',
          offsetX: 30,
          offsetY: 40,
          style: {
            fontSize: '14px',
          },
        }"
        color="#00D8B6"
        :labels="labels"
        :data="balanceReport"
      />
    </div>

    <div v-else class="flex min-h-[170px] items-center">
      <Loading placement="internal" :show-text="false" />
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
  () => store.state.dashboard.balanceReport?.current?.balance,
)
const balanceReport = computed(() => {
  return (
    store.state.dashboard.balanceReport?.monthly?.map(
      ({ balance }) => balance,
    ) || []
  )
})
const labels = computed(() => {
  return (
    store.state.dashboard.balanceReport?.monthly?.map(({ label }) => label) ||
    []
  )
})
</script>
