<script setup>
defineProps({
    label: { type: String, required: true },
    error: { type: String, default: null },
    help: { type: String, default: null },
    required: { type: Boolean, default: false },
});
</script>

<template>
    <div>
        <label class="label">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <slot />
        <p v-if="help" class="mt-1 text-xs text-slate-500">{{ help }}</p>
        <p v-if="error" class="error">{{ error }}</p>
    </div>
</template>
