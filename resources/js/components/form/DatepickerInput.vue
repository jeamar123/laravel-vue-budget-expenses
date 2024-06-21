<template>
  <div>
    <div :class="wrapperClass">
      <label
        v-if="label"
        class="text-xs block font-semibold mb-1"
        :class="[
          {
            'text-gray-500 cursor-not-allowed': readOnly,
          },
          labelClass,
        ]"
        :for="id"
        >{{ label }}<span v-if="required">*</span></label
      >
    </div>
    <div class="relative">
      <VueDatePicker
        v-model="initialValue"
        input-class-name="rounded py-2 px-2 border border-form-border outline-none text-sm read-only:border-gray-200 read-only:text-gray-500 read-only:cursor-not-allowed transition-all bg-white text-slate-800 font-sans focus:border-gray-900"
        :auto-apply="true"
        :hide-input-icon="true"
        :clearable="false"
        :enable-time-picker="false"
        format="PP"
        @update:model-value="formatTextDate"
      />
    </div>
    <template v-if="errors.length">
      <div class="mt-1">
        <p
          v-for="error in errors"
          :key="error"
          class="text-red-500 block text-xs"
        >
          {{ error }}
        </p>
      </div>
    </template>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker'

const props = defineProps({
  id: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  required: {
    type: Boolean,
    default: () => false,
  },
  errors: {
    type: Array,
    default: () => [],
  },
  readOnly: {
    type: Boolean,
    default: () => false,
  },
  wrapperClass: {
    type: [String, Object, Array],
    default: '',
  },
  labelClass: {
    type: [String, Object, Array],
    default: '',
  },
  modelValue: {
    type: [String, Date, null],
    default: null,
  },
})
const emit = defineEmits(['update:model-value'])

const initialValue = ref(props.modelValue)

const formatTextDate = (value) => {
  if (value) {
    initialValue.value = value
  }
  emit('update:model-value', value)
}
</script>
