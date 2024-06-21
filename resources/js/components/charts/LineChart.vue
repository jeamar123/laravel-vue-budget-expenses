<template>
  <apexchart
    :type="chartOptions.chart.type"
    :height="chartOptions.chart.height"
    :width="chartOptions.chart.width"
    :options="chartOptions"
    :series="series"
  ></apexchart>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  data: {
    type: Array,
    required: true,
  },
  labels: {
    type: Array,
    required: true,
  },
})

const series = computed(() => [
  {
    name: 'series1',
    data: [31, 40, 28, 51, 42, 109, 100],
  },
])
const chartOptions = computed(() => ({
  chart: {
    type: 'area',
    height: isMobile ? 300 : 280,
    width: isMobile ? 340 : 420,
    zoom: {
      enabled: false,
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    curve: 'straight',
  },

  title: {
    text: '',
    align: 'left',
  },
  subtitle: {
    text: '',
    align: 'left',
  },
  // labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G'],

  xaxis: {
    type: 'datetime',
    categories: [
      '2024-01-01',
      '2024-02-01',
      '2024-03-01',
      '2024-04-01',
      '2024-05-01',
      '2024-06-01',
      '2024-07-01',
    ],
  },
  yaxis: {
    opposite: true,
  },
}))

const browserWidth = window.innerWidth
const isMobile = browserWidth < 1024
</script>
