<script setup>
import { computed, ref, watch } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import FormField from '../../Components/FormField.vue';
import StatusBadge from '../../Components/StatusBadge.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({
    application: Object,
    type: String, // pre_test | post_test
    values: Object,
    preTestSummary: Object,
    governorates: Array,
    agency: String,
    interviewer: String,
});
const { t, locale } = useTranslation();
const page = usePage();
const options = computed(() => page.props.options);
const items = computed(() => options.value?.items ?? []);

const isPost = computed(() => props.type === 'post_test');
const v = props.values ?? {};

const form = useForm({
    form: v.form ?? 'Form 6-11',
    may_i_start_now: v.may_i_start_now ?? 'yes',
    category: v.category ?? '',
    agency_name: v.agency_name ?? props.agency ?? '',
    donor_name: v.donor_name ?? '',
    interview_date: v.interview_date ?? new Date().toISOString().slice(0, 10),
    interviewers_name: v.interviewers_name ?? props.interviewer ?? '',
    age: v.age ?? '',
    gender: v.gender ?? '',
    nationality: v.nationality ?? '',
    other_nationality: v.other_nationality ?? '',
    gouvarnate: v.gouvarnate ?? '',
    caza: v.caza ?? '',
    area: v.area ?? '',
    gateway_type: v.gateway_type ?? '',
    p_code: v.p_code ?? '',
    child_code: v.child_code ?? '',
    latitude: v.latitude ?? '',
    longitude: v.longitude ?? '',
    altitude: v.altitude ?? '',
    accuracy: v.accuracy ?? '',
    comment: v.comment ?? '',
    do_the_child_receive_any_other_child_protection_services: v.do_the_child_receive_any_other_child_protection_services
        ? String(v.do_the_child_receive_any_other_child_protection_services).split(',').map((s) => s.trim()).filter(Boolean)
        : [],
    number_of_hours_that_the_child_attended: v.number_of_hours_that_the_child_attended ?? '',
    total_number_of_hours_in_your_program: v.total_number_of_hours_in_your_program ?? '',
    dropout_reason: v.dropout_reason ?? 'Did Not Drop Out',
    justify_the_dropout_reason: v.justify_the_dropout_reason ?? '',
    ...Object.fromEntries(items.value.map((i) => [i, v[i] ?? ''])),
});

// Cascading locations
const locName = (g) => (locale.value === 'ar' && g.arabic ? g.arabic : g.name);
const cazas = computed(() => props.governorates.find((g) => String(g.id) === String(form.gouvarnate))?.cazas ?? []);
const areas = ref([]);
const loadAreas = async (keepValue = false) => {
    areas.value = [];
    if (!form.caza) return;
    const res = await fetch(route('lookup.areas', form.caza), { headers: { Accept: 'application/json' } });
    areas.value = await res.json();
    if (!keepValue) form.area = '';
};
watch(() => form.gouvarnate, (n, o) => { if (o !== undefined && n !== o) { form.caza = ''; form.area = ''; areas.value = []; } });
watch(() => form.caza, (n, o) => { if (o !== undefined && n !== o) loadAreas(); });
if (form.caza) loadAreas(true);

const ageRange = computed(() => (form.form === 'Form 6-11' ? [6, 11] : [12, 17]));
const consentGiven = computed(() => form.may_i_start_now === 'yes');
const answers = [
    { value: '0', label: 'ui.answer_not_true' },
    { value: '1', label: 'ui.answer_somewhat_true' },
    { value: '2', label: 'ui.answer_certainly_true' },
    { value: 'na', label: 'ui.answer_na' },
];
const answered = computed(() => items.value.filter((i) => form[i] !== '' && form[i] !== null).length);
const naCount = computed(() => items.value.filter((i) => form[i] === 'na').length);

const save = (mode) => {
    form.transform((data) => ({ ...data, submit: mode })).put(
        route(isPost.value ? 'applications.post-test.update' : 'applications.pre-test.update', props.application.id),
        { preserveScroll: true },
    );
};
</script>

