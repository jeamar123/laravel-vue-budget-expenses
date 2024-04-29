<template>
  <component :is="Heroicons[name]" />
</template>

<script setup lang="ts">
import Heroicons from './Heroicons'

defineProps({
  name: {
    type: String,
    required: true,
  },
})
</script>
