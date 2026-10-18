<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import FormField from '../../Components/FormField.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ collector: Object });
const { t } = useTranslation();
const c = props.collector;

const form = useForm({
    firstname: c?.firstname ?? '',
    lastname: c?.lastname ?? '',
    email: c?.email ?? '',
    phone: c?.phone ?? '',
    prefix: c?.prefix ?? '',
    city: c?.city ?? '',
    is_subpartner: c?.is_subpartner ?? false,
    sub_partner: c?.sub_partner ?? '',
});
const submit = () => (c ? form.put(route('collectors.update', c.id)) : form.post(route('collectors.store')));
</script>

<template>
    <Head :title="t('ui.collector')" />
    <PageHeader :title="c ? `${t('ui.edit')}: ${c.firstname} ${c.lastname}` : `${t('ui.add')} ${t('ui.collector')}`">
        <Link :href="route('collectors.index')" class="btn-secondary">{{ t('ui.back') }}</Link>
    </PageHeader>

    <form class="card max-w-3xl" @submit.prevent="submit">
        <div class="card-body grid gap-4 md:grid-cols-2">
            <FormField :label="t('ui.first_name')" :error="form.errors.firstname" required><input v-model="form.firstname" class="input" required /></FormField>
            <FormField :label="t('ui.last_name')" :error="form.errors.lastname" required><input v-model="form.lastname" class="input" required /></FormField>
            <FormField :label="t('ui.email')" :error="form.errors.email" :help="c ? null : t('ui.invite_sent_help')" required><input v-model="form.email" type="email" class="input" required /></FormField>
            <FormField :label="t('ui.phone')" :error="form.errors.phone"><input v-model="form.phone" class="input" /></FormField>
            <FormField :label="t('ui.prefix')" :error="form.errors.prefix" :help="t('ui.prefix_help')" required><input v-model="form.prefix" class="input uppercase" maxlength="10" required /></FormField>
            <FormField :label="t('ui.city')" :error="form.errors.city"><input v-model="form.city" class="input" /></FormField>
            <FormField :label="t('ui.is_sub_partner')" :error="form.errors.is_subpartner">
                <label class="flex items-center gap-2 text-sm"><input v-model="form.is_subpartner" type="checkbox" /> {{ t('ui.yes') }}</label>
            </FormField>
            <FormField v-if="form.is_subpartner" :label="t('ui.sub_partner')" :error="form.errors.sub_partner" required><input v-model="form.sub_partner" class="input" maxlength="50" /></FormField>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-200 p-4">
            <Link :href="route('collectors.index')" class="btn-secondary">{{ t('ui.cancel') }}</Link>
            <button class="btn-primary" :disabled="form.processing">{{ t('ui.save') }}</button>
        </div>
    </form>
</template>