<template>
    <Head :title="`${t(`ui.${type}`)} · ${application.code}`" />
    <PageHeader :title="`${t(`ui.${type}`)} — ${application.code}`" :subtitle="`${application.partner ?? ''} · ${application.collector ?? ''}`">
        <StatusBadge :status="application.status" />
        <Link :href="route('applications.show', application.id)" class="btn-secondary">{{ t('ui.back') }}</Link>
    </PageHeader>

    <div v-if="preTestSummary" class="mb-4 rounded-md border border-brand-200 bg-brand-50 px-4 py-2 text-sm text-brand-800">
        {{ t('ui.pre_test') }}: {{ preTestSummary.interview_date }} · {{ t('ui.total_score') }}: {{ preTestSummary.score }}
    </div>

    <form class="space-y-4" @submit.prevent="save('submit')">
        <!-- Consent + form -->
        <div class="card">
            <div class="card-header"><h2 class="font-semibold">{{ t('messages.may_i_start_now') }}</h2></div>
            <div class="card-body grid gap-4 md:grid-cols-3">
                <FormField :label="t('messages.Form')" :error="form.errors.form" required>
                    <select v-model="form.form" class="input" :disabled="isPost">
                        <option v-for="f in options.forms" :key="f" :value="f">{{ f }}</option>
                    </select>
                </FormField>
                <FormField :label="t('messages.may_i_start_now')" :error="form.errors.may_i_start_now" :help="consentGiven ? t('ui.consent_help') : t('ui.consent_refused_help')" required>
                    <select v-model="form.may_i_start_now" class="input">
                        <option value="yes">{{ t('ui.yes') }}</option>
                        <option value="no">{{ t('ui.no') }}</option>
                    </select>
                </FormField>
            </div>
        </div>

        <template v-if="consentGiven">
            <!-- Child and interview -->
            <div class="card">
                <div class="card-header"><h2 class="font-semibold">{{ t('ui.child_details') }}</h2></div>
                <div class="card-body grid gap-4 md:grid-cols-3">
                    <FormField :label="t('messages.category')" :error="form.errors.category" required>
                        <select v-model="form.category" class="input"><option value="">—</option><option v-for="o in options.categories" :key="o" :value="o">{{ o }}</option></select>
                    </FormField>
                    <FormField :label="t('messages.agency_name')" :error="form.errors.agency_name" required>
                        <input v-model="form.agency_name" class="input" maxlength="50" />
                    </FormField>
                    <FormField :label="t('messages.donor_name')" :error="form.errors.donor_name" required>
                        <select v-model="form.donor_name" class="input"><option value="">—</option><option v-for="o in options.donors" :key="o" :value="o">{{ o }}</option></select>
                    </FormField>
                    <FormField :label="t('messages.interview_date')" :error="form.errors.interview_date" required>
                        <input v-model="form.interview_date" type="date" class="input" />
                    </FormField>
                    <FormField :label="t('messages.interviewrs_name')" :error="form.errors.interviewers_name" required>
                        <input v-model="form.interviewers_name" class="input" maxlength="50" />
                    </FormField>
                    <FormField :label="t('messages.code')" :error="form.errors.child_code">
                        <input v-model="form.child_code" class="input" maxlength="50" />
                    </FormField>
                    <FormField :label="`${t('messages.age')} (${ageRange[0]}–${ageRange[1]})`" :error="form.errors.age" required>
                        <input v-model="form.age" type="number" :min="ageRange[0]" :max="ageRange[1]" class="input" />
                    </FormField>
                    <FormField :label="t('messages.gender')" :error="form.errors.gender" required>
                        <select v-model="form.gender" class="input"><option value="">—</option><option v-for="o in options.genders" :key="o" :value="o">{{ o }}</option></select>
                    </FormField>
                    <FormField :label="t('messages.nationality')" :error="form.errors.nationality" required>
                        <select v-model="form.nationality" class="input"><option value="">—</option><option v-for="o in options.nationalities" :key="o" :value="o">{{ o }}</option></select>
                    </FormField>
                    <FormField v-if="form.nationality === 'Other Nationality'" :label="t('messages.nationality')" :error="form.errors.other_nationality" required>
                        <input v-model="form.other_nationality" class="input" maxlength="100" />
                    </FormField>
                    <FormField :label="t('messages.gouvarnate')" :error="form.errors.gouvarnate" required>
                        <select v-model="form.gouvarnate" class="input"><option value="">—</option><option v-for="g in governorates" :key="g.id" :value="String(g.id)">{{ locName(g) }}</option></select>
                    </FormField>
                    <FormField :label="t('messages.caza')" :error="form.errors.caza" required>
                        <select v-model="form.caza" class="input" :disabled="!form.gouvarnate"><option value="">—</option><option v-for="c in cazas" :key="c.id" :value="String(c.id)">{{ locName(c) }}</option></select>
                    </FormField>
                    <FormField :label="t('messages.area')" :error="form.errors.area" required>
                        <select v-model="form.area" class="input" :disabled="!form.caza"><option value="">—</option><option v-for="a in areas" :key="a.id" :value="String(a.id)">{{ locName(a) }}</option></select>
                    </FormField>
                    <FormField :label="t('messages.gateway_type')" :error="form.errors.gateway_type" required>
                        <select v-model="form.gateway_type" class="input"><option value="">—</option><option v-for="o in options.gateway_types" :key="o" :value="o">{{ o }}</option></select>
                    </FormField>
                    <FormField :label="t('messages.p_code')" :error="form.errors.p_code"><input v-model="form.p_code" class="input" maxlength="50" /></FormField>
                    <FormField :label="t('messages.latitude')" :error="form.errors.latitude"><input v-model="form.latitude" type="number" step="any" class="input" /></FormField>
                    <FormField :label="t('messages.longitude')" :error="form.errors.longitude"><input v-model="form.longitude" type="number" step="any" class="input" /></FormField>
                    <FormField :label="t('messages.altitude')" :error="form.errors.altitude"><input v-model="form.altitude" type="number" step="any" class="input" /></FormField>
                    <FormField :label="t('messages.accuracy')" :error="form.errors.accuracy"><input v-model="form.accuracy" type="number" step="any" class="input" /></FormField>
                </div>
            </div>

            <!-- Questionnaire -->
            <div class="card">
                <div class="card-header">
                    <h2 class="font-semibold">{{ t('ui.questionnaire') }}</h2>
                    <span class="text-xs text-slate-500">{{ answered }}/{{ items.length }} · {{ t('ui.na_count') }}: {{ naCount }}</span>
                </div>
                <div class="divide-y divide-slate-100">
                    <div v-for="(item, i) in items" :key="item" class="grid gap-2 px-4 py-3 md:grid-cols-2" :class="{ 'bg-red-50': form.errors[item] }">
                        <div class="text-sm"><span class="me-2 text-slate-400">{{ i + 1 }}.</span>{{ t(`messages.${item}`) }}</div>
                        <div class="flex flex-wrap gap-3 text-sm">
                            <label v-for="a in answers" :key="a.value" class="flex items-center gap-1">
                                <input v-model="form[item]" type="radio" :name="item" :value="a.value" />
                                {{ t(a.label) }}
                            </label>
                        </div>
                        <p v-if="form.errors[item]" class="error md:col-span-2">{{ form.errors[item] }}</p>
                    </div>
                </div>
            </div>

            <!-- Programme / dropout (post-test only) -->
            <div v-if="isPost" class="card">
                <div class="card-header"><h2 class="font-semibold">{{ t('ui.programme_details') }}</h2></div>
                <div class="card-body grid gap-4 md:grid-cols-3">
                    <FormField :label="t('messages.number_of_hours_that_the_child_attended')" :error="form.errors.number_of_hours_that_the_child_attended" required>
                        <input v-model="form.number_of_hours_that_the_child_attended" type="number" min="0" step="0.5" class="input" />
                    </FormField>
                    <FormField :label="t('messages.total_number_of_hours_in_your_program')" :error="form.errors.total_number_of_hours_in_your_program" required>
                        <input v-model="form.total_number_of_hours_in_your_program" type="number" min="0" step="0.5" class="input" />
                    </FormField>
                    <FormField :label="t('messages.dropout_reason')" :error="form.errors.dropout_reason" required>
                        <select v-model="form.dropout_reason" class="input"><option v-for="o in options.dropout_reasons" :key="o" :value="o">{{ o }}</option></select>
                    </FormField>
                    <FormField v-if="form.dropout_reason !== 'Did Not Drop Out'" :label="t('messages.justify_the_dropout_reason')" :error="form.errors.justify_the_dropout_reason">
                        <input v-model="form.justify_the_dropout_reason" class="input" maxlength="255" />
                    </FormField>
                </div>
            </div>

            <div class="card">
                <div class="card-body grid gap-4 md:grid-cols-2">
                    <FormField :label="t('messages.do_the_child_receive_any_other_child_protection_services')" :error="form.errors.do_the_child_receive_any_other_child_protection_services">
                        <label v-for="s in options.services" :key="s" class="flex items-center gap-2 text-sm">
                            <input v-model="form.do_the_child_receive_any_other_child_protection_services" type="checkbox" :value="s" /> {{ s }}
                        </label>
                    </FormField>
                    <FormField :label="t('messages.comment')" :error="form.errors.comment">
                        <textarea v-model="form.comment" class="input" rows="4" maxlength="2000"></textarea>
                    </FormField>
                </div>
            </div>
        </template>

        <div class="sticky bottom-0 flex flex-wrap justify-end gap-2 border-t border-slate-200 bg-white/90 p-3 backdrop-blur">
            <Link :href="route('applications.show', application.id)" class="btn-secondary">{{ t('ui.cancel') }}</Link>
            <button v-if="consentGiven" type="button" class="btn-secondary" :disabled="form.processing" @click="save('save')">{{ t('ui.save_draft') }}</button>
            <button type="submit" class="btn-primary" :disabled="form.processing">{{ t('ui.submit') }}</button>
        </div>
    </form>
</template>
