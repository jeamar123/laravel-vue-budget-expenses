<template>
  <div
    class="container md:py-2 lg:py-5 md:px-2 lg:px-8 grid md:grid-cols-2 gap-y-1 md:gap-y-5 gap-x-10"
  >
    <Expenses />
    <Income />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import Expenses from '@/components/Category/ExpensesCategory.vue'
import Income from '@/components/Category/IncomeCategory.vue'
import { useStore } from 'vuex'

const store = useStore()
const dispatch = store.dispatch

onMounted(() => {
  getCategories()
})

const getCategories = () => {
  dispatch('REQUEST_GET_CATEGORY')
}
</script>
