<script setup>
import { computed } from 'vue';

const props = defineProps({ status: { type: String, default: '' } });

const cls = computed(() => {
    const s = (props.status || '').toLowerCase();
    if (s === 'done') return 'bg-green-100 text-green-800';
    if (s.includes('dropout') || s.includes('no permission') || s === 'na') return 'bg-red-100 text-red-800';
    if (s.includes('pending')) return 'bg-amber-100 text-amber-800';
    if (s.startsWith('post')) return 'bg-blue-100 text-blue-800';
    return 'bg-slate-100 text-slate-700';
});
</script>

<template>
    <span class="badge" :class="cls">{{ status || '—' }}</span>
</template>
