<script setup>
import { computed } from 'vue';
import { Line } from 'vue-chartjs';
import { CategoryScale, Chart as ChartJS, Legend, LinearScale, LineElement, PointElement, Tooltip } from 'chart.js';
import { baseOptions, colorAt } from './palette';
import { useTranslation } from '../../i18n';

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Tooltip, Legend);

const props = defineProps({
    labels: { type: Array, required: true },
    datasets: { type: Array, required: true },
    height: { type: Number, default: 320 },
});
const { dir } = useTranslation();
const rtl = computed(() => dir.value === 'rtl');

const data = computed(() => ({
    labels: props.labels,
    datasets: props.datasets.map((d, i) => ({ label: d.label, data: d.data, borderColor: colorAt(i), backgroundColor: colorAt(i), tension: 0.25, fill: false })),
}));
const options = computed(() => ({
    ...baseOptions(rtl.value),
    scales: { x: { reverse: rtl.value, grid: { display: false } }, y: { beginAtZero: true, position: rtl.value ? 'right' : 'left' } },
}));
</script>

<template>
    <div :style="{ height: `${height}px` }">
        <Line :data="data" :options="options" />
    </div>
</template>
