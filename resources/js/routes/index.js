import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  { path: '/:catchAll(.*)', redirect: '/'},
  {
    path: "/",
    name: 'Home',
    component: () => import("@/pages/Home.vue")
  },
  {
    path: "/components",
    name: 'Components',
    component: () => import("@/pages/Components.vue")
  },
]

export default createRouter({
  history: createWebHistory(),
  routes
})
