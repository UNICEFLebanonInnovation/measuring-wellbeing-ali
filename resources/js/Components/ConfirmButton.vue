<script setup>
import { useTranslation } from '../i18n';

const props = defineProps({
    message: { type: String, default: null },
    class: { type: String, default: 'btn-danger btn-sm' },
});
const emit = defineEmits(['confirm']);
const { t } = useTranslation();

const click = () => {
    if (window.confirm(props.message ?? t('ui.confirm_delete'))) emit('confirm');
};
</script>

<template>
    <button type="button" :class="props.class" @click="click"><slot /></button>
</template>
