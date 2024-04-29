<template>
  <div>
    <Dropdown
      v-model="selectedAction"
      placeholder="Actions"
      fixed-placeholder
      :items="['delete']"
      @update:model-value="emit('action', selectedAction)"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Dropdown } from '@/components/common'

const emit = defineEmits(['action'])

const selectedAction = ref(null)
</script>
