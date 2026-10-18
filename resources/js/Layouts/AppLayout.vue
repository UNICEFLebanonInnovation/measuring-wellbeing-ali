<script setup>
import { computed, ref, watch } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { useTranslation } from '../i18n';
import FlashMessages from '../Components/FlashMessages.vue';

const page = usePage();
const { t, locale, dir } = useTranslation();
const user = computed(() => page.props.auth.user);
const sidebarOpen = ref(false);

watch(
    () => page.url,
    () => (sidebarOpen.value = false),
);

const nav = computed(() => {
    const u = user.value;
    if (!u) return [];
    const items = [];
    if (u.is_admin || u.is_partner) items.push({ label: t('ui.dashboard'), href: route('dashboard'), match: 'dashboard' });
    if (u.is_admin) items.push({ label: t('ui.admins'), href: route('users.index'), match: 'users' });
    if (u.is_admin) items.push({ label: t('ui.partners'), href: route('partners.index'), match: 'partners' });
    if (u.is_admin || u.is_partner) items.push({ label: t('ui.collectors'), href: route('collectors.index'), match: 'collectors' });
    items.push({ label: t('ui.applications'), href: route('applications.index'), match: 'applications' });
    items.push({ label: t('ui.change_decrease'), href: route('change-decrease.index'), match: 'change-decrease' });
    if (u.is_admin || u.is_partner) items.push({ label: t('ui.analytics'), href: route('reports.index'), match: 'reports' });
    if (u.is_admin || u.is_partner) items.push({ label: t('ui.activity_log'), href: route('reports.activity'), match: 'activity-log' });
    if (u.is_admin) items.push({ label: t('ui.statuses'), href: route('statuses.index'), match: 'statuses' });
    if (u.is_admin) items.push({ label: t('ui.locations'), href: route('locations.index'), match: 'locations' });
    return items;
});

const isActive = (match) => page.url.startsWith(`/${match}`);

const switchLocale = (value) => router.get(route('locale.switch', value), {}, { preserveScroll: true });
const logout = () => router.post(route('logout'));
</script>

<template>
    <div :dir="dir" class="min-h-screen bg-slate-50">
        <!-- Top bar -->
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white">
            <div class="flex h-14 items-center gap-3 px-4">
                <button class="rounded-md p-2 hover:bg-slate-100 lg:hidden" aria-label="Menu" @click="sidebarOpen = !sidebarOpen">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <Link :href="user ? (user.is_collector ? route('applications.index') : route('dashboard')) : route('login')" class="flex items-center gap-2">
                    <img src="/images/logo-menu.png" alt="" class="h-8 w-auto" />
                    <span class="hidden text-sm font-semibold text-brand-700 sm:inline">{{ t('ui.app_name') }}</span>
                </Link>
                <div class="ms-auto flex items-center gap-2">
                    <select
                        class="rounded-md border border-slate-300 bg-white px-2 py-1 text-xs"
                        :value="locale"
                        :aria-label="t('ui.language')"
                        @change="switchLocale($event.target.value)"
                    >
                        <option v-for="(label, code) in $page.props.locales" :key="code" :value="code">{{ label }}</option>
                    </select>
                    <template v-if="user">
                        <span class="hidden text-sm text-slate-600 md:inline">
                            {{ user.name }}
                            <span v-if="user.partner_name" class="text-slate-400">· {{ user.partner_name }}</span>
                            <span class="ms-1 badge bg-brand-50 text-brand-700">{{ user.roles[0] }}</span>
                        </span>
                        <button class="btn-secondary btn-sm" @click="logout">{{ t('ui.sign_out') }}</button>
                    </template>
                </div>
            </div>
        </header>

        <div class="flex">
            <!-- Sidebar -->
            <aside
                v-if="user"
                class="fixed inset-y-0 z-20 mt-14 w-60 transform border-e border-slate-200 bg-white transition-transform lg:static lg:mt-0 lg:translate-x-0"
                :class="[
                    sidebarOpen ? 'translate-x-0' : dir === 'rtl' ? 'translate-x-full' : '-translate-x-full',
                    dir === 'rtl' ? 'right-0' : 'left-0',
                ]"
            >
                <nav class="flex h-full flex-col gap-1 p-3">
                    <Link
                        v-for="item in nav"
                        :key="item.match"
                        :href="item.href"
                        class="rounded-md px-3 py-2 text-sm font-medium transition"
                        :class="isActive(item.match) ? 'bg-brand-500 text-white' : 'text-slate-700 hover:bg-brand-50 hover:text-brand-700'"
                    >
                        {{ item.label }}
                    </Link>
                    <a
                        v-if="$page.props.apkUrl"
                        :href="$page.props.apkUrl"
                        class="mt-auto rounded-md border border-dashed border-brand-300 px-3 py-2 text-xs text-brand-700 hover:bg-brand-50"
                    >
                        {{ t('ui.download_app') }}
                    </a>
                </nav>
            </aside>
            <div v-if="sidebarOpen" class="fixed inset-0 z-10 bg-black/30 lg:hidden" @click="sidebarOpen = false" />

            <!-- Content -->
            <main class="min-w-0 flex-1 p-4 lg:p-6">
                <FlashMessages />
                <slot />
            </main>
        </div>
    </div>
</template>
