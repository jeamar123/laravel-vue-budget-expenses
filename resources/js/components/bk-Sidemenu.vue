<template>
  <section
    class="sticky lg:relative top-0 left-0 z-40 bg-slate-900 border-r border-slate-50/[0.06] text-white transition-all duration-[0.5s] ease-in-out"
    :class="isSidemenuFull ? 'lg:w-36' : 'w-full lg:w-16'"
  >
    <Disclosure v-slot="{ open }" as="nav">
      <div
        class="flex lg:flex-col justify-between gap-x-2 h-14 lg:h-screen lg:py-4 px-4 overflow-hidden"
      >
        <button
          class="absolute top-[68px] -right-2 bg-slate-600 rounded-md border border-slate-800 py-[1px] hover:opacity-80"
          @click="isSidemenuFull = !isSidemenuFull"
        >
          <ChevronLeftIcon v-if="isSidemenuFull" class="w-5" />
          <ChevronRightIcon v-else class="w-5" />
        </button>

        <div
          class="flex lg:flex-col gap-x-2"
          :class="!isSidemenuFull && 'items-center'"
        >
          <div class="relative">
            <span class="text-base font-semibold">Logo</span>

            <div class="absolute inset-y-0 left-0 flex items-center lg:hidden">
              <!-- Mobile menu button-->
              <DisclosureButton
                class="relative inline-flex items-center justify-center rounded p-2 text-[#27272a] hover:bg-primary hover:text-white outline-none border border-gray-400"
              >
                <Bars3Icon
                  v-if="!open"
                  class="block h-5 w-5"
                  aria-hidden="true"
                />
                <XMarkIcon v-else class="block h-5 w-5" aria-hidden="true" />
              </DisclosureButton>
            </div>

            <img
              src="images/person-1.png"
              class="h-10 w-10 border rounded-full"
              alt=""
            />
          </div>

          <div class="hidden lg:block pt-10 w-full">
            <ul
              class="flex flex-col gap-y-6"
              :class="!isSidemenuFull && 'items-center'"
            >
              <li
                v-for="{ label, routeName } in menuItems"
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
                  <HomeIcon v-if="label === 'Home'" class="w-5 shrink-0" />
                  <ClipboardDocumentListIcon
                    v-if="label === 'Transactions'"
                    class="w-5 shrink-0"
                  />
                  <TagIcon v-if="label === 'Categories'" class="w-5 shrink-0" />

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
              name: 'Home',
            }"
            class="flex items-center gap-x-2 transition duration-[0.5s] ease-in-out text-slate-400 hover:text-slate-100"
          >
            <Cog6ToothIcon class="w-5 shrink-0" />
            <span v-if="isSidemenuFull">Settings</span>
          </router-link>
          <router-link
            :to="{
              name: 'Home',
            }"
            class="flex items-center gap-x-2 transition duration-[0.5s] ease-in-out text-slate-400 hover:text-slate-100"
          >
            <ArrowLeftEndOnRectangleIcon class="w-5 shrink-0" />
            <span v-if="isSidemenuFull">Logout</span>
          </router-link>
        </div>
      </div>

      <DisclosurePanel class="lg:hidden">
        <DisclosureButton
          v-for="{ label, routeName } in menuItems"
          :key="label"
          as="button"
          :class="[
            routeName === $route.name
              ? 'underline'
              : 'text-[#71717a] hover:underline',
            'block px-4 lg:px-6 py-3 text-sm w-full text-left',
          ]"
          @click="
            $router.push({
              name: routeName,
            })
          "
        >
          {{ label }}
        </DisclosureButton>
        <DisclosureButton
          as="a"
          class="block px-4 lg:px-6 py-3 text-sm w-full text-left text-[#27272a] hover:text-[#71717a]"
          href="https://github.com/jeamar123/vue-simple-components"
        >
          <span class="sr-only">GitHub repository</span>
          <svg fill="currentColor" viewBox="0 0 16 16" class="h-7 w-7">
            <path
              d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"
            ></path>
          </svg>
        </DisclosureButton>
      </DisclosurePanel>
    </Disclosure>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { useRouter } from 'vue-router'
import {
  Bars3Icon,
  XMarkIcon,
  HomeIcon,
  ClipboardDocumentListIcon,
  TagIcon,
  ArrowLeftEndOnRectangleIcon,
  Cog6ToothIcon,
  ChevronLeftIcon,
  ChevronRightIcon,
} from '@heroicons/vue/20/solid'

const router = useRouter()
const isSidemenuFull = ref(true)
const excludedRoutes = ['Auth', 'Login', 'Redirect']
const menuItems = router.getRoutes().reduce((arr, { name }) => {
  if (!excludedRoutes.includes(name)) {
    arr.push({
      label: name,
      routeName: name,
    })
  }

  return arr
}, [])
</script>
