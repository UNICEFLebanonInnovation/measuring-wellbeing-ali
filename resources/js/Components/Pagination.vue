<script setup>
import { Link } from '@inertiajs/vue3';
import { useTranslation } from '../i18n';

defineProps({ paginator: { type: Object, required: true } });
const { t } = useTranslation();
const label = (l) => l.replace(/&laquo;|«/g, '').replace(/&raquo;|»/g, '').replace(/Previous/i, '‹').replace(/Next/i, '›').trim();
</script>

<template>
    <div v-if="paginator.total > 0" class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-200 px-4 py-3 text-sm text-slate-600">
        <span>{{ t('ui.showing', { from: paginator.from ?? 0, to: paginator.to ?? 0, total: paginator.total }) }}</span>
        <div class="flex gap-1">
            <template v-for="(link, i) in paginator.links" :key="i">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    preserve-scroll
                    class="rounded-md border px-2 py-1"
                    :class="link.active ? 'border-brand-500 bg-brand-500 text-white' : 'border-slate-300 bg-white hover:bg-slate-50'"
                    v-html="label(link.label)"
                />
                <span v-else class="rounded-md border border-slate-200 px-2 py-1 text-slate-400" v-html="label(link.label)" />
            </template>
        </div>
    </div>
</template>
