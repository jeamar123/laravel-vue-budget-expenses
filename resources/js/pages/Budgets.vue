<template>
  <div class="py-5 px-4 lg:px-8">
    <section>
      <Card>
        <div class="mb-3 flex items-center justify-between gap-x-2">
          <Heading as="h3">Budgets</Heading> 
          <Button
            class="!p-2"
            @click="isCreateModalShown = true"
          >
            <Icon name="PlusIcon" class="w-5" />
          </Button>
        </div>
        <Table
          id="budgets-table"
          :headers="headers"
          :data="categories"
          :show-pagination="false"
          :show-checkbox="false"
          :show-items-info="false"
          :pagination="pagination"
          @rows="rows"
          @paginate="paginate"
          @show="
            (item) => {
              selectedBudget = item
            }
          "
          @edit="
            (item) => {
              selectedBudget = item
              isEditModalShown = true
            }
          "
          @delete="
            (item) => {
              selectedBudget = item
              isDeleteAlertShown = true
            }
          "
        />
      </Card>

      <!-- <CreateCategoryModal
        :show="isCreateModalShown"
        type="expenses"
        @close="isCreateModalShown = false"
        @success="
          () => {
            getCategories()
            isCreateModalShown = false
          }
        "
      />

      <UpdateCategoryModal
        v-if="isEditModalShown"
        :show="isEditModalShown"
        type="expenses"
        :model="selectedCategory"
        @close="isEditModalShown = false"
        @success="
          () => {
            getCategories()
            isEditModalShown = false
          }
        "
      />

      <DeleteCategory
        v-if="isDeleteAlertShown"
        :show="isDeleteAlertShown"
        :model="selectedCategory"
        @close="isDeleteAlertShown = false"
        @confirm="
          () => {
            getCategories()
            isDeleteAlertShown = false
          }
        "
      /> -->
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Card, Button, Heading, Icon } from '@/components/common'
import { Table } from '@/components/table'
// import {
//   CreateCategoryModal,
//   UpdateCategoryModal,
//   DeleteCategory,
// } from '@/components/Category'
import { useStore } from 'vuex'

const store = useStore()
const dispatch = store.dispatch
const commit = store.commit

const headers = computed(() => store.state.budgets.headers)
const categories = computed(() => store.state.budgets.items)
const pagination = computed(() => store.state.budgets.pagination)

const selectedBudget = ref({})
const isCreateModalShown = ref(false)
const isEditModalShown = ref(false)
const isDeleteAlertShown = ref(false)

onMounted(() => {
  getBudgets()
})

const getBudgets = () =>  dispatch('REQUEST_GET_BUDGET')

const rows = (rows) => {
  commit('UPDATE_BUDGET_STATE', {
    ...pagination,
    pagination: {
      per_page: rows,
      current_page: 1,
    },
  })
  getBudgets()
}
const paginate = (page) => {
  commit('UPDATE_BUDGET_STATE', {
    ...pagination,
    pagination: {
      current_page: page,
    },
  })
  getBudgets()
}
</script>

<style>
#budgets-table table tbody tr td:first-child {
  text-transform: capitalize;
}
</style>