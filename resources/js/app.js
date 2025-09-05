import './bootstrap';
import '../css/app.css'
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './route';
import { createI18n } from 'vue-i18n'
import vi from './lang/vi.json'
import en from './lang/en.json'

const i18n = createI18n({
  locale: 'vi',
  fallbackLocale: 'en',
  messages: {
    vi,
    en
  }
})

const app = createApp(App)
app.use(i18n)
app.mount('#app')
