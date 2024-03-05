<template>
  <component :is="as" key="test" :class="[getClasses()]">
    <slot />
  </component>
</template>

<script setup lang="ts">
const props = defineProps({
  as: {
    type: String,
    default: 'h1'
  }
})

const getClasses = () => {
  let defaultClasses = 'font-medium'
  let classes = ''

  switch (props.as) {
    case 'h2':
      classes = 'text-xl'
      break
    case 'h3':
      classes = 'text-lg'
      break
    case 'h4':
      classes = 'text-lg'
      break
    case 'h1':
    default:
      classes = 'text-4xl'
      break
  }

  return `${defaultClasses} ${classes}`
}
</script>
