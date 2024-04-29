<template>
  <main
    class="flex flex-col lg:flex-row h-screen font-sans text-sm text-slate-950 bg-[#F5F8FB]"
  >
    <Sidemenu />

    <div class="relative flex-1 flex flex-col">
      <Header />
      <div class="relative overflow-y-auto lg:max-h-[100vh-58px] flex-1">
        <router-view></router-view>
      </div>
    </div>
  </main>

  <NotificationAlert
    :show="notifAlert.show"
    :title="notifAlert.title"
    :message="notifAlert.message"
    @hide="commit(UPDATE_NOTIF_ALERT_STATE, { show: false })"
  />
</template>

<script setup>
import { computed } from 'vue'
import Sidemenu from '@/components/Sidemenu.vue'
import Header from '@/components/Header.vue'
import { NotificationAlert } from '@/components/common'
import { useStore } from 'vuex'
import { UPDATE_NOTIF_ALERT_STATE } from '@/store/index'

const store = useStore()
const commit = store.commit

const notifAlert = computed(() => store.state.notifAlert)
</script>
