<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import FormField from '../../Components/FormField.vue';
import { useTranslation } from '../../i18n';

defineOptions({ layout: GuestLayout });
const { t } = useTranslation();

const form = useForm({ email: '', password: '', remember: false });
const submit = () => form.post(route('login.store'), { onFinish: () => form.reset('password') });
</script>

<template>
    <Head :title="t('ui.sign_in')" />
    <h2 class="mb-4 text-lg font-semibold">{{ t('ui.sign_in_title') }}</h2>
    <form class="space-y-4" @submit.prevent="submit">
        <FormField :label="t('ui.email')" :error="form.errors.email" required>
            <input v-model="form.email" type="email" class="input" autocomplete="username" required autofocus />
        </FormField>
        <FormField :label="t('ui.password')" :error="form.errors.password" required>
            <input v-model="form.password" type="password" class="input" autocomplete="current-password" required />
        </FormField>
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2"><input v-model="form.remember" type="checkbox" class="rounded" /> {{ t('ui.remember_me') }}</label>
            <Link :href="route('password.request')" class="text-brand-600 hover:underline">{{ t('ui.forgot_password') }}</Link>
        </div>
        <button type="submit" class="btn-primary w-full" :disabled="form.processing">{{ t('ui.sign_in') }}</button>
    </form>
</template>
