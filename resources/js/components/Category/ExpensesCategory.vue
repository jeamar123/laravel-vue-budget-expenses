<template>
  <section>
    <Card class="!p-2 md:!p-4">
      <div class="mb-3 flex items-center justify-between gap-x-2">
        <Heading as="h3">Expenses</Heading>
        <Button class="!p-2" @click="isCreateModalShown = true">
          <Icon name="PlusIcon" class="w-5" />
        </Button>
      </div>
      <Table
        id="category-table"
        :headers="headers"
        :data="categories"
        :show-checkbox="false"
        :show-items-info="false"
        :pagination="pagination"
        @edit="
          (item) => {
            selectedCategory = item
            isEditModalShown = true
          }
        "
        @delete="
          (item) => {
            selectedCategory = item
            isDeleteAlertShown = true
          }
        "
      />
    </Card>

    <CreateCategoryModal
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
    />
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Card, Button, Heading, Icon } from '@/components/common'
import { Table } from '@/components/table'
import {
  CreateCategoryModal,
  UpdateCategoryModal,
  DeleteCategory,
} from '@/components/Category'
import { useStore } from 'vuex'

const store = useStore()
const dispatch = store.dispatch

const headers = computed(() => store.state.category.headers)
const categories = computed(() =>
  store.state.category.items.filter(({ type }) => type === 'expenses'),
)

const selectedCategory = ref({})
const isCreateModalShown = ref(false)
const isEditModalShown = ref(false)
const isDeleteAlertShown = ref(false)

const getCategories = () => dispatch('REQUEST_GET_CATEGORY')
</script>

<style>
#category-table table tbody tr td:first-child {
  text-transform: capitalize;
}
</style>
