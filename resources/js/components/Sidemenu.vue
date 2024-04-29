<template>
  <nav
    class="sticky top-0 lg:relative z-[5] bg-slate-900 lg:border-r border-slate-50/[0.06] text-white transition-all duration-[0.5s] ease-in-out"
    :class="isSidemenuFull ? 'lg:w-40' : 'lg:w-20'"
  >
    <div
      class="hidden lg:flex flex-col justify-between gap-x-2 h-screen p-4 overflow-hidden"
    >
      <button
        class="absolute top-3 lg:top-[18px] right-2 lg:-right-3 bg-slate-600 rounded-md border border-slate-800 py-[1px] hover:opacity-90"
        @click="isSidemenuFull = !isSidemenuFull"
      >
        <Icon
          :name="isSidemenuFull ? 'ChevronLeftIcon' : 'ChevronRightIcon'"
          class="w-5"
        />
      </button>

      <div
        class="flex flex-col gap-x-2"
        :class="!isSidemenuFull && 'items-center'"
      >
        <div class="relative flex items-center min-h-[24px] pb-3 mb-3">
          <router-link :to="{ name: 'Dashboard' }">
            <!-- <span class="text-base font-semibold hidden lg:block">Logo</span> -->
            <img
              :src="`images/person-1.png`"
              alt="user-icon"
              class="h-12 w-12 rounded-full border border-slate-700"
            />
          </router-link>
        </div>

        <div class="w-full">
          <ul
            class="flex flex-col gap-y-6"
            :class="!isSidemenuFull && 'items-center'"
          >
            <li
              v-for="{ label, routeName, icon } in menuItems"
              :key="label"
              class=""
            >
              <router-link
                :to="{
                  name: routeName,
                }"
                class="flex items-center gap-x-2 transition duration-[0.5s] ease-in-out"
                :class="
                  $route.name === routeName
                    ? 'text-slate-100'
                    : 'text-slate-400 hover:text-slate-100'
                "
              >
                <Icon v-if="icon" :name="icon" class="w-5 shrink-0" />
                <span v-if="isSidemenuFull">{{ label }}</span>
              </router-link>
            </li>
          </ul>
        </div>
      </div>

      <div
        class="flex flex-col gap-y-6"
        :class="!isSidemenuFull && 'items-center'"
      >
        <router-link
          :to="{
            name: 'Settings',
          }"
          class="flex items-center gap-x-2 transition duration-[0.5s] ease-in-out text-slate-400 hover:text-slate-100"
        >
          <Icon name="Cog6ToothIcon" class="w-5 shrink-0" />
          <span v-if="isSidemenuFull">Settings</span>
        </router-link>
        <button
          class="flex items-center gap-x-2 transition duration-[0.5s] ease-in-out text-slate-400 hover:text-slate-100"
          @click="logout"
        >
          <Icon name="ArrowLeftEndOnRectangleIcon" class="w-5 shrink-0" />
          <span v-if="isSidemenuFull">Logout</span>
        </button>
      </div>
    </div>

    <!-- Mobile navigation menu -->
    <div class="flex items-center justify-between py-3 px-2 lg:px-4 lg:hidden">
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
              class="absolute left-0 top-[64px] w-full border-t border-slate-700 pt-2 pb-5 bg-slate-900"
            >
              <button
                v-for="{ label, routeName } in menuItems"
                :key="label"
                :class="[
                  routeName === $route.name
                    ? 'underline'
                    : 'text-slate-400 hover:underline',
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
          <PopoverButton class="outline-none">
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
              class="absolute left-0 top-[64px] w-full border-t border-slate-700 pt-2 pb-5 bg-slate-900"
            >
              <button
                class="px-4 lg:px-6 py-3 text-sm w-full text-left block"
                :class="$route.name === 'Settings' && 'underline'"
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
                class="px-4 lg:px-6 py-3 text-sm w-full text-left block"
                @click="
                  () => {
                    logout()
                    close()
                  }
                "
              >
                Logout
              </button>
            </PopoverPanel>
          </transition>
        </Popover>
      </div>
    </div>
  </nav>
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
