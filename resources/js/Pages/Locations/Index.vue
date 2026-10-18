<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import PageHeader from '../../Components/PageHeader.vue';
import ConfirmButton from '../../Components/ConfirmButton.vue';
import { useTranslation } from '../../i18n';

const props = defineProps({ governorates: Array, cazas: Array, areas: Array, selected: Object });
const { t } = useTranslation();

const select = (level, id) => {
    const params = level === 'governorate' ? { governorate: id } : { governorate: props.selected.governorate, caza: id };
    router.get(route('locations.index'), params, { preserveState: true, preserveScroll: true, replace: true });
};

const forms = {
    governorate: useForm({ name: '', arabic: '' }),
    caza: useForm({ name: '', arabic: '', gouvernate_id: null }),
    area: useForm({ name: '', arabic: '', caza_id: null }),
};
const add = (type) => {
    const f = forms[type];
    if (type === 'caza') f.gouvernate_id = props.selected.governorate;
    if (type === 'area') f.caza_id = props.selected.caza;
    f.post(route('locations.store', type), { preserveScroll: true, onSuccess: () => f.reset() });
};
const editing = ref({ type: null, id: null });
const edit = useForm({ name: '', arabic: '' });
const startEdit = (type, row) => { editing.value = { type, id: row.id }; edit.name = row.name; edit.arabic = row.arabic ?? ''; };
const saveEdit = () => edit.put(route('locations.update', [editing.value.type, editing.value.id]), { preserveScroll: true, onSuccess: () => (editing.value = { type: null, id: null }) });
const destroy = (type, row) => router.delete(route('locations.destroy', [type, row.id]), { preserveScroll: true });

const columns = [
    { type: 'governorate', title: 'ui.governorate', rows: () => props.governorates, selectable: true, selectedId: () => props.selected.governorate, count: 'cazas_count' },
    { type: 'caza', title: 'ui.caza', rows: () => props.cazas, selectable: true, selectedId: () => props.selected.caza, count: 'areas_count', needs: () => props.selected.governorate },
    { type: 'area', title: 'ui.area', rows: () => props.areas, selectable: false, selectedId: () => null, needs: () => props.selected.caza },
];
</script>

<template>
    <Head :title="t('ui.locations')" />
    <PageHeader :title="t('ui.locations')" />
    <div class="grid gap-4 lg:grid-cols-3">
        <div v-for="col in columns" :key="col.type" class="card flex max-h-[75vh] flex-col">
            <div class="card-header"><h2 class="font-semibold">{{ t(col.title) }}</h2><span class="text-xs text-slate-500">{{ col.rows().length }}</span></div>
            <div class="flex-1 overflow-y-auto">
                <div v-if="col.needs && !col.needs()" class="p-4 text-sm text-slate-500">←</div>
                <ul v-else class="divide-y divide-slate-100 text-sm">
                    <li v-for="row in col.rows()" :key="row.id" class="flex items-center gap-2 px-3 py-2" :class="{ 'bg-brand-50': col.selectedId() === row.id }">
                        <form v-if="editing.type === col.type && editing.id === row.id" class="flex flex-1 gap-1" @submit.prevent="saveEdit">
                            <input v-model="edit.name" class="input" />
                            <input v-model="edit.arabic" class="input" dir="rtl" />
                            <button class="btn-primary btn-sm">{{ t('ui.save') }}</button>
                            <button type="button" class="btn-secondary btn-sm" @click="editing = { type: null, id: null }">×</button>
                        </form>
                        <template v-else>
                            <button class="flex-1 text-start" :class="col.selectable ? 'hover:text-brand-700' : 'cursor-default'" @click="col.selectable && select(col.type, row.id)">
                                {{ row.name }} <span class="text-slate-400" dir="rtl">{{ row.arabic }}</span>
                                <span v-if="col.count" class="ms-1 text-xs text-slate-400">({{ row[col.count] }})</span>
                            </button>
                            <button class="btn-secondary btn-sm" @click="startEdit(col.type, row)">{{ t('ui.edit') }}</button>
                            <ConfirmButton class="btn-danger btn-sm" @confirm="destroy(col.type, row)">×</ConfirmButton>
                        </template>
                    </li>
                </ul>
            </div>
            <form v-if="!col.needs || col.needs()" class="flex gap-1 border-t border-slate-200 p-2" @submit.prevent="add(col.type)">
                <input v-model="forms[col.type].name" class="input" :placeholder="t('ui.name')" required />
                <input v-model="forms[col.type].arabic" class="input" :placeholder="t('ui.arabic_name')" dir="rtl" />
                <button class="btn-primary btn-sm">{{ t('ui.add') }}</button>
            </form>
        </div>
    </div>
</template>
