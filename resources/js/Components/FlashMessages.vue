<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const visible = ref({ success: null, error: null });

watch(
    () => page.props.flash,
    (flash) => {
        visible.value = { success: flash?.success ?? null, error: flash?.error ?? null };
        if (flash?.success) setTimeout(() => (visible.value.success = null), 6000);
    },
    { immediate: true, deep: true },
);
</script>

<template>
    <div class="space-y-2">
        <div v-if="visible.success" class="flex items-start justify-between rounded-md border border-green-200 bg-green-50 px-4 py-2 text-sm text-green-800" role="status">
            <span>{{ visible.success }}</span>
            <button class="ms-3 text-green-700" aria-label="Close" @click="visible.success = null">×</button>
        </div>
        <div v-if="visible.error" class="flex items-start justify-between rounded-md border border-red-200 bg-red-50 px-4 py-2 text-sm text-red-800" role="alert">
            <span>{{ visible.error }}</span>
            <button class="ms-3 text-red-700" aria-label="Close" @click="visible.error = null">×</button>
        </div>
    </div>
</template>
