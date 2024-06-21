import './bootstrap'
import { createApp } from 'vue'
import VueApexCharts from 'vue3-apexcharts'

import '../css/app.css'

import store from '@/store'
import routes from '@/routes'
import App from '@/App.vue'

const app = createApp(App)

app.use(store).use(routes).use(VueApexCharts).mount('#app')
