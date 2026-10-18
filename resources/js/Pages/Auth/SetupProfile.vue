<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import FormField from '../../Components/FormField.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ token: String, email: String, name: String, role: String });
defineOptions({ layout: GuestLayout });
const { t } = useTranslation();
const form = useForm({ email: props.email, password: '', password_confirmation: '', agree: false });
</script>

<template>
    <Head :title="t('ui.setup_profile')" />
    <h2 class="mb-1 text-lg font-semibold">{{ t('ui.setup_profile') }}</h2>
    <p class="mb-4 text-sm text-slate-500">{{ name }} · {{ role }} · {{ email }}</p>
    <p class="mb-4 text-sm text-slate-500">{{ t('ui.setup_profile_help') }}</p>
    <form class="space-y-4" @submit.prevent="form.post(route('profile.setup.store', token))">
        <FormField :label="t('ui.password')" :error="form.errors.password" required>
            <input v-model="form.password" type="password" class="input" autocomplete="new-password" required autofocus />
        </FormField>
        <FormField :label="t('ui.password_confirmation')" required>
            <input v-model="form.password_confirmation" type="password" class="input" autocomplete="new-password" required />
        </FormField>
        <label class="flex items-start gap-2 text-sm">
            <input v-model="form.agree" type="checkbox" class="mt-1 rounded" required />
            <span>{{ t('ui.agree_terms') }}</span>
        </label>
        <p v-if="form.errors.agree" class="error">{{ form.errors.agree }}</p>
        <button type="submit" class="btn-primary w-full" :disabled="form.processing">{{ t('ui.save') }}</button>
    </form>
</template>
