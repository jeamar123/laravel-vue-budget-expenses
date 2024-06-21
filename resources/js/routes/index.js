import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/:catchAll(.*)',
    name: 'Redirect',
    redirect: '/login',
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/pages/Auth/Login.vue'),
    meta: {
      auth: false,
    },
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('@/pages/Auth/Register.vue'),
    meta: {
      auth: false,
    },
  },
  {
    path: '/',
    name: 'Dashboard',
    component: () => import('@/pages/Home.vue'),
    meta: {
      auth: true,
      sidemenu: true,
      icon: 'HomeIcon',
    },
  },
  {
    path: '/transaction',
    name: 'Transactions',
    component: () => import('@/pages/Transactions.vue'),
    meta: {
      auth: true,
      sidemenu: true,
      icon: 'ClipboardDocumentListIcon',
    },
  },
  {
    path: '/budget',
    name: 'Budgets',
    component: () => import('@/pages/Budgets.vue'),
    meta: {
      auth: true,
      sidemenu: true,
      icon: 'ScaleIcon',
    },
  },
  {
    path: '/category',
    name: 'Categories',
    component: () => import('@/pages/Categories.vue'),
    meta: {
      auth: true,
      sidemenu: true,
      icon: 'TagIcon',
    },
  },
  {
    path: '/account',
    name: 'Accounts',
    component: () => import('@/pages/Accounts.vue'),
    meta: {
      auth: true,
      sidemenu: true,
      icon: 'CreditCardIcon',
    },
  },

  {
    path: '/settings',
    name: 'Settings',
    component: () => import('@/pages/Settings.vue'),
    meta: {
      auth: true,
      sidemenu: false,
    },
  },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
