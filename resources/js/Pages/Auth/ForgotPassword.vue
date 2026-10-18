<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import FormField from '../../Components/FormField.vue';
import { useTranslation } from '../../i18n';

defineOptions({ layout: GuestLayout });
const { t } = useTranslation();
const form = useForm({ email: '' });
</script>

<template>
    <Head :title="t('ui.forgot_password')" />
    <h2 class="mb-1 text-lg font-semibold">{{ t('ui.reset_password') }}</h2>
    <p class="mb-4 text-sm text-slate-500">{{ t('ui.forgot_password_help') }}</p>
    <form class="space-y-4" @submit.prevent="form.post(route('password.email'))">
        <FormField :label="t('ui.email')" :error="form.errors.email" required>
            <input v-model="form.email" type="email" class="input" required autofocus />
        </FormField>
        <button type="submit" class="btn-primary w-full" :disabled="form.processing">{{ t('ui.send_reset_link') }}</button>
        <Link :href="route('login')" class="block text-center text-sm text-brand-600 hover:underline">{{ t('ui.back_to_login') }}</Link>
    </form>
</template>
