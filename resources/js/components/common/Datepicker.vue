<template>
  <div class="relative" :class="wrapperClass">
    <VueDatePicker
      v-model="initialValue"
      input-class-name="border-0 rounded-none py-2 px-1 border-b border-form-border outline-none text-sm read-only:border-gray-200 read-only:text-gray-500 read-only:cursor-not-allowed transition-all bg-white text-slate-800 font-sans"
      menu-class-name="!border !border-solid !border-form-border"
      inline
      :teleport="true"
      :month-picker="monthPicker"
      :range="range"
      :auto-apply="true"
      :hide-input-icon="true"
      :clearable="false"
      :enable-time-picker="false"
      format="PP"
      :action-row="{
        showNow: false,
        showPreview: true,
        showSelect: false,
        showCancel: false,
      }"
      :config="{
        keepActionRow: monthPicker ? false : true,
      }"
      @range-start="emit('range-start', initialValue)"
      @range-end="emit('range-end', initialValue)"
      @update:model-value="formatTextDate"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker'

const props = defineProps({
  wrapperClass: {
    type: [String, Object, Array],
    default: '',
  },
  modelValue: {
    type: [String, Date, Object, Array, null],
    default: null,
  },
  monthPicker: {
    type: Boolean,
    default: () => false,
  },
  range: {
    type: Boolean,
    default: () => false,
  },
})
const emit = defineEmits(['update:model-value', 'range-start', 'range-end'])

const initialValue = ref(props.modelValue)

const formatTextDate = (value) => {
  if (value) {
    initialValue.value = value
  }
  emit('update:model-value', value)
}
</script>
