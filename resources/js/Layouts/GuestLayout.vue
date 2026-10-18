<script setup>
import { router } from '@inertiajs/vue3';
import { useTranslation } from '../i18n';
import FlashMessages from '../Components/FlashMessages.vue';

const { t, locale, dir } = useTranslation();
const switchLocale = (value) => router.get(route('locale.switch', value), {}, { preserveScroll: true });
</script>

<template>
    <div :dir="dir" class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-brand-50 to-slate-100 p-4">
        <div class="w-full max-w-md">
            <div class="mb-6 flex flex-col items-center gap-2">
                <img src="/images/logo.png" alt="" class="h-24 w-auto" />
                <h1 class="text-xl font-semibold text-brand-700">{{ t('ui.app_name') }}</h1>
            </div>
            <div class="card p-6">
                <FlashMessages />
                <slot />
            </div>
            <div class="mt-4 text-center text-xs text-slate-500">
                <button v-for="(label, code) in $page.props.locales" :key="code" class="mx-1 underline-offset-2 hover:underline" :class="{ 'font-semibold text-brand-700': code === locale }" @click="switchLocale(code)">
                    {{ label }}
                </button>
            </div>
        </div>
    </div>
</template>
