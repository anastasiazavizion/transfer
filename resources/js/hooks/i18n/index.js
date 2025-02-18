import { createI18n } from 'vue-i18n';

const response = await axios.get('/api/locale/translations');
const messages = await response.data || [];

const responseCurrentLocale = await axios.get('api/locale/current');
const currentLocale = responseCurrentLocale.data || 'en';

const i18n = createI18n({
    legacy: false,
    globalInjection: true,
    locale: currentLocale, // set default locale
    fallbackLocale: currentLocale,
    messages
});

export default i18n;
