<template>
  <component
    :is="as"
    :class="[
      getClasses(),
      disabled &&
        'bg-[#256da1] border-[#256da1] text-white cursor-not-allowed opacity-70 hover:!opacity-70',
    ]"
    :disabled="variant === 'disabled' || disabled"
    :type="type"
  >
    <slot />
  </component>
</template>

<script setup lang="ts">
const props = defineProps({
  as: {
    type: String,
    default: 'button', // button, link, router-link
  },
  type: {
    type: String,
    default: 'button', // button, submit
  },
  variant: {
    type: String,
    default: 'primary', // primary, secondary, outline, disabled
  },
  disabled: {
    type: Boolean,
    default: () => false,
  },
})

const getClasses = () => {
  let defaultClasses =
    'inline-block py-2 px-5 rounded-lg border text-sm hover:opacity-90 outline-none'
  let classes = ''

  switch (props.variant) {
    case 'secondary':
      classes = 'bg-secondary border-secondary text-white'
      break
    case 'outline':
      classes = 'border border-primary text-primary'
      break
    case 'disabled':
      classes =
        'bg-[#256da1] border-[#256da1] text-white cursor-not-allowed opacity-70 hover:!opacity-70'
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
