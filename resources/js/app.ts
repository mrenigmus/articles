import { createApp } from "vue"; // Импорт функции createApp из Vue
import Layout from "./Layout.vue"; // Импорт корневого компонента Layout.vue
import router from "./router"; // Импорт маршрутизатора

import { createPinia } from "pinia"; // Импорт Pinia для управления состоянием приложения

const app = createApp(Layout); // Создание экземпляра Vue приложения с корневым компонентом Layout
app.use(createPinia()); // Подключение Pinia к приложению
app.use(router); // Подключение маршрутизатора к приложению

import contenteditable from 'vue-contenteditable'; // Импорт contenteditable (не используется, так как зарегистрирован глобально)

import Toast from "vue-toastification"; // Импорт компонента для уведомлений Toast
import "vue-toastification/dist/index.css"; // Импорт стилей для Toast
import EmojiPicker from 'vue3-emoji-picker'; // Импорт компонента для выбора эмодзи
import 'vue3-emoji-picker/css'; // Импорт стилей для EmojiPicker
import Popper from "vue3-popper"; // Импорт компонента Popper для всплывающих окон

import Pagination from "./components/Pagination.vue"; // Импорт компонента Pagination.vue для пагинации
import TimeAgo from "./components/TimeAgo.vue"; // Импорт компонента TimeAgo.vue для отображения времени

app.use(Toast, {}); // Подключение компонента Toast к приложению

app.component("Popper", Popper); // Регистрация компонента Popper глобально
app.component("EmojiPicker", EmojiPicker); // Регистрация компонента EmojiPicker глобально
app.component("contenteditable", contenteditable); // Регистрация компонента contenteditable глобально (ненужно)
app.component("Pagination", Pagination); // Регистрация компонента Pagination глобально
app.component("TimeAgo", TimeAgo); // Регистрация компонента TimeAgo глобально

import moment from "moment"; // Импорт библиотеки moment.js для работы с датами и временем
import "moment/dist/locale/ru"; // Импорт локали для moment.js на русский язык
import { getTimeDifference } from "./utils/getTimeDifference"; // Импорт функции getTimeDifference для расчета разницы во времени

moment.locale("ru"); // Установка локали moment.js на русский язык

// Регистрация moment как глобального свойства приложения
app.config.globalProperties.$moment = moment;
// Регистрация функции getTimeDifference как глобального свойства приложения
app.config.globalProperties.$getTimeDifference = getTimeDifference;

app.mount("#app"); // Монтирование приложения в DOM элемент с id="app"
