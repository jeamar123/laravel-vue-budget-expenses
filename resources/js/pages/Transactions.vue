<template>
  <section class="container md:pt-2 lg:pt-5 md:px-2 lg:px-8 h-full">
    <div class="flex flex-col lg:flex-row-reverse gap-y-10 gap-x-4">
      <div class="flex-1 flex flex-col space-y-3 shrink-0 lg:pt-[50px]">
        <TransactionSummary />

        <TransactionCategories />
      </div>

      <div class="lg:w-9/12 h-max">
        <div
          class="px-2 md:px-0 mb-3 flex flex-row items-start md:items-center justify-between gap-y-2 gap-x-2"
        >
          <div
            class="flex flex-col md:flex-row gap-y-5 gap-x-2 md:gap-x-4 md:items-center"
          >
            <TransactionsActions
              v-if="selectedTransactionList.length"
              @action="actionChanged"
            />

            <div class="flex items-center gap-x-2">
              <span class="text-xs">Filters: </span>
              <div class="flex gap-x-2">
                <div
                  v-if="
                    Object.keys(filters).includes('start') &&
                    Object.keys(filters).includes('end')
                  "
                  class="bg-gray-200 rounded py-[2px] px-2 text-[11px]"
                >
                  {{ format(filters['start'], 'MMM dd, yyyy') }} -
                  {{ format(filters['end'], 'MMM dd, yyyy') }}
                </div>
                <!-- <template
                  v-for="key in Object.keys(filters).filter((key) => key !== 'start' && key !== 'end')"
                  :key="key"
                >
                  <div class="bg-gray-200 rounded py-[2px] px-2 text-[11px]">
                    {{ filters[key] }}
                  </div>
                </template> -->
              </div>
            </div>
          </div>

          <div class="flex md:items-center justify-end flex-1 gap-x-2">
            <Button
              variant="blank"
              class="!border !border-solid !border-slate-800"
              @click="isUploadModalShown = true"
            >
              <Icon
                name="ArrowUpTrayIconOutline"
                class="w-5 h-5 text-slate-900"
              />
            </Button>
            <Button
              variant="blank"
              class="!p-[6px] !border !border-solid !border-slate-800"
              @click="isFilterModalShown = true"
            >
              <Icon
                name="AdjustmentsHorizontalIconOutline"
                class="w-6 h-6 text-slate-900"
              />
            </Button>
            <Button class="!p-2" @click="isCreateModalShown = true">
              <Icon name="PlusIcon" class="w-5 h-5" />
            </Button>
          </div>
        </div>

        <TransactionList
          v-if="!isLoading"
          :transactions="transactions"
          @checkbox-checked="(items) => (selectedTransactionList = items)"
          @show="
            (item) => {
              selectedTransaction = item
            }
          "
          @edit="
            (item) => {
              selectedTransaction = item
              isEditModalShown = true
            }
          "
          @delete="
            (item) => {
              selectedTransaction = item
              isDeleteAlertShown = true
            }
          "
        />

        <Loading v-if="isLoading" placement="internal" :show-text="false"/>
      </div>
    </div>
  </section>

  <TransactionFilterModal
    :show="isFilterModalShown"
    @close="isFilterModalShown = false"
    @dates-changed="
      (dates) => {
        dateChanged(dates)
        isFilterModalShown = false
      }
    "
  />

  <CreateTransactionModal
    :show="isCreateModalShown"
    @close="isCreateModalShown = false"
    @success="
      () => {
        getTransactions()
        isCreateModalShown = false
      }
    "
  />

  <UpdateTransactionModal
    v-if="isEditModalShown"
    :show="isEditModalShown"
    :model="selectedTransaction"
    @close="isEditModalShown = false"
    @success="
      () => {
        getTransactions()
        isEditModalShown = false
      }
    "
  />

  <DeleteTransaction
    v-if="isDeleteAlertShown"
    :show="isDeleteAlertShown"
    :model="selectedTransaction"
    @close="isDeleteAlertShown = false"
    @confirm="deleteBulkTransactions"
  />

  <ImportTransactionsModal
    :show="isUploadModalShown"
    @close="isUploadModalShown = false"
    @success="
      () => {
        getTransactions()
        isUploadModalShown = false
      }
    "
  />

  <Alert
    :show="isDeleteBulkAlertShown"
    :message="`Are you sure you want to delete (${selectedTransactionList.length}) transaction${selectedTransactionList.length > 1 ? 's' : ''}?`"
    @close="isDeleteBulkAlertShown = false"
    @confirm="deleteBulkTransactions"
  />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Button, Icon, Alert, Loading } from '@/components/common'
import {
  CreateTransactionModal,
  TransactionFilterModal,
  UpdateTransactionModal,
  DeleteTransaction,
  TransactionsActions,
  TransactionList,
  ImportTransactionsModal,
  TransactionSummary,
  TransactionCategories,
} from '@/components/Transactions'
import { useStore } from 'vuex'
import { format } from '@/composables/date'

const store = useStore()
const dispatch = store.dispatch
const commit = store.commit

const transactions = computed(() => store.state.transactions.items)
const filters = computed(() => store.state.transactions.filters)

const selectedTransaction = ref(null)
const selectedTransactionList = ref([])
const isCreateModalShown = ref(false)
const isEditModalShown = ref(false)
const isDeleteAlertShown = ref(false)
const isFilterModalShown = ref(false)
const isUploadModalShown = ref(false)
const isUpdateBulkModalShown = ref(false)
const isDeleteBulkAlertShown = ref(false)
const isLoading = ref(true)

onMounted(async () => {
  isLoading.value = true
  await getTransactions()
  dispatch('REQUEST_GET_ACCOUNTS')
  dispatch('REQUEST_GET_CATEGORY')
})

const getTransactions = async () => {
  await dispatch('REQUEST_GET_TRANSACTIONS_SUMMARY')
  await dispatch('REQUEST_GET_TRANSACTIONS')
  isLoading.value = false
}

const dateChanged = (dates) => {
  commit('UPDATE_TRANSACTIONS_STATE', {
    ...filters,
    filters: {
      start: dates.start,
      end: dates.end,
    },
  })
  getTransactions()
}

const actionChanged = (action) => {
  if (action === 'update') {
    isUpdateBulkModalShown.value = true
  }
  if (action === 'delete') {
    isDeleteBulkAlertShown.value = true
  }
}

const deleteBulkTransactions = async () => {
  let res = await dispatch('REQUEST_BULK_DELETE_TRANSACTION', {
    transactions: selectedTransactionList.value,
  })
  if (res.status === 200) {
    getTransactions()
    isDeleteAlertShown.value = false
    isDeleteBulkAlertShown.value = false
  }
}
</script>
