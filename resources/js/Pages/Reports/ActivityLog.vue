<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import Pagination from '../../Components/Pagination.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ logs: Object, code: [String, null] });
const { t } = useTranslation();
const code = ref(props.code ?? '');
const search = () => router.get(route('reports.activity'), code.value ? { code: code.value } : {}, { preserveState: true });
</script>

<template>
    <Head :title="t('reports.activity_log')" />
    <PageHeader :title="t('reports.activity_log')" :subtitle="t('reports.activity_log_subtitle')">
        <Link :href="route('reports.index')" class="btn-secondary btn-sm">{{ t('reports.title') }}</Link>
    </PageHeader>

    <form class="mb-4 flex gap-2" @submit.prevent="search">
        <input v-model="code" type="search" class="input max-w-xs" :placeholder="t('reports.search_code')" />
        <button type="submit" class="btn-primary">{{ t('ui.search') }}</button>
    </form>

    <div class="card overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ t('reports.when') }}</th>
                    <th>{{ t('reports.code') }}</th>
                    <th>{{ t('reports.event') }}</th>
                    <th>{{ t('reports.by') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr v-for="log in logs.data" :key="log.id">
                    <td class="whitespace-nowrap text-slate-500">{{ log.at ?? '—' }}</td>
                    <td>
                        <Link v-if="log.application_id" :href="route('applications.show', log.application_id)" class="text-brand-700 hover:underline">{{ log.code ?? log.application_id }}</Link>
                        <span v-else>—</span>
                    </td>
                    <td>{{ log.text }}</td>
                    <td>{{ log.by }}</td>
                </tr>
                <tr v-if="logs.data.length === 0">
                    <td colspan="4" class="py-6 text-center text-slate-500">{{ t('ui.no_results') }}</td>
                </tr>
            </tbody>
        </table>
        <Pagination :paginator="logs" />
    </div>
</template>
