<script setup>
import { computed, reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import Pagination from '../../Components/Pagination.vue';
import BarChart from '../../Components/Charts/BarChart.vue';
import PieChart from '../../Components/Charts/PieChart.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({
    slug: String,
    data: Object,
    filters: Object,
    availableFilters: Array,
    options: Object,
    year: [Number, null],
});
const { t, locale } = useTranslation();

const form = reactive({
    partner: props.filters.partner ?? '',
    governorate: props.filters.governorate ?? '',
    gender: props.filters.gender ?? '',
    form: props.filters.form ?? '',
    nationality: props.filters.nationality ?? '',
});

const has = (f) => props.availableFilters.includes(f);
const clean = (obj) => Object.fromEntries(Object.entries(obj).filter(([, v]) => v !== '' && v !== null));

const apply = () => router.get(route('reports.show', props.slug), clean(form), { preserveState: true, preserveScroll: true });
const reset = () => {
    Object.keys(form).forEach((k) => (form[k] = ''));
    apply();
};
const csvUrl = computed(() => route('reports.show', { report: props.slug, ...clean(form), format: 'csv' }));

const label = (key) => t(`reports.${key}`);
const govName = (g) => (locale.value === 'ar' && g.arabic ? g.arabic : g.name);

const chartLabels = (chart) => (chart.translateLabels ? chart.labels.map(label) : chart.labels);
const chartDatasets = (chart) => (chart.translateDatasets ? chart.datasets.map((d) => ({ ...d, label: label(d.label) })) : chart.datasets.map((d) => ({ ...d, label: label(d.label) })));
const cell = (row, col) => {
    const v = row[col.key];
    if (v === null || v === undefined) return '—';
    return col.translate ? label(String(v)) : v;
};
const tableRows = computed(() => props.data.paginator ? props.data.paginator.data : props.data.table.rows);
const hasData = computed(() => tableRows.value.length > 0 || (props.data.charts ?? []).some((c) => c.datasets.some((d) => d.data.some((v) => v > 0))));
</script>

<template>
    <Head :title="label(slug)" />
    <PageHeader :title="label(slug)" :subtitle="label(`${slug}_desc`)">
        <Link :href="route('reports.index')" class="btn-secondary btn-sm">{{ t('ui.back') }}</Link>
        <a :href="csvUrl" class="btn-primary btn-sm">{{ t('reports.download_csv') }}</a>
    </PageHeader>

    <!-- Filters -->
    <form class="card mb-4 p-4" @submit.prevent="apply">
        <div class="flex flex-wrap items-end gap-3">
            <div v-if="has('partner') && options.partners.length">
                <label class="label">{{ label('partner') }}</label>
                <select v-model="form.partner" class="input w-auto">
                    <option value="">{{ t('reports.all') }}</option>
                    <option v-for="p in options.partners" :key="p.id" :value="p.id">{{ p.name }}</option>
                </select>
            </div>
            <div v-if="has('governorate')">
                <label class="label">{{ label('governorate') }}</label>
                <select v-model="form.governorate" class="input w-auto">
                    <option value="">{{ t('reports.all') }}</option>
                    <option v-for="g in options.governorates" :key="g.id" :value="g.id">{{ govName(g) }}</option>
                </select>
            </div>
            <div v-if="has('gender')">
                <label class="label">{{ label('gender') }}</label>
                <select v-model="form.gender" class="input w-auto">
                    <option value="">{{ t('reports.all') }}</option>
                    <option v-for="g in options.genders" :key="g" :value="g">{{ label(g) }}</option>
                </select>
            </div>
            <div v-if="has('form')">
                <label class="label">{{ label('form') }}</label>
                <select v-model="form.form" class="input w-auto">
                    <option value="">{{ t('reports.all') }}</option>
                    <option v-for="f in options.forms" :key="f" :value="f">{{ f }}</option>
                </select>
            </div>
            <div v-if="has('nationality')">
                <label class="label">{{ label('nationality') }}</label>
                <select v-model="form.nationality" class="input w-auto">
                    <option value="">{{ t('reports.all') }}</option>
                    <option v-for="n in options.nationalities" :key="n" :value="n">{{ n }}</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">{{ t('reports.apply') }}</button>
            <button type="button" class="btn-secondary" @click="reset">{{ t('reports.reset') }}</button>
            <span class="text-xs text-slate-500">{{ t('ui.year') }}: {{ year ?? t('ui.all_years') }} · {{ t('reports.year_hint') }}</span>
        </div>
    </form>

    <!-- Summary -->
    <div v-if="data.summary?.length" class="mb-4 grid grid-cols-2 gap-3 md:grid-cols-4">
        <div v-for="s in data.summary" :key="s.label" class="card p-4">
            <div class="text-xs tracking-wide text-slate-500 uppercase">{{ label(s.label) }}</div>
            <div class="mt-1 text-2xl font-semibold text-brand-700">{{ s.value }}</div>
        </div>
    </div>

    <div v-if="!hasData" class="card p-6 text-center text-slate-500">{{ t('reports.no_data') }}</div>

    <!-- Charts -->
    <div v-if="hasData && data.charts?.length" class="mb-4 grid gap-4" :class="data.charts.length > 1 ? 'lg:grid-cols-2' : ''">
        <div v-for="(chart, i) in data.charts" :key="i" class="card p-4">
            <h2 class="mb-3 text-sm font-semibold text-slate-700">{{ label(chart.title) }}</h2>
            <PieChart v-if="chart.type === 'pie'" :labels="chartLabels(chart)" :data="chart.datasets[0].data" />
            <BarChart v-else :labels="chartLabels(chart)" :datasets="chartDatasets(chart)" :stacked="chart.stacked ?? false" />
        </div>
    </div>

    <!-- Tables -->
    <div v-if="hasData" class="space-y-4">
        <div v-for="(table, key) in { table: data.table, secondaryTable: data.secondaryTable }" :key="key">
            <div v-if="table && (key === 'table' || table.rows.length)" class="card overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th v-for="c in table.columns" :key="c.key" :class="{ 'text-end': typeof tableRows[0]?.[c.key] === 'number' }">
                                {{ c.raw ? c.label : label(c.label) }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="(row, ri) in key === 'table' ? tableRows : table.rows" :key="ri">
                            <td v-for="c in table.columns" :key="c.key" :class="{ 'text-end tabular-nums': typeof row[c.key] === 'number' }">
                                <Link v-if="c.key === 'code' && row.id" :href="route('applications.show', row.id)" class="text-brand-700 hover:underline">{{ row.code }}</Link>
                                <template v-else>{{ cell(row, c) }}</template>
                            </td>
                        </tr>
                        <tr v-if="(key === 'table' ? tableRows : table.rows).length === 0">
                            <td :colspan="table.columns.length" class="py-6 text-center text-slate-500">{{ t('reports.no_data') }}</td>
                        </tr>
                    </tbody>
                </table>
                <Pagination v-if="key === 'table' && data.paginator" :paginator="data.paginator" />
            </div>
        </div>
    </div>
</template>
