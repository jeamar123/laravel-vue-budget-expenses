<template>
  <div>
    <div :class="wrapperClass">
      <label
        v-if="label"
        class="text-xs block font-semibold mb-1"
        :class="[
          {
            '': readOnly,
          },
          labelClass,
        ]"
        :for="id"
        >{{ label }}<span v-if="required">*</span></label
      >
      <Listbox
        v-model="selectedValue"
        as="div"
        class="min-w-16 cursor-pointer"
        :by="isItemObject(selectedValue) ? keyValue : ''"
        :disabled="readOnly"
        @update:model-value="onChange"
      >
        <div class="relative">
          <ListboxButton
            class="relative w-full bg-white py-2 px-2 rounded text-left outline-none text-sm border border-form-border text-slate-800 min-h-[35px]"
            :class="[
              errors.length && 'border-red-500',
              readOnly && 'opacity-80 !bg-slate-50 cursor-not-allowed',
              !readOnly && 'focus:border-gray-900',
              buttonClass,
            ]"
          >
            <span class="block truncate capitalize">
              {{ getLabel }}
            </span>
            <span
              class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
            >
              <ChevronUpDownIcon
                class="h-5 w-5 text-gray-400"
                aria-hidden="true"
              />
            </span>
          </ListboxButton>

          <transition
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
          >
            <ListboxOptions
              class="absolute max-h-60 border w-full overflow-auto rounded-md bg-white z-[5] outline-none text-sm"
              :class="[
                dropdownDirection === 'bottom'
                  ? 'bottom-10 md:bottom-auto md:top-10'
                  : 'bottom-10',
              ]"
            >
              <ListboxOption
                v-for="item in items"
                :key="item.id"
                v-slot="{ active }"
                :value="item"
                as="template"
              >
                <li
                  :class="[
                    (isItemObject(item) && item[keyValue] === modelValue) ||
                    item === modelValue
                      ? 'bg-primary text-white'
                      : 'text-gray-900 hover:bg-primary hover:text-white',
                    active
                      ? 'bg-primary text-white'
                      : '!bg-white !text-gray-900',
                    'relative select-none p-2 capitalize border-b outline-none',
                  ]"
                >
                  {{ isItemObject(item) ? item[keyLabel] : item }}
                </li>
              </ListboxOption>
            </ListboxOptions>
          </transition>
        </div>
      </Listbox>
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

<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'
import { ChevronUpDownIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  id: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  keyLabel: {
    // Think of a better key name
    type: String,
    default: 'name',
  },
  keyValue: {
    // Think of a better key name
    type: String,
    default: 'name',
  },
  placeholder: {
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
  buttonClass: {
    type: [String, Object, Array],
    default: '',
  },
  labelClass: {
    type: [String, Object, Array],
    default: '',
  },
  inputClass: {
    type: [String, Object, Array],
    default: '',
  },
  items: {
    type: Object,
    required: true,
  },
  modelValue: {
    type: [String, Boolean, Number, Object, null],
    default: null,
  },
  value: {
    type: [String, Boolean, Number, Object, null],
    default: null,
  },
  dropdownDirection: {
    type: String,
    default: 'bottom', // top, bottom
  },
})

const emit = defineEmits(['update:model-value', 'change'])

const getLabel = computed(() => {
  let value = selectedValue.value

  if (value && isItemObject(value)) {
    return value[props.keyLabel]
  }
  if (!value && props.placeholder) {
    return props.placeholder
  }

  return value || null
})

const selectedValue = ref(props.modelValue || props.value)

const onChange = (value) => {
  emit(
    'update:model-value',
    isItemObject(value) ? value[props.keyValue] : value,
  )
}

const isItemObject = (value) => typeof value === 'object'

// watch(
//   () => props.modelValue,
//   async (newValue) => {
//     selectedValue.value = newValue
//   },
// )
</script>
