import polyglotI18nProvider from 'ra-i18n-polyglot';
import { TranslationMessages } from 'react-admin';
import ja from './i18n/ja';

export const i18nProvider = polyglotI18nProvider(_ => ja as TranslationMessages, 'ja');
