<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import { useTranslation } from '../../i18n';

defineProps({ admins: Array });
const { t } = useTranslation();
const flag = (u, key, value) => router.patch(route('users.flags', u.id), { [key]: value }, { preserveScroll: true });
</script>

<template>
    <Head :title="t('ui.admins')" />
    <PageHeader :title="t('ui.admins')">
        <Link :href="route('users.create')" class="btn-primary">+ {{ t('ui.add') }}</Link>
    </PageHeader>
    <div class="card overflow-x-auto">
        <table class="table">
            <thead><tr><th>{{ t('ui.name') }}</th><th>{{ t('ui.email') }}</th><th>{{ t('ui.phone') }}</th><th>{{ t('ui.status') }}</th><th></th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                <tr v-for="u in admins" :key="u.id">
                    <td class="font-medium">{{ u.name }} <span v-if="u.is_me" class="badge bg-brand-50 text-brand-700">you</span></td>
                    <td>{{ u.email }}</td>
                    <td>{{ u.phone }}</td>
                    <td>
                        <button class="badge" :class="u.is_active ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-700'" :disabled="u.is_me" @click="flag(u, 'is_active', !u.is_active)">
                            {{ u.is_active ? t('ui.active') : t('ui.inactive') }}
                        </button>
                    </td>
                    <td class="text-end whitespace-nowrap">
                        <button v-if="!u.is_me" class="btn-secondary btn-sm" @click="flag(u, 'resend_invite', true)">{{ t('ui.resend_invite') }}</button>
                        <Link :href="route('users.edit', u.id)" class="btn-secondary btn-sm ms-1">{{ t('ui.edit') }}</Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
