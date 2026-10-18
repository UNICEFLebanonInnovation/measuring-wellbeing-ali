import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

/**
 * Minimal translation helper. Translations are shared by the server through
 * Inertia props (see HandleInertiaRequests) so the same lang/*.php files
 * drive both Blade and Vue, and switching language is a plain page reload.
 */
export function useTranslation() {
    const page = usePage();
    const locale = computed(() => page.props.locale ?? 'en');
    const dir = computed(() => (locale.value === 'ar' ? 'rtl' : 'ltr'));

    const t = (key, replacements = {}) => {
        const dict = page.props.translations ?? {};
        let text = dict[key];
        if (text === undefined || text === null) {
            text = key.includes('.') ? key.split('.').pop() : key;
            text = text.replace(/_/g, ' ');
            text = text.charAt(0).toUpperCase() + text.slice(1);
        }
        // Legacy strings use "singular|plural" for trans_choice; take the first form.
        if (typeof text === 'string' && text.includes('|')) {
            text = text.split('|')[0];
        }
        Object.entries(replacements).forEach(([k, v]) => {
            text = text.replace(new RegExp(`:${k}`, 'g'), v);
        });
        return text;
    };

    return { t, locale, dir };
}

export const i18n = {
    install(app) {
        app.config.globalProperties.$t = (key, replacements) => {
            const page = usePage();
            const dict = page.props.translations ?? {};
            let text = dict[key];
            if (text === undefined || text === null) {
                text = key.includes('.') ? key.split('.').pop() : key;
                text = text.replace(/_/g, ' ');
                text = text.charAt(0).toUpperCase() + text.slice(1);
            }
            if (typeof text === 'string' && text.includes('|')) {
                text = text.split('|')[0];
            }
            Object.entries(replacements ?? {}).forEach(([k, v]) => {
                text = text.replace(new RegExp(`:${k}`, 'g'), v);
            });
            return text;
        };
    },
};
