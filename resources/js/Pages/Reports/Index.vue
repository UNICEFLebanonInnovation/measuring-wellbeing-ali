<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import { useTranslation } from '../../i18n';

defineProps({ reports: Array });
const { t } = useTranslation();
</script>

<template>
    <Head :title="t('reports.title')" />
    <PageHeader :title="t('reports.title')" :subtitle="t('reports.subtitle')">
        <Link :href="route('reports.activity')" class="btn-secondary btn-sm">{{ t('reports.activity_log') }}</Link>
    </PageHeader>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <Link v-for="r in reports" :key="r.slug" :href="route('reports.show', r.slug)" class="card flex flex-col gap-2 p-4 transition hover:border-brand-400 hover:shadow">
            <h2 class="font-semibold text-brand-700">{{ t(`reports.${r.slug}`) }}</h2>
            <p class="flex-1 text-sm text-slate-600">{{ t(`reports.${r.slug}_desc`) }}</p>
            <span class="text-xs font-medium text-brand-600">{{ t('reports.open') }} →</span>
        </Link>
    </div>
</template>
