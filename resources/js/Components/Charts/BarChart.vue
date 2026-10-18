<script setup>
import { computed } from 'vue';
import { Bar } from 'vue-chartjs';
import { BarElement, CategoryScale, Chart as ChartJS, Legend, LinearScale, Title, Tooltip } from 'chart.js';
import { baseOptions, colorAt } from './palette';
import { useTranslation } from '../../i18n';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const props = defineProps({
    labels: { type: Array, required: true },
    datasets: { type: Array, required: true }, // [{label, data}]
    stacked: { type: Boolean, default: false },
    horizontal: { type: Boolean, default: false },
    height: { type: Number, default: 320 },
});
const { dir } = useTranslation();
const rtl = computed(() => dir.value === 'rtl');

const data = computed(() => ({
    labels: props.labels,
    datasets: props.datasets.map((d, i) => ({ label: d.label, data: d.data, backgroundColor: colorAt(i), borderRadius: 3, maxBarThickness: 48 })),
}));

const options = computed(() => ({
    ...baseOptions(rtl.value),
    indexAxis: props.horizontal ? 'y' : 'x',
    scales: {
        x: { stacked: props.stacked, reverse: rtl.value && !props.horizontal, grid: { display: false } },
        y: { stacked: props.stacked, beginAtZero: true, position: rtl.value ? 'right' : 'left' },
    },
}));
</script>

<template>
    <div :style="{ height: `${height}px` }">
        <Bar :data="data" :options="options" />
    </div>
</template>
