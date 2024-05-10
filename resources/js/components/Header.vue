<template>
  <header class="sticky top-0 bg-slate-900 shadow z-[4]">
    <div class="flex items-center justify-between px-2 lg:px-8 py-2">
      <div>
        <Popover v-slot="{ open, close }">
          <PopoverButton
            class="outline-none relative inline-flex items-center justify-center rounded p-[6px] text-white hover:bg-primary hover:text-white outline-none border border-slate-600"
          >
            <Icon
              :name="!open ? 'Bars3Icon' : 'XMarkIcon'"
              class="block h-5 w-5"
            />
          </PopoverButton>

          <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-100 ease-out"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
          >
            <PopoverPanel
              class="fixed left-0 top-[55px] h-[calc(100vh-55px)] w-[200px] border-none border-slate-700 pt-2 pb-5 px-3 bg-slate-900"
            >
              <button
                v-for="{ label, routeName } in menuItems"
                :key="label"
                :class="[
                  routeName === $route.name
                    ? 'text-white underline'
                    : 'text-slate-400 hover:text-white hover:underline',
                  'block px-4 lg:px-6 py-3 text-sm w-full text-left',
                ]"
                @click="
                  () => {
                    $router.push({ name: routeName })
                    close()
                  }
                "
              >
                {{ label }}
              </button>
            </PopoverPanel>
          </transition>
        </Popover>
      </div>

      <div>
        <Popover v-slot="{ close }">
          <PopoverButton class="outline-none flex items-center">
            <img
              :src="`images/person-1.png`"
              alt="user-icon"
              class="h-10 w-10 rounded-full border border-slate-500"
            />
          </PopoverButton>

          <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-100 ease-out"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
          >
            <PopoverPanel
              class="absolute left-0 md:left-auto right-auto md:right-5 top-[56px] w-full md:w-[200px] border-t border-slate-700 pt-2 pb-5 bg-slate-900"
            >
              <div class="container mx-auto lg:px-3">
                <button
                  class="px-4 lg:px-6 py-3 text-sm w-full text-left block"
                  :class="
                    $route.name === 'Settings'
                      ? 'text-white underline'
                      : 'text-slate-400 hover:text-white hover:underline'
                  "
                  @click="
                    () => {
                      $router.push({ name: 'Settings' })
                      close()
                    }
                  "
                >
                  Settings
                </button>
                <button
                  class="px-4 lg:px-6 py-3 text-sm w-full text-left block text-slate-400 hover:text-white hover:underline"
                  @click="
                    () => {
                      logout()
                      close()
                    }
                  "
                >
                  Logout
                </button>
              </div>
            </PopoverPanel>
          </transition>
        </Popover>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { Icon } from '@/components/common'
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { useStore } from 'vuex'

const store = useStore()
const dispatch = store.dispatch
const router = useRouter()
const isSidemenuFull = ref(true)
const excludedRoutes = ['Auth', 'Login', 'Redirect']
const menuItems = router.getRoutes().reduce((arr, { name, meta }) => {
  if (!excludedRoutes.includes(name) && meta?.sidemenu) {
    arr.push({
      label: name,
      routeName: name,
      icon: meta?.icon,
    })
  }

  return arr
}, [])

const logout = async () => {
  await dispatch('REQUEST_AUTH_LOGOUT')
  router.push({ name: 'Login' })
}
</script>
