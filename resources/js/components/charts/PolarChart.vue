<template>
  <apexchart
    :type="chartOptions.chart.type"
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

const series = computed(() => props.data ?? [])
const chartOptions = computed(() => ({
  chart: {
    width: browserWidth > 1023 ? 420 : '100%',
    type: 'polarArea',
  },
  labels: props.labels ?? [],
  fill: {
    opacity: 1,
  },
  stroke: {
    width: 3,
    colors: ['#f8fafc'],
  },
  yaxis: {
    show: false,
  },
  legend: {
    position: browserWidth > 1023 ? 'right' : 'bottom',
  },
  plotOptions: {
    polarArea: {
      rings: {
        strokeWidth: 0,
      },
      spokes: {
        strokeWidth: 0,
      },
    },
  },
  theme: {
    monochrome: {
      enabled: true,
      color: '#08568e',
      shadeTo: 'dark',
      shadeIntensity: 0.6,
    },
  },
  tooltip: {
    enabled: false,
  },
  dataLabels: {
    enabled: false,
  },
}))

const browserWidth = window.innerWidth
</script>
