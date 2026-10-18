<script setup>
import { reactive, ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import FormField from '../../Components/FormField.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ applications: Array, filters: Object, reasons: Array, canEdit: Boolean });
const { t } = useTranslation();

const filter = reactive({ code: props.filters.code ?? '', explained: props.filters.explained ?? '' });
const apply = () => router.get(route('change-decrease.index'), Object.fromEntries(Object.entries(filter).filter(([, v]) => v)), { preserveState: true, replace: true });

const editing = ref(null);
const form = useForm({ reasons: [], details: '' });
const open = (a) => {
    editing.value = a.id;
    form.reasons = [...a.reasons];
    form.details = a.details ?? '';
};
const save = () => form.put(route('change-decrease.update', editing.value), { preserveScroll: true, onSuccess: () => (editing.value = null) });
const clear = (a) => {
    form.reasons = [];
    form.details = '';
    form.put(route('change-decrease.update', a.id), { preserveScroll: true });
};
</script>

<template>
    <Head :title="t('ui.change_decrease')" />
    <PageHeader :title="t('ui.change_decrease')" :subtitle="t('ui.decrease_reason_help')" />

    <form class="card mb-4 flex flex-wrap gap-3 p-4" @submit.prevent="apply">
        <input v-model="filter.code" class="input w-56" :placeholder="t('ui.code')" />
        <select v-model="filter.explained" class="input w-48">
            <option value="">{{ t('ui.all') }}</option>
            <option value="yes">{{ t('ui.explained') }}</option>
            <option value="no">{{ t('ui.not_explained') }}</option>
        </select>
        <button class="btn-primary">{{ t('ui.filter') }}</button>
    </form>

    <div class="card overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ t('ui.code') }}</th>
                    <th>{{ t('ui.partner') }}</th>
                    <th>{{ t('ui.collector') }}</th>
                    <th>{{ t('ui.post_test_date') }}</th>
                    <th class="text-end">{{ t('ui.pre_test_score') }}</th>
                    <th class="text-end">{{ t('ui.post_test_score') }}</th>
                    <th>{{ t('ui.decrease_reason') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <template v-for="a in applications" :key="a.id">
                    <tr>
                        <td><Link :href="route('applications.show', a.id)" class="font-mono text-xs font-semibold text-brand-700 hover:underline">{{ a.code }}</Link></td>
                        <td>{{ a.partner }}</td>
                        <td>{{ a.collector }}</td>
                        <td>{{ a.post_test_date }}</td>
                        <td class="text-end">{{ a.pre_test_score }}</td>
                        <td class="text-end text-red-700">{{ a.post_test_score }}</td>
                        <td class="max-w-md">
                            <span v-if="a.reasons.length" class="badge bg-green-100 text-green-800">✓ {{ t('ui.explained') }}</span>
                            <span v-else class="badge bg-amber-100 text-amber-800">{{ t('ui.not_explained') }}</span>
                            <div v-if="a.reasons.length" class="mt-1 text-xs text-slate-600">{{ a.reasons.join(' · ') }}<br />{{ a.details }}</div>
                        </td>
                        <td class="text-end whitespace-nowrap">
                            <template v-if="canEdit">
                                <button class="btn-secondary btn-sm" @click="open(a)">{{ t('ui.edit') }}</button>
                                <button v-if="a.reasons.length" class="btn-secondary btn-sm ms-1" @click="clear(a)">{{ t('ui.reset') }}</button>
                            </template>
                        </td>
                    </tr>
                    <tr v-if="editing === a.id" class="bg-brand-50">
                        <td colspan="8" class="p-4">
                            <form class="grid gap-4 md:grid-cols-2" @submit.prevent="save">
                                <FormField :label="t('ui.decrease_reason')" :error="form.errors.reasons" :help="t('ui.decrease_reason_help')">
                                    <label v-for="r in reasons" :key="r" class="flex items-center gap-2 text-sm">
                                        <input v-model="form.reasons" type="checkbox" :value="r" :disabled="form.reasons.length >= 2 && !form.reasons.includes(r)" /> {{ r }}
                                    </label>
                                </FormField>
                                <FormField :label="t('ui.details')" :error="form.errors.details" required>
                                    <textarea v-model="form.details" class="input" rows="4" required></textarea>
                                </FormField>
                                <div class="flex gap-2 md:col-span-2">
                                    <button class="btn-primary" :disabled="form.processing">{{ t('ui.submit') }}</button>
                                    <button type="button" class="btn-secondary" @click="editing = null">{{ t('ui.cancel') }}</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                </template>
                <tr v-if="applications.length === 0">
                    <td colspan="8" class="py-8 text-center text-slate-500">{{ t('ui.no_results') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
