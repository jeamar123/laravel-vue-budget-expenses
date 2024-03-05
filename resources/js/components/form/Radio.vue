<template>
  <div>
    <div :class="wrapperClass">
      <label :for="id" class="relative flex items-start gap-x-2 leading-[1.3]">
        <input
          type="radio"
          :id="id"
          :name="name"
          class="shrink-0 peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-form-border transition-all checked:border-primary focus:outline-none focus:ring-offset-0 focus:ring-2 focus:ring-blue-100"
          :class="[!readOnly ? '' : '', errors.length ? '' : '', inputClass]"
          :readonly="readOnly"
          @change="({ target }) => emit('update:model-value', target.checked)"
        />

        <span
          class="absolute text-primary transition-opacity opacity-0 pointer-events-none top-[4px] left-[4px] peer-checked:opacity-100"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-3 w-3"
            viewBox="0 0 16 16"
            fill="currentColor"
          >
            <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
          </svg>
        </span>

        {{ label }}
      </label>
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
  id: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    default: ''
  },
  name: {
    type: String,
    default: ''
  },
  modelValue: {
    type: [String, Number],
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
