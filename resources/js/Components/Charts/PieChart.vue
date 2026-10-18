<script setup>
import { computed } from 'vue';
import { Doughnut } from 'vue-chartjs';
import { ArcElement, Chart as ChartJS, Legend, Tooltip } from 'chart.js';
import { baseOptions, colorAt } from './palette';
import { useTranslation } from '../../i18n';

ChartJS.register(ArcElement, Tooltip, Legend);

const props = defineProps({
    labels: { type: Array, required: true },
    data: { type: Array, required: true },
    height: { type: Number, default: 320 },
});
const { dir } = useTranslation();
const rtl = computed(() => dir.value === 'rtl');

const chartData = computed(() => ({
    labels: props.labels,
    datasets: [{ data: props.data, backgroundColor: props.labels.map((_, i) => colorAt(i)), borderWidth: 1 }],
}));
const options = computed(() => ({ ...baseOptions(rtl.value), cutout: '55%' }));
</script>

<template>
    <div :style="{ height: `${height}px` }">
        <Doughnut :data="chartData" :options="options" />
    </div>
</template>
