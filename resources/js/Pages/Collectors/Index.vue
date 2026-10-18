<script setup>
import { reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import Pagination from '../../Components/Pagination.vue';
import ConfirmButton from '../../Components/ConfirmButton.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ collectors: Object, search: String, partner: [Number, null], partners: Array, canCreate: Boolean });
const { t } = useTranslation();
const filter = reactive({ search: props.search ?? '', partner: props.partner ?? '' });
const apply = () => router.get(route('collectors.index'), Object.fromEntries(Object.entries(filter).filter(([, v]) => v)), { preserveState: true, replace: true });
const flag = (c, key, value) => router.patch(route('collectors.flags', c.id), { [key]: value }, { preserveScroll: true });
const destroy = (c) => router.delete(route('collectors.destroy', c.id));
</script>

<template>
    <Head :title="t('ui.collectors')" />
    <PageHeader :title="t('ui.collectors')">
        <Link v-if="canCreate" :href="route('collectors.create')" class="btn-primary">+ {{ t('ui.add') }}</Link>
    </PageHeader>

    <form class="mb-4 flex flex-wrap gap-2" @submit.prevent="apply">
        <input v-model="filter.search" class="input max-w-sm" :placeholder="t('ui.search')" />
        <select v-if="partners.length" v-model="filter.partner" class="input w-56">
            <option value="">{{ t('ui.partner') }}: {{ t('ui.all') }}</option>
            <option v-for="p in partners" :key="p.id" :value="p.id">{{ p.name }}</option>
        </select>
        <button class="btn-secondary">{{ t('ui.search') }}</button>
    </form>

    <div class="card overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ t('ui.name') }}</th>
                    <th>{{ t('ui.email') }}</th>
                    <th>{{ t('ui.prefix') }}</th>
                    <th v-if="partners.length">{{ t('ui.partner') }}</th>
                    <th>{{ t('ui.city') }}</th>
                    <th>{{ t('ui.sub_partner') }}</th>
                    <th class="text-end">{{ t('ui.applications_count') }}</th>
                    <th>{{ t('ui.read_only') }}</th>
                    <th>{{ t('ui.status') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr v-for="c in collectors.data" :key="c.id">
                    <td class="font-medium">{{ c.name }}<div class="text-xs text-slate-500">{{ c.phone }}</div></td>
                    <td>{{ c.email }}</td>
                    <td class="font-mono text-xs">{{ c.prefix }}</td>
                    <td v-if="partners.length">{{ c.partner }}</td>
                    <td>{{ c.city }}</td>
                    <td>{{ c.is_subpartner ? c.sub_partner : '—' }}</td>
                    <td class="text-end">{{ c.applications_count }}</td>
                    <td><input type="checkbox" :checked="c.is_readonly" @change="flag(c, 'is_readonly', $event.target.checked)" /></td>
                    <td>
                        <button class="badge" :class="c.is_active ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-700'" @click="flag(c, 'is_active', !c.is_active)">
                            {{ c.is_active ? t('ui.active') : t('ui.inactive') }}
                        </button>
                    </td>
                    <td class="text-end whitespace-nowrap">
                        <button class="btn-secondary btn-sm" @click="flag(c, 'resend_invite', true)">{{ t('ui.resend_invite') }}</button>
                        <Link :href="route('collectors.edit', c.id)" class="btn-secondary btn-sm ms-1">{{ t('ui.edit') }}</Link>
                        <ConfirmButton v-if="$page.props.auth.user.is_partner" class="btn-danger btn-sm ms-1" @confirm="destroy(c)">{{ t('ui.delete') }}</ConfirmButton>
                    </td>
                </tr>
                <tr v-if="collectors.data.length === 0"><td colspan="10" class="py-8 text-center text-slate-500">{{ t('ui.no_results') }}</td></tr>
            </tbody>
        </table>
        <Pagination :paginator="collectors" />
    </div>
</template>
