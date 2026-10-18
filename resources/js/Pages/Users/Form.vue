<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import FormField from '../../Components/FormField.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ user: Object });
const { t } = useTranslation();
const u = props.user;
const form = useForm({ firstname: u?.firstname ?? '', lastname: u?.lastname ?? '', email: u?.email ?? '', phone: u?.phone ?? '' });
const submit = () => (u ? form.put(route('users.update', u.id)) : form.post(route('users.store')));
</script>

<template>
    <Head :title="t('ui.admins')" />
    <PageHeader :title="u ? `${t('ui.edit')}: ${u.firstname} ${u.lastname}` : `${t('ui.add')} ${t('ui.admins')}`">
        <Link :href="route('users.index')" class="btn-secondary">{{ t('ui.back') }}</Link>
    </PageHeader>
    <form class="card max-w-2xl" @submit.prevent="submit">
        <div class="card-body grid gap-4 md:grid-cols-2">
            <FormField :label="t('ui.first_name')" :error="form.errors.firstname" required><input v-model="form.firstname" class="input" required /></FormField>
            <FormField :label="t('ui.last_name')" :error="form.errors.lastname" required><input v-model="form.lastname" class="input" required /></FormField>
            <FormField :label="t('ui.email')" :error="form.errors.email" :help="u ? null : t('ui.invite_sent_help')" required><input v-model="form.email" type="email" class="input" required /></FormField>
            <FormField :label="t('ui.phone')" :error="form.errors.phone"><input v-model="form.phone" class="input" /></FormField>
        </div>
        <div class="flex justify-end gap-2 border-t border-slate-200 p-4">
            <Link :href="route('users.index')" class="btn-secondary">{{ t('ui.cancel') }}</Link>
            <button class="btn-primary" :disabled="form.processing">{{ t('ui.save') }}</button>
        </div>
    </form>
</template>
