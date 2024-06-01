<template>
  <div class="container md:py-2 lg:py-5 md:px-2 lg:px-8">
    <section class="md:max-w-[800px]">
      <Card class="!pb-0 !pt-2 !px-2 md:!px-4 md:!py-4">
        <div class="mb-3 flex items-center justify-between gap-x-2">
          <Heading as="h3">Budgets</Heading>
        </div>

        <div class="">
          <div
            class="rounded-lg px-2 py-3 md:px-4 md:py-3 bg-slate-200 grid grid-cols-3 md:grid-cols-4 gap-x-5"
          >
            <div class="font-medium text-xs col-span-2 md:col-span-1">
              Category
            </div>
            <div class="hidden md:block font-medium text-xs">Budget</div>
            <div class="hidden md:block font-medium text-xs">Spent</div>
            <div class="hidden md:block font-medium text-xs">Remaining</div>
            <div
              class="block md:hidden text-center font-medium text-xs col-span-1"
            >
              Actions
            </div>
          </div>
          <template v-for="category in categories" :key="category.id">
            <div
              class="grid grid-cols-3 md:flex gap-x-5 px-2 py-3 md:px-4 md:py-3 border-b border-slate-200"
            >
              <div class="capitalize block md:hidden">{{ category.name }}</div>
              <div class="flex-1 grid md:grid-cols-4 gap-x-5">
                <div class="hidden md:block capitalize">
                  {{ category.name }}
                </div>
                <div class="">
                  <div class="flex gap-x-2">
                    <span>{{ formatNumber(category.budget) }}</span>
                    <Button
                      variant="blank"
                      class="!px-1 !py-0 hidden md:inline-block"
                      @click="
                        () => {
                          selectedBudget = category
                          isEditModalShown = true
                        }
                      "
                    >
                      <Icon name="PencilSquareIconOutline" class="w-4" />
                    </Button>
                  </div>
                </div>
                <div class="">{{ formatNumber(category.spent) }}</div>
                <div
                  class="font-medium"
                  :class="
                    category.remaining < 0 ? 'text-red-600' : 'text-green-900'
                  "
                >
                  {{ formatNumber(category.remaining) }}
                </div>
              </div>
              <div class="flex md:hidden items-start justify-center">
                <Button variant="blank" class="!px-1 !py-0">
                  <Icon name="PencilSquareIconOutline" class="w-4" />
                </Button>
              </div>
            </div>
          </template>
        </div>
      </Card>

      <UpdateBudgetModal
        v-if="isEditModalShown"
        :show="isEditModalShown"
        :model="selectedBudget"
        @close="isEditModalShown = false"
        @success="
          () => {
            getBudgets()
            isEditModalShown = false
          }
        "
      />
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Card, Button, Heading, Icon } from '@/components/common'
import { UpdateBudgetModal } from '@/components/Budget'
import { useStore } from 'vuex'
import { formatNumber } from '@/composables/number'

const store = useStore()
const dispatch = store.dispatch

const categories = computed(() => store.state.budgets.items)

const selectedBudget = ref({})
const isEditModalShown = ref(false)

onMounted(() => getBudgets())

const getBudgets = () => dispatch('REQUEST_GET_BUDGET')
</script>
