<template>
  <component
    :is="as"
    :class="[getClasses()]" :disabled="variant === 'disabled' || disabled">
    <slot />
  </component>
</template>

<script setup lang="ts">
const props = defineProps({
  as: {
    type: String,
    default: 'button' // button, link, router-link
  },
  variant: {
    type: String,
    default: 'primary' // primary, secondary, outline, disabled
  },
  disabled: {
    type: Boolean,
    default: () => false
  }
})

const getClasses = () => {
  let defaultClasses = 'inline-block py-3 px-6 rounded-lg border text-sm hover:opacity-90'
  let classes = ''

  switch (props.variant) {
    case 'secondary':
      classes = 'bg-secondary border-secondary text-white'
      break
    case 'outline':
      classes = 'border-2 border-primary text-primary'
      break
    case 'disabled':
      classes = 'bg-[#256da1] border-[#256da1] text-white cursor-not-allowed opacity-70 hover:opacity-70'
      break
    case 'blank':
      classes = 'border-none !p-2'
      break
    case 'primary':
    default:
      classes = 'bg-primary border-primary text-white'
      break
  }

  return `${defaultClasses} ${classes}`
}
</script>
