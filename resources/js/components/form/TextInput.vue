<template>
  <div>
    <div :class="wrapperClass">
      <label
        v-if="label"
        class="text-sm block mb-1"
        :class="[{ 'text-gray-500 cursor-not-allowed': readOnly }, labelClass]"
        :for="id"
        >{{ label }}<span v-if="required">*</span></label
      >
      <component
        :is="as"
        :id="id"
        :value="modelValue"
        :type="type"
        :placeholder="placeholder"
        class="w-full rounded border-2 border-form-border p-2 outline-none text-sm read-only:border-gray-200 read-only:text-gray-500 read-only:cursor-not-allowed block autofill:!bg-white transition-all bg-slate-100 text-slate-800"
        :class="[
          !readOnly ? 'focus:border-gray-900' : '',
          errors.length ? 'border-red-500' : '',
          inputClass
        ]"
        :readonly="readOnly"
        @input="(e) => emit('update:model-value', e.target.value)"
      />
    </div>
    <template v-if="errors.length">
      <div class="mt-1">
        <p v-for="error in errors" :key="error" class="text-red-500 block text-xs">
          {{ error }}
        </p>
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
defineProps({
  as: {
    type: String,
    default: 'input' // input, textarea
  },
  id: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    default: ''
  },
  type: {
    type: String,
    default: 'text' // text, number, date, password
  },
  modelValue: {
    type: [String, Number],
    default: ''
  },
  placeholder: {
    type: String,
    default: ''
  },
  readOnly: {
    type: Boolean,
    default: () => false
  },
  required: {
    type: Boolean,
    default: () => false
  },
  errors: {
    type: Array,
    default: () => []
  },
  wrapperClass: {
    type: [String, Object, Array],
    default: ''
  },
  labelClass: {
    type: [String, Object, Array],
    default: ''
  },
  inputClass: {
    type: [String, Object, Array],
    default: ''
  }
})

const emit = defineEmits(['update:model-value'])
</script>
