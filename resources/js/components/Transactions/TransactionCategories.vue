<template>
  <Card>
    <Heading as="h3" class="text-slate-800 mb-2">Categories</Heading>
    <div class="flex flex-col space-y-1">
      <template v-for="({ name, total }, index) in transaction_categories" :key="name">
        <div
          class="border text-sm rounded px-2 py-[3px] flex items-center justify-between"
          :style="{
            'background-color': colors[index]?.bgColor,
            'color': colors[index]?.fontColor,
            'border-color': colors[index]?.bgColor
          }"
        >
          <label>{{ name }}</label>

          <p>{{ formatNumber(total) }}</p>
        </div>
      </template>
    </div>
  </Card>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Heading, Card } from '@/components/common'
import { useStore } from 'vuex'
import { formatNumber } from '@/composables/number'

const store = useStore()

const transaction_categories = computed(() => store.state.transactions.categories.filter(({ total }) => total !== 0))

const colors = ref([
  {
    bgColor: '#e5f6ff',
    fontColor: 'inherit'
  },
  {
    bgColor: '#ceeaf9',
    fontColor: 'inherit'
  },
  {
    bgColor: '#b8ddf4',
    fontColor: 'inherit'
  },
  {
    bgColor: '#a1d1ee',
    fontColor: 'inherit'
  },
  {
    bgColor: '#8ac4e9',
    fontColor: 'inherit'
  },
  {
    bgColor: '#73b7e4',
    fontColor: 'inherit'
  },
  {
    bgColor: '#5aaae0',
    fontColor: 'inherit'
  },
  {
    bgColor: '#3c9edb',
    fontColor: 'inherit'
  },
  {
    bgColor: '#0091d6',
    fontColor: 'inherit'
  },
  {
    bgColor: '#0585c7',
    fontColor: '#fff'
  },
  {
    bgColor: '#0879b9',
    fontColor: '#fff'
  },
  {
    bgColor: '#096dab',
    fontColor: '#fff'
  },
  {
    bgColor: '#09619c',
    fontColor: '#fff'
  },
  {
    bgColor: '#08568e',
    fontColor: '#fff'
  },
  {
    bgColor: '#054b80',
    fontColor: '#fff'
  },
  {
    bgColor: '#034073',
    fontColor: '#fff'
  },
  {
    bgColor: '#003665',
    fontColor: '#fff'
  },
  
  {
    bgColor: '#1b4576',
    fontColor: '#fff'
  },
  {
    bgColor: '#2f5488',
    fontColor: '#fff'
  },
  {
    bgColor: '#41649a',
    fontColor: '#fff'
  },
])
</script>
