<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import FormField from '../../Components/FormField.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ partner: Object });
const { t } = useTranslation();
const p = props.partner;

const form = useForm({
    _method: p ? 'PUT' : 'POST',
    name: p?.name ?? '',
    prefix: p?.prefix ?? '',
    firstname: p?.firstname ?? '',
    lastname: p?.lastname ?? '',
    email: p?.email ?? '',
    phone: p?.phone ?? '',
    address: p?.address ?? '',
    max_app_per_year: p?.max_app_per_year ?? 240,
    logo: null,
});
const submit = () => form.post(p ? route('partners.update', p.id) : route('partners.store'), { forceFormData: true });
</script>

<template>
    <Head :title="t('ui.partner')" />
    <PageHeader :title="p ? `${t('ui.edit')}: ${p.name}` : `${t('ui.add')} ${t('ui.partner')}`">
        <Link :href="route('partners.index')" class="btn-secondary">{{ t('ui.back') }}</Link>
    </PageHeader>

    <form class="card max-w-3xl" @submit.prevent="submit">
        <div class="card-body grid gap-4 md:grid-cols-2">
            <FormField :label="t('ui.name')" :error="form.errors.name" required><input v-model="form.name" class="input" required /></FormField>
            <FormField :label="t('ui.prefix')" :error="form.errors.prefix" :help="t('ui.prefix_help')" required>
                <input v-model="form.prefix" class="input uppercase" maxlength="10" required />
            </FormField>
            <FormField :label="t('ui.first_name')" :error="form.errors.firstname" required><input v-model="form.firstname" class="input" required /></FormField>
            <FormField :label="t('ui.last_name')" :error="form.errors.lastname" required><input v-model="form.lastname" class="input" required /></FormField>
            <FormField :label="t('ui.email')" :error="form.errors.email" :help="p ? null : t('ui.invite_sent_help')" required><input v-model="form.email" type="email" class="input" required /></FormField>
            <FormField :label="t('ui.phone')" :error="form.errors.phone"><input v-model="form.phone" class="input" /></FormField>
            <FormField :label="t('ui.address')" :error="form.errors.address"><input v-model="form.address" class="input" /></FormField>
            <FormField :label="t('ui.max_codes_per_year')" :error="form.errors.max_app_per_year" required><input v-model="form.max_app_per_year" type="number" min="0" class="input" required /></FormField>
            <FormField :label="t('ui.logo')" :error="form.errors.logo">
                <input type="file" accept="image/*" class="input" @input="form.logo = $event.target.files[0]" />
                <img v-if="p?.logo" :src="p.logo" alt="" class="mt-2 h-12 rounded" />
            </FormField>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-200 p-4">
            <Link :href="route('partners.index')" class="btn-secondary">{{ t('ui.cancel') }}</Link>
            <button class="btn-primary" :disabled="form.processing">{{ t('ui.save') }}</button>
        </div>
    </form>
</template>
