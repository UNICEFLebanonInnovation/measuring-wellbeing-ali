<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import FormField from '../../Components/FormField.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ token: String, email: String });
defineOptions({ layout: GuestLayout });
const { t } = useTranslation();
const form = useForm({ token: props.token, email: props.email ?? '', password: '', password_confirmation: '' });
</script>

<template>
    <Head :title="t('ui.reset_password')" />
    <h2 class="mb-4 text-lg font-semibold">{{ t('ui.reset_password') }}</h2>
    <form class="space-y-4" @submit.prevent="form.post(route('password.update'))">
        <FormField :label="t('ui.email')" :error="form.errors.email" required>
            <input v-model="form.email" type="email" class="input" required />
        </FormField>
        <FormField :label="t('ui.password')" :error="form.errors.password" required>
            <input v-model="form.password" type="password" class="input" autocomplete="new-password" required />
        </FormField>
        <FormField :label="t('ui.password_confirmation')" required>
            <input v-model="form.password_confirmation" type="password" class="input" autocomplete="new-password" required />
        </FormField>
        <button type="submit" class="btn-primary w-full" :disabled="form.processing">{{ t('ui.reset_password') }}</button>
    </form>
</template>
