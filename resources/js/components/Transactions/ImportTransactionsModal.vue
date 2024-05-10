<template>
  <Modal
    :show="show"
    title="Import Transactions"
    wrapper-class="lg:max-w-[600px]"
    @close="
      () => {
        resetFileUploadModal()
        emit('close')
      }
    "
  >
    <template #body-footer>
      <div class="space-y-2 px-6 pt-6 pb-8">
        <div
          class="group relative border border-dashed border-slate-400 hover:border-slate-900 w-full h-[180px] rounded flex items-center justify-center cursor-pointer mb-3 transition-all ease-in duration-200"
        >
          <input
            id="file"
            ref="file"
            type="file"
            class="h-full w-full absolute top-0 left-0 opacity-0 text-[0] cursor-pointer"
            @input="
              (ev) => {
                form.file = ev.target.files[0]
              }
            "
          />

          <div
            v-if="!form.file"
            class="text-center flex flex-col items-center text-slate-600 group-hover:text-slate-900 transition-all ease-in duration-200"
          >
            <Icon name="ArrowUpTrayIconOutline" class="w-8 mb-3" />
            <p
              class="w-[120px] mx-auto"
              v-text="`Click or Drop to upload a file`"
            />
          </div>

          <div v-else class="text-center">
            <p><span class="font-bold">Filename:</span> {{ form.file.name }}</p>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-end gap-x-4 p-4 border-t">
        <Button variant="blank" @click="emit('close')"> Cancel </Button>
        <Button
          type="button"
          :variant="!form.file ? 'disabled' : 'primary'"
          :disabled="!form.file"
          @click="upload"
        >
          Upload
        </Button>
      </div>
    </template>
  </Modal>
</template>

<script setup>
import { Modal, Button, Icon } from '@/components/common'
import { ref } from 'vue'
import { useStore } from 'vuex'

defineProps({
  show: {
    type: Boolean,
    default: () => false,
  },
})

const emit = defineEmits(['close', 'success'])

const store = useStore()
const dispatch = store.dispatch

const form = ref({
  file: null,
})
const results = ref([])
const file = ref(null)

const upload = async () => {
  let params = new FormData()
  params.append('file', form.value.file)
  const res = await dispatch('REQUEST_UPLOAD_TRANSACTIONS', params)
  console.log(res)
  if (res.status === 201) {
    dispatch('SHOW_NOTIF_ALERT', {
      message: `${res.data.sucessfulImport.length} successful imports. ${res.data.failedImport.length} failed.`,
    })
    emit('success')
  }
}

const resetFileUploadModal = () => {
  form.value.file = null
  document.getElementById('file').value = ''
}
</script>
