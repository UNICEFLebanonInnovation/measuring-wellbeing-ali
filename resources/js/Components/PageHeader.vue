<script setup>
defineProps({ title: { type: String, required: true }, subtitle: { type: String, default: null } });
</script>

<template>
    <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">{{ title }}</h1>
            <p v-if="subtitle" class="text-sm text-slate-500">{{ subtitle }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <slot />
        </div>
    </div>
</template>
