<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import ConfirmButton from '../../Components/ConfirmButton.vue';
import { useTranslation } from '../../i18n';

defineProps({ statuses: Array });
const { t } = useTranslation();
const create = useForm({ name: '' });
const editing = ref(null);
const edit = useForm({ name: '' });
const startEdit = (s) => { editing.value = s.id; edit.name = s.name; };
const saveEdit = () => edit.put(route('statuses.update', editing.value), { preserveScroll: true, onSuccess: () => (editing.value = null) });
const destroy = (s) => router.delete(route('statuses.destroy', s.id), { preserveScroll: true });
</script>

<template>
    <Head :title="t('ui.statuses')" />
    <PageHeader :title="t('ui.statuses')" />
    <div class="grid gap-4 lg:grid-cols-3">
        <div class="card lg:col-span-2">
            <table class="table">
                <thead><tr><th>#</th><th>{{ t('ui.name') }}</th><th class="text-end">{{ t('ui.applications_count') }}</th><th></th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="s in statuses" :key="s.id">
                        <td class="text-slate-400">{{ s.id }}</td>
                        <td>
                            <form v-if="editing === s.id" class="flex gap-2" @submit.prevent="saveEdit">
                                <input v-model="edit.name" class="input" />
                                <button class="btn-primary btn-sm">{{ t('ui.save') }}</button>
                                <button type="button" class="btn-secondary btn-sm" @click="editing = null">{{ t('ui.cancel') }}</button>
                            </form>
                            <template v-else>
                                {{ s.name }}
                                <span v-if="s.is_workflow" class="badge ms-2 bg-brand-50 text-brand-700">workflow</span>
                            </template>
                        </td>
                        <td class="text-end">{{ s.applications_count }}</td>
                        <td class="text-end whitespace-nowrap">
                            <template v-if="!s.is_workflow">
                                <button class="btn-secondary btn-sm" @click="startEdit(s)">{{ t('ui.edit') }}</button>
                                <ConfirmButton class="btn-danger btn-sm ms-1" @confirm="destroy(s)">{{ t('ui.delete') }}</ConfirmButton>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form class="card h-fit p-4" @submit.prevent="create.post(route('statuses.store'), { onSuccess: () => create.reset() })">
            <label class="label">{{ t('ui.add') }}</label>
            <input v-model="create.name" class="input" required />
            <p v-if="create.errors.name" class="error">{{ create.errors.name }}</p>
            <button class="btn-primary mt-3" :disabled="create.processing">{{ t('ui.add') }}</button>
        </form>
    </div>
</template>
