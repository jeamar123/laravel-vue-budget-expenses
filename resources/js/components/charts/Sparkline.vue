<template>
  <apexchart
    :type="chartOptions.chart.type"
    :height="chartOptions.chart.height"
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
  title: {
    type: Object,
    default: {
      text: '',
      offsetX: 30,
      style: {
        fontSize: '24px',
        cssClass: 'apexcharts-yaxis-title',
      },
    },
  },
  subtitle: {
    type: Object,
    default: {
      text: '',
      offsetX: 30,
      style: {
        fontSize: '14px',
        cssClass: 'apexcharts-yaxis-title',
      },
    },
  },
  color: {
    type: String,
    default: '#DCE6EC',
  },
})

var colorPalette = [
  '#DCE6EC',
  '#00D8B6',
  '#008FFB',
  '#FEB019',
  '#FF4560',
  '#775DD0',
]
const series = computed(() => [
  {
    name: props.subtitle?.text ?? '',
    data: props.data ?? [],
  },
])
const chartOptions = computed(() => ({
  chart: {
    type: 'area',
    height: 160,
    sparkline: {
      enabled: true,
    },
  },
  stroke: {
    curve: 'straight',
  },
  fill: {
    opacity: 1,
  },
  labels: props.labels ?? [],
  yaxis: {
    min: 0,
    show: false,
  },
  xaxis: {
    type: 'datetime',
  },
  colors: props.color ? [props.color] : colorPalette,
  title: props.title,
  subtitle: props.subtitle,
  legend: {
    show: false,
  },
}))

const browserWidth = window.innerWidth
const isMobile = browserWidth < 1024
</script>
