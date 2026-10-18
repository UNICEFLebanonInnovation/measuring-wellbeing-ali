<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import Pagination from '../../Components/Pagination.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ partners: Object, search: String });
const { t } = useTranslation();
const search = ref(props.search ?? '');
const apply = () => router.get(route('partners.index'), search.value ? { search: search.value } : {}, { preserveState: true, replace: true });
const flag = (p, key, value) => router.patch(route('partners.flags', p.id), { [key]: value }, { preserveScroll: true });
</script>

<template>
    <Head :title="t('ui.partners')" />
    <PageHeader :title="t('ui.partners')">
        <Link :href="route('partners.create')" class="btn-primary">+ {{ t('ui.add') }}</Link>
    </PageHeader>

    <form class="mb-4 flex gap-2" @submit.prevent="apply">
        <input v-model="search" class="input max-w-sm" :placeholder="t('ui.search')" />
        <button class="btn-secondary">{{ t('ui.search') }}</button>
    </form>

    <div class="card overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ t('ui.name') }}</th>
                    <th>{{ t('ui.prefix') }}</th>
                    <th>{{ t('ui.email') }}</th>
                    <th>{{ t('ui.phone') }}</th>
                    <th class="text-end">{{ t('ui.collectors_count') }}</th>
                    <th class="text-end">{{ t('ui.applications_count') }}</th>
                    <th class="text-end">{{ t('ui.max_codes_per_year') }}</th>
                    <th>{{ t('ui.read_only') }}</th>
                    <th>{{ t('ui.status') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr v-for="p in partners.data" :key="p.id">
                    <td>
                        <Link :href="route('partners.show', p.id)" class="flex items-center gap-2 font-medium text-brand-700 hover:underline">
                            <img v-if="p.logo" :src="p.logo" alt="" class="h-6 w-6 rounded object-cover" />
                            {{ p.name }}
                        </Link>
                        <div class="text-xs text-slate-500">{{ p.contact }}</div>
                    </td>
                    <td class="font-mono text-xs">{{ p.prefix }}</td>
                    <td>{{ p.email }}</td>
                    <td>{{ p.phone }}</td>
                    <td class="text-end">{{ p.collectors_count }}</td>
                    <td class="text-end">{{ p.applications_count }}</td>
                    <td class="text-end">{{ p.max_app_per_year }}</td>
                    <td><input type="checkbox" :checked="p.is_readonly" @change="flag(p, 'is_readonly', $event.target.checked)" /></td>
                    <td>
                        <button class="badge" :class="p.is_active ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-700'" @click="flag(p, 'is_active', !p.is_active)">
                            {{ p.is_active ? t('ui.active') : t('ui.inactive') }}
                        </button>
                    </td>
                    <td class="text-end whitespace-nowrap">
                        <Link :href="route('partners.edit', p.id)" class="btn-secondary btn-sm">{{ t('ui.edit') }}</Link>
                    </td>
                </tr>
                <tr v-if="partners.data.length === 0"><td colspan="10" class="py-8 text-center text-slate-500">{{ t('ui.no_results') }}</td></tr>
            </tbody>
        </table>
        <Pagination :paginator="partners" />
    </div>
</template>
