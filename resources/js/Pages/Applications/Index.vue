<script setup>
import { reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import Pagination from '../../Components/Pagination.vue';
import StatusBadge from '../../Components/StatusBadge.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({
    applications: Object,
    filters: Object,
    statuses: Array,
    partners: Array,
    collectors: Array,
    governorates: Array,
    canCreate: Boolean,
});
const { t, locale } = useTranslation();

const form = reactive({
    code: props.filters.code ?? '',
    status: props.filters.status ?? '',
    partner: props.filters.partner ?? '',
    collector: props.filters.collector ?? '',
    governorate: props.filters.governorate ?? '',
    from: props.filters.from ?? '',
    to: props.filters.to ?? '',
    sort: props.filters.sort ?? 'created_at',
    dir: props.filters.dir ?? 'desc',
});

const clean = () => Object.fromEntries(Object.entries(form).filter(([, v]) => v !== '' && v !== null));
const apply = () => router.get(route('applications.index'), clean(), { preserveState: true, replace: true });
const reset = () => {
    Object.keys(form).forEach((k) => (form[k] = k === 'sort' ? 'created_at' : k === 'dir' ? 'desc' : ''));
    apply();
};
const sortBy = (column) => {
    form.dir = form.sort === column && form.dir === 'asc' ? 'desc' : 'asc';
    form.sort = column;
    apply();
};
const create = () => router.post(route('applications.store'));
const exportUrl = () => route('applications.export', clean());
const changeClass = (c) => (c === 'Increase' ? 'text-green-700' : c === 'Decrease' ? 'text-red-700' : 'text-slate-600');
const locName = (g) => (locale.value === 'ar' && g.arabic ? g.arabic : g.name);
</script>

<template>
    <Head :title="t('ui.applications')" />
    <PageHeader :title="t('ui.applications')">
        <a v-if="$page.props.auth.user.is_admin || $page.props.auth.user.is_partner" :href="exportUrl()" class="btn-secondary">{{ t('ui.export_csv') }}</a>
        <button v-if="canCreate" class="btn-primary" @click="create">+ {{ t('ui.add_application') }}</button>
    </PageHeader>

    <form class="card mb-4 grid grid-cols-2 gap-3 p-4 md:grid-cols-4 lg:grid-cols-8" @submit.prevent="apply">
        <input v-model="form.code" class="input col-span-2" :placeholder="t('ui.code')" />
        <select v-model="form.status" class="input">
            <option value="">{{ t('ui.status') }}: {{ t('ui.all') }}</option>
            <option v-for="s in statuses" :key="s.id" :value="s.id">{{ s.name }}</option>
        </select>
        <select v-if="partners.length" v-model="form.partner" class="input">
            <option value="">{{ t('ui.partner') }}: {{ t('ui.all') }}</option>
            <option v-for="p in partners" :key="p.id" :value="p.id">{{ p.name }}</option>
        </select>
        <select v-if="collectors.length" v-model="form.collector" class="input">
            <option value="">{{ t('ui.collector') }}: {{ t('ui.all') }}</option>
            <option v-for="c in collectors" :key="c.id" :value="c.id">{{ c.name }}</option>
        </select>
        <select v-model="form.governorate" class="input">
            <option value="">{{ t('ui.governorate') }}: {{ t('ui.all') }}</option>
            <option v-for="g in governorates" :key="g.id" :value="g.id">{{ locName(g) }}</option>
        </select>
        <input v-model="form.from" type="date" class="input" :title="t('ui.from')" />
        <input v-model="form.to" type="date" class="input" :title="t('ui.to')" />
        <div class="col-span-2 flex gap-2 md:col-span-4 lg:col-span-8">
            <button type="submit" class="btn-primary">{{ t('ui.filter') }}</button>
            <button type="button" class="btn-secondary" @click="reset">{{ t('ui.reset') }}</button>
        </div>
    </form>

    <div class="card overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th class="cursor-pointer" @click="sortBy('code')">{{ t('ui.code') }}</th>
                    <th class="cursor-pointer" @click="sortBy('pre_test_date')">{{ t('ui.pre_test_date') }}</th>
                    <th class="cursor-pointer" @click="sortBy('post_test_date')">{{ t('ui.post_test_date') }}</th>
                    <th class="text-end">{{ t('ui.pre_test_score') }}</th>
                    <th class="text-end">{{ t('ui.post_test_score') }}</th>
                    <th>{{ t('ui.change') }}</th>
                    <th>{{ t('ui.governorate') }}</th>
                    <th>{{ t('ui.partner') }}</th>
                    <th>{{ t('ui.collector') }}</th>
                    <th class="cursor-pointer" @click="sortBy('status')">{{ t('ui.status') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr v-for="a in applications.data" :key="a.id" class="hover:bg-slate-50">
                    <td class="font-mono text-xs font-semibold">
                        <Link :href="route('applications.show', a.id)" class="text-brand-700 hover:underline">{{ a.code }}</Link>
                        <div class="text-[10px] font-normal text-slate-400">{{ a.form }}</div>
                    </td>
                    <td>{{ a.pre_test_date ?? '—' }}</td>
                    <td>{{ a.post_test_date ?? '—' }}</td>
                    <td class="text-end">{{ a.pre_test_score ?? '—' }}</td>
                    <td class="text-end">{{ a.post_test_score ?? '—' }}</td>
                    <td :class="changeClass(a.change)">{{ a.change ? t(`ui.${a.change.toLowerCase()}`) : '—' }}</td>
                    <td>{{ a.governorate ?? '—' }}</td>
                    <td>{{ a.partner ?? '—' }}</td>
                    <td>{{ a.collector ?? '—' }}</td>
                    <td><StatusBadge :status="a.status" /></td>
                    <td class="text-end">
                        <Link :href="route('applications.show', a.id)" class="btn-secondary btn-sm">{{ t('ui.view') }}</Link>
                    </td>
                </tr>
                <tr v-if="applications.data.length === 0">
                    <td colspan="11" class="py-8 text-center text-slate-500">{{ t('ui.no_results') }}</td>
                </tr>
            </tbody>
        </table>
        <Pagination :paginator="applications" />
    </div>
</template>
