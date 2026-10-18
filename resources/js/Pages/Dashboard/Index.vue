<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ partners: Array, totals: Object, years: Array, year: [Number, null] });
const { t } = useTranslation();

const setYear = (value) => router.post(route('dashboard.year'), { year: value || null }, { preserveScroll: true });
const link = (partner, status) => route('applications.index', { partner: partner.user_id, status });
</script>

<template>
    <Head :title="t('ui.dashboard')" />
    <PageHeader :title="t('ui.dashboard')">
        <label class="text-sm text-slate-600">{{ t('ui.year') }}</label>
        <select class="input w-auto" :value="year ?? ''" @change="setYear($event.target.value)">
            <option value="">{{ t('ui.all_years') }}</option>
            <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
        </select>
    </PageHeader>

    <div class="mb-6 grid grid-cols-2 gap-3 md:grid-cols-5">
        <div v-for="(value, key) in totals" :key="key" class="card p-4">
            <div class="text-xs tracking-wide text-slate-500 uppercase">{{ t(`ui.${key}`) }}</div>
            <div class="mt-1 text-2xl font-semibold text-brand-700">{{ value }}</div>
        </div>
    </div>

    <div class="card overflow-x-auto">
        <div class="card-header">
            <h2 class="font-semibold">{{ t('ui.applications') }} {{ t('ui.per_partner') }}</h2>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ t('ui.partner') }}</th>
                    <th class="text-end">{{ t('ui.pre_test_pending') }}</th>
                    <th class="text-end">{{ t('ui.pre_test_completed') }}</th>
                    <th class="text-end">{{ t('ui.post_test_pending') }}</th>
                    <th class="text-end">{{ t('ui.done') }}</th>
                    <th class="text-end">{{ t('ui.dropout') }}</th>
                    <th class="text-end">{{ t('ui.not_applicable') }}</th>
                    <th class="text-end">{{ t('ui.total') }}</th>
                    <th class="text-end">{{ t('ui.quota') }}</th>
                    <th class="text-end">{{ t('ui.remaining') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr v-for="p in partners" :key="p.id" :class="{ 'text-slate-400': !p.is_active }">
                    <td>
                        <Link v-if="$page.props.auth.user.is_admin" :href="route('partners.show', p.id)" class="font-medium text-brand-700 hover:underline">{{ p.name }}</Link>
                        <span v-else class="font-medium">{{ p.name }}</span>
                    </td>
                    <td class="text-end"><Link :href="link(p, '')" class="hover:underline">{{ p.pre_test_pending }}</Link></td>
                    <td class="text-end">{{ p.pre_test_completed }}</td>
                    <td class="text-end">{{ p.post_test_pending }}</td>
                    <td class="text-end font-semibold text-green-700">{{ p.done }}</td>
                    <td class="text-end">{{ p.dropout }}</td>
                    <td class="text-end">{{ p.not_applicable }}</td>
                    <td class="text-end font-semibold">
                        <Link :href="route('applications.index', { partner: p.user_id })" class="hover:underline">{{ p.total }}</Link>
                    </td>
                    <td class="text-end">{{ p.quota }}</td>
                    <td class="text-end" :class="p.remaining === 0 && p.quota > 0 ? 'text-red-600' : ''">{{ p.remaining }}</td>
                </tr>
                <tr v-if="partners.length === 0">
                    <td colspan="10" class="py-6 text-center text-slate-500">{{ t('ui.no_results') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
