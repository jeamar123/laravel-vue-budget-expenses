<template>
  <form novalidate @submit.prevent="submit">
    <div class="space-y-4 px-6 pt-6 pb-8">
      <div class="grid lg:grid-cols-2 gap-x-3 gap-y-4">
        <SelectInput
          v-model="form.type"
          label="Type"
          :items="['income', 'expenses']"
          :errors="form.errors?.type"
          @update:model-value="form.category = null"
        />
      </div>

      <div class="grid lg:grid-cols-2 gap-x-3 gap-y-4">
        <DatepickerInput
          v-model="form.date"
          label="Date"
          :errors="form.errors?.date"
        />

        <TextInput
          v-model="form.total"
          label="Amount"
          type="number"
          :errors="form.errors?.total"
        />

        <div>
          <template
            v-if="categories.filter(({ type }) => type === form.type).length"
          >
            <SelectInput
              v-model="form.category"
              button-class="!min-h-[38px]"
              label="Category"
              :items="categories.filter(({ type }) => type === form.type)"
              :errors="form.errors?.category"
            />
            <button
              type="button"
              class="outline-none text-[10px] text-center italic underline"
              @click="isCreateCategoryShown = true"
            >
              Add new category
            </button>
          </template>
          <button
            v-else
            type="button"
            class="mt-4 text-xs w-full block bg-gray-200 rounded py-3 px-2 italic"
            @click="isCreateCategoryShown = true"
          >
            No {{ form.type }} Categories yet. <br /><span class="underline"
              >Add new category</span
            >
          </button>
        </div>

        <div>
          <template v-if="sources.length">
            <SelectInput
              v-model="form.source"
              button-class="!min-h-[38px]"
              label="Source"
              :items="sources"
              :errors="form.errors?.source"
            />
            <button
              type="button"
              class="outline-none text-[10px] text-center italic underline"
              @click="isCreateAccountShown = true"
            >
              Add new account
            </button>
          </template>

          <button
            v-else
            type="button"
            class="mt-4 text-xs w-full block bg-gray-200 rounded py-3 px-2 italic"
            @click="isCreateAccountShown = true"
          >
            No Accounts yet.<br /><span class="underline">Add new account</span>
          </button>
        </div>

        <TextInput
          v-model="form.description"
          label="Note"
          :errors="form.errors?.description"
        />
      </div>
    </div>

    <div class="flex items-center justify-end gap-x-4 p-4">
      <Button variant="blank" @click="emit('close')"> Cancel </Button>
      <Button
        :disabled="
          !categories.filter(({ type }) => type === form.type)?.length ||
          !sources.length
        "
        type="submit"
      >
        Submit
      </Button>
    </div>
  </form>

  <CreateCategoryModal
    :show="isCreateCategoryShown"
    :type="form.type"
    @close="isCreateCategoryShown = false"
    @success="
      () => {
        dispatch('REQUEST_GET_CATEGORY')
        isCreateCategoryShown = false
      }
    "
  />

  <CreateAccountModal
    :show="isCreateAccountShown"
    @close="isCreateAccountShown = false"
    @success="
      () => {
        dispatch('REQUEST_GET_ACCOUNTS')
        isCreateAccountShown = false
      }
    "
  />
</template>

<script setup>
import { ref, computed } from 'vue'
import { Button } from '@/components/common'
import { TextInput, SelectInput, DatepickerInput } from '@/components/form'
import { useStore } from 'vuex'
import { format } from '@/composables/date'
import { CreateCategoryModal } from '@/components/Category'
import { CreateAccountModal } from '@/components/Account'

const props = defineProps({
  model: {
    type: Object,
    default: () => {},
  },
  apiRoute: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(['close', 'success'])
const store = useStore()
const dispatch = store.dispatch

const sources = computed(() => store.state.accounts.items)
const categories = computed(() => store.state.category.items)

const isCreateCategoryShown = ref(false)
const isCreateAccountShown = ref(false)

const form = ref({
  type: props.model?.category?.type ?? 'expenses',
  source: null,
  total: null,
  description: null,
  date: new Date(),
  errors: {},
  success: false,

  ...props.model,
  category: props.model?.category?.name ?? null,
})

const submit = async () => {
  form.value.errors = {}
  if (form.value.date)
    form.value.date = format(new Date(form.value.date), 'yyyy-MM-dd HH:mm:ss')
  const { data, status } = await dispatch(props.apiRoute, form.value)
  if ([200, 201].includes(status)) {
    form.value.success = true
    reset()
    dispatch('SHOW_NOTIF_ALERT', { message: 'Changes saved.' })
    emit('success')
  } else {
    form.value.errors = data.errors
    form.value.errors.name = ''
  }
}

const reset = () => {
  form.value = {
    source: null,
    total: null,
    description: null,
    category: null,
    date: new Date(),
    errors: {},
    success: false,
  }
}
</script>
