<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import ConfirmButton from '../../Components/ConfirmButton.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ partner: Object, collectors: Array, applications_count: Number, usage_this_year: Number });
const { t } = useTranslation();
const flag = (key, value) => router.patch(route('partners.flags', props.partner.id), { [key]: value }, { preserveScroll: true });
const collectorFlag = (c, key, value) => router.patch(route('collectors.flags', c.id), { [key]: value }, { preserveScroll: true });
const destroy = () => router.delete(route('partners.destroy', props.partner.id));
</script>

<template>
    <Head :title="partner.name" />
    <PageHeader :title="partner.name" :subtitle="`${t('ui.prefix')}: ${partner.prefix ?? '—'}`">
        <button class="btn-secondary" @click="flag('resend_invite', true)">{{ t('ui.resend_invite') }}</button>
        <Link :href="route('partners.edit', partner.id)" class="btn-primary">{{ t('ui.edit') }}</Link>
        <ConfirmButton class="btn-danger" @confirm="destroy">{{ t('ui.delete') }}</ConfirmButton>
        <Link :href="route('partners.index')" class="btn-secondary">{{ t('ui.back') }}</Link>
    </PageHeader>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="card">
            <div class="card-body space-y-2 text-sm">
                <img v-if="partner.logo" :src="partner.logo" alt="" class="mb-2 h-16 rounded" />
                <div><span class="text-slate-500">{{ t('ui.name') }}:</span> {{ partner.firstname }} {{ partner.lastname }}</div>
                <div><span class="text-slate-500">{{ t('ui.email') }}:</span> {{ partner.email }}</div>
                <div><span class="text-slate-500">{{ t('ui.phone') }}:</span> {{ partner.phone ?? '—' }}</div>
                <div><span class="text-slate-500">{{ t('ui.address') }}:</span> {{ partner.address ?? '—' }}</div>
                <div class="flex items-center gap-4 pt-2">
                    <label class="flex items-center gap-2"><input type="checkbox" :checked="partner.is_active" @change="flag('is_active', $event.target.checked)" /> {{ t('ui.active') }}</label>
                    <label class="flex items-center gap-2"><input type="checkbox" :checked="partner.is_readonly" @change="flag('is_readonly', $event.target.checked)" /> {{ t('ui.read_only') }}</label>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body grid grid-cols-2 gap-4 text-center">
                <div><div class="text-xs text-slate-500">{{ t('ui.applications_count') }}</div><div class="text-2xl font-semibold">{{ applications_count }}</div></div>
                <div><div class="text-xs text-slate-500">{{ t('ui.usage_this_year') }}</div><div class="text-2xl font-semibold">{{ usage_this_year }} / {{ partner.max_app_per_year }}</div></div>
            </div>
            <div class="border-t border-slate-200 p-3 text-center">
                <Link :href="route('applications.index', { partner: partner.user_id })" class="text-sm text-brand-700 hover:underline">{{ t('ui.applications') }} →</Link>
            </div>
        </div>
        <div class="card lg:col-span-3">
            <div class="card-header"><h2 class="font-semibold">{{ t('ui.collectors') }}</h2></div>
            <table class="table">
                <thead><tr><th>{{ t('ui.name') }}</th><th>{{ t('ui.email') }}</th><th>{{ t('ui.prefix') }}</th><th>{{ t('ui.city') }}</th><th class="text-end">{{ t('ui.applications_count') }}</th><th>{{ t('ui.read_only') }}</th><th>{{ t('ui.status') }}</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="c in collectors" :key="c.id">
                        <td>{{ c.name }}</td>
                        <td>{{ c.email }}</td>
                        <td class="font-mono text-xs">{{ c.prefix }}</td>
                        <td>{{ c.city }}</td>
                        <td class="text-end">{{ c.applications_count }}</td>
                        <td><input type="checkbox" :checked="c.is_readonly" @change="collectorFlag(c, 'is_readonly', $event.target.checked)" /></td>
                        <td><input type="checkbox" :checked="c.is_active" @change="collectorFlag(c, 'is_active', $event.target.checked)" /> {{ c.is_active ? t('ui.active') : t('ui.inactive') }}</td>
                    </tr>
                    <tr v-if="collectors.length === 0"><td colspan="7" class="py-6 text-center text-slate-500">{{ t('ui.no_results') }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
