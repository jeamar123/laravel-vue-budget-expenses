<template>
  <Modal
    :show="show"
    title="Create Transaction"
    wrapper-class="lg:max-w-[600px]"
    @close="emit('close')"
  >
    <template #body-footer>
      <TransactionForm
        v-if="!newTransaction"
        api-route="REQUEST_CREATE_TRANSACTION"
        @close="emit('close')"
        @success="formSuccess"
      />
      
      <div v-else class="pt-10 pb-16">
        <Heading as="h3" class="text-center">Do you want to add a new transaction?</Heading>

        <div class="mt-3 flex items-center justify-center gap-x-3">
          <Button variant="outline" class="w-[100px]" @click="emit('close')">
            No
          </Button>
          <Button class="w-[100px]" @click="newTransaction = false">
            Yes
          </Button>
        </div>
      </div>
    </template>
  </Modal>
</template>

<script setup>
import { Modal, Heading, Button } from '@/components/common'
import { TransactionForm } from '@/components/Transactions'
import { ref } from 'vue'

defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
})

const emit = defineEmits(['close', 'success'])

const newTransaction = ref(false)

const formSuccess = () => {
  emit('success')
  newTransaction.value = true
}
</script>
