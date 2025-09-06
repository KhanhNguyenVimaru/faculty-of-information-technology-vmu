import { createI18n } from 'vue-i18n'
import vi from './lang/vi.json'
import en from './lang/en.json'

const i18n = createI18n({
  legacy: false,
  locale: 'vi',
  fallbackLocale: 'en',
  messages: {
    vi,
    en
  }
})

export default i18n


