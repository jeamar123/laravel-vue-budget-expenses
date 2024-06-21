<template>
  <!-- <main class="flex flex-row h-screen font-sans text-sm text-slate-950 bg-[#F5F8FB]">
    <Sidemenu />
    
    <div class="flex-1 flex flex-col">
      <Header />
      <div class="overflow-y-auto max-h-[100vh-58px]">
        <router-view></router-view>
      </div>
    </div>
  </main> -->
  <Default v-if="$route.meta.auth" />
  <Guest v-else />
</template>

<script setup>
// import Sidemenu from '@/components/Sidemenu.vue'
// import Header from '@/components/Header.vue'

import { Default, Guest } from '@/layouts'
</script>
