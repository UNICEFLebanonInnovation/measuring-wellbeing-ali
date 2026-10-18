<script setup>
import { ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import StatusBadge from '../../Components/StatusBadge.vue';
import ConfirmButton from '../../Components/ConfirmButton.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ application: Object, collectors: Array, can: Object });
const { t } = useTranslation();

const transfer = useForm({ collector_id: props.application.collector_id ?? '' });
const showTransfer = ref(false);
const doTransfer = () => transfer.put(route('applications.transfer', props.application.id), { onSuccess: () => (showTransfer.value = false) });
const destroy = () => router.delete(route('applications.destroy', props.application.id));

const scales = ['emotional_scale', 'conduct_scale', 'hyper_activity_scale', 'peer_problem_scale', 'pro_social_scale'];
const answerLabel = (v) => {
    if (v === null || v === undefined || v === '') return '—';
    return { 0: t('ui.answer_not_true'), 1: t('ui.answer_somewhat_true'), 2: t('ui.answer_certainly_true'), na: t('ui.answer_na') }[v] ?? v;
};
const detailFields = ['category', 'form', 'agency_name', 'donor_name', 'interview_date', 'interviewers_name', 'age', 'gender', 'nationality', 'other_nationality', 'gateway_type', 'p_code', 'child_code', 'latitude', 'longitude', 'altitude', 'accuracy', 'may_i_start_now', 'comment'];
const programmeFields = ['number_of_hours_that_the_child_attended', 'total_number_of_hours_in_your_program', 'dropout_reason', 'justify_the_dropout_reason', 'do_the_child_receive_any_other_child_protection_services'];
</script>

<template>
    <Head :title="`${t('ui.application')} ${application.code}`" />
    <PageHeader :title="application.code" :subtitle="`${application.partner ?? ''} · ${application.collector ?? ''}`">
        <StatusBadge :status="application.status" />
        <Link v-if="can.preTest" :href="route('applications.pre-test', application.id)" class="btn-primary">{{ t('ui.pre_test') }}</Link>
        <Link v-if="can.postTest" :href="route('applications.post-test', application.id)" class="btn-primary">{{ t('ui.post_test') }}</Link>
        <button v-if="can.transfer && collectors.length" class="btn-secondary" @click="showTransfer = !showTransfer">{{ t('ui.transfer_to_collector') }}</button>
        <ConfirmButton v-if="can.delete" class="btn-danger" @confirm="destroy">{{ t('ui.delete') }}</ConfirmButton>
        <Link :href="route('applications.index')" class="btn-secondary">{{ t('ui.back') }}</Link>
    </PageHeader>

    <form v-if="showTransfer" class="card mb-4 flex flex-wrap items-end gap-3 p-4" @submit.prevent="doTransfer">
        <div class="min-w-64">
            <label class="label">{{ t('ui.collector') }}</label>
            <select v-model="transfer.collector_id" class="input" required>
                <option v-for="c in collectors" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
        </div>
        <button class="btn-primary" :disabled="transfer.processing">{{ t('ui.save') }}</button>
    </form>

    <div class="grid gap-4 lg:grid-cols-3">
        <!-- Summary -->
        <div class="card lg:col-span-3">
            <div class="card-header"><h2 class="font-semibold">{{ t('ui.overview') }}</h2></div>
            <div class="card-body grid grid-cols-2 gap-4 text-sm md:grid-cols-4 lg:grid-cols-6">
                <div><div class="text-xs text-slate-500">{{ t('ui.pre_test_date') }}</div><div>{{ application.pre_test_date ?? '—' }}</div></div>
                <div><div class="text-xs text-slate-500">{{ t('ui.post_test_date') }}</div><div>{{ application.post_test_date ?? '—' }}</div></div>
                <div><div class="text-xs text-slate-500">{{ t('ui.pre_test_score') }}</div><div class="text-lg font-semibold">{{ application.pre_test_score ?? '—' }}</div></div>
                <div><div class="text-xs text-slate-500">{{ t('ui.post_test_score') }}</div><div class="text-lg font-semibold">{{ application.post_test_score ?? '—' }}</div></div>
                <div>
                    <div class="text-xs text-slate-500">{{ t('ui.change') }}</div>
                    <div class="font-semibold" :class="application.change === 'Increase' ? 'text-green-700' : application.change === 'Decrease' ? 'text-red-700' : ''">
                        {{ application.change ? t(`ui.${application.change.toLowerCase()}`) : '—' }}
                    </div>
                </div>
                <div><div class="text-xs text-slate-500">{{ t('ui.governorate') }}</div><div>{{ application.locations.governorate ?? '—' }} <span class="text-slate-400">{{ application.locations.caza }} {{ application.locations.area }}</span></div></div>
            </div>
            <div v-if="application.reason_option" class="border-t border-slate-200 px-4 py-3 text-sm">
                <span class="font-medium">{{ t('ui.decrease_reason') }}:</span> {{ application.reason_option }}
                <p class="text-slate-600">{{ application.reason_details }}</p>
            </div>
        </div>

        <!-- Scores -->
        <div v-for="type in ['pre_test', 'post_test']" :key="type" class="card">
            <div class="card-header"><h2 class="font-semibold">{{ t(`ui.${type}`) }} · {{ t('ui.scores') }}</h2></div>
            <div v-if="application[type]" class="card-body text-sm">
                <table class="w-full">
                    <tbody>
                        <tr v-for="s in scales" :key="s" class="border-b border-slate-100">
                            <td class="py-1">{{ t(`ui.${s}`) }}</td>
                            <td class="py-1 text-end font-mono">{{ application[type][s] ?? '—' }}</td>
                        </tr>
                        <tr class="font-semibold">
                            <td class="py-1">{{ t('ui.total_score') }}</td>
                            <td class="py-1 text-end font-mono">{{ application[type].score ?? '—' }}</td>
                        </tr>
                        <tr class="text-slate-500">
                            <td class="py-1">{{ t('ui.na_count') }}</td>
                            <td class="py-1 text-end font-mono">{{ application[type].na_count ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="card-body text-sm text-slate-500">—</div>
        </div>

        <!-- History -->
        <div class="card">
            <div class="card-header"><h2 class="font-semibold">{{ t('ui.history') }}</h2></div>
            <ul class="card-body max-h-72 space-y-2 overflow-y-auto text-xs">
                <li v-for="log in application.logs" :key="log.id" class="border-b border-slate-100 pb-1">
                    <div>{{ log.text }}</div>
                    <div class="text-slate-400">{{ log.at }}</div>
                </li>
                <li v-if="!application.logs.length" class="text-slate-500">—</li>
            </ul>
        </div>

        <!-- Details per test -->
        <div v-for="type in ['pre_test', 'post_test']" :key="`d-${type}`" class="card lg:col-span-3">
            <div class="card-header"><h2 class="font-semibold">{{ t(`ui.${type}`) }} · {{ t('ui.details') }}</h2></div>
            <div v-if="application[type]" class="card-body">
                <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm md:grid-cols-4">
                    <template v-for="f in [...detailFields, ...(type === 'post_test' ? programmeFields : [])]" :key="f">
                        <div v-if="application[type][f] !== null && application[type][f] !== undefined && application[type][f] !== ''">
                            <dt class="text-xs text-slate-500">{{ t(`messages.${f}`) }}</dt>
                            <dd>{{ application[type][f] }}</dd>
                        </div>
                    </template>
                </dl>
                <h3 class="mt-4 mb-2 text-sm font-semibold">{{ t('ui.questionnaire') }}</h3>
                <table class="table">
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="(item, i) in $page.props.options.items" :key="item">
                            <td class="w-8 text-slate-400">{{ i + 1 }}</td>
                            <td>{{ t(`messages.${item}`) }}</td>
                            <td class="text-end">{{ answerLabel(application[type][item]) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="card-body text-sm text-slate-500">—</div>
        </div>
    </div>
</template>
