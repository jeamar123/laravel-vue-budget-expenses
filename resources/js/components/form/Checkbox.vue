<template>
  <div>
    <div :class="wrapperClass">
      <label :for="id" class="relative flex items-start gap-x-2 leading-[1.3]">
        <input
          type="checkbox"
          :id="id"
          class="relative peer shrink-0 appearance-none w-5 h-5 border-2 border-form-border rounded-sm bg-white checked:bg-primary checked:border-primary focus:outline-none focus:ring-offset-0 focus:ring-2 focus:ring-blue-100 transition-all"
          :class="[!readOnly ? '' : '', errors.length ? '' : '', inputClass]"
          :readonly="readOnly"
          @change="({ target }) => emit('update:model-value', target.checked)"
        />
        <svg
          class="absolute top-[2px] left-[2px] w-4 h-4 hidden peer-checked:block pointer-events-none"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="none"
          stroke="#fff"
          stroke-width="4"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>

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
