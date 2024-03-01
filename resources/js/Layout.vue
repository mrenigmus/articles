<template>
    <!-- Показываем спиннер загрузки только если приложение загружает данные -->
    <div class="loader" v-if="mainStore.isLoading">
        <div class="loader-spinner"></div>
    </div>

    <!-- Включаем компонент заголовка -->
    <Header />
    <!-- Основное содержимое приложения, включая маршруты -->
    <main class="container">
        <router-view />
    </main>
    <!-- Включаем компонент подвала -->
    <Footer />
</template>

<script lang="ts" setup>
// Импортируем необходимые функции из Vue
import { onBeforeMount, onMounted } from 'vue';
// Импортируем хранилища, используемые в компоненте
import { useMainStore } from "@/stores/main.store";
import { useAdminStore } from './stores/admin.store';
// Импортируем компоненты, которые будут включены в шаблон
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

// Получаем экземпляр главного хранилища
const mainStore = useMainStore();
// Получаем экземпляр хранилища администратора
const adminStore = useAdminStore();

// Проверяем авторизацию администратора на основе токена в локальном хранилище
adminStore.auth(localStorage.getItem("bearer-token"));

// Выполняем действия до момента монтирования компонента
onBeforeMount(mainStore.startLoading);
// Выполняем действия после монтирования компонента
onMounted(mainStore.stopLoading);
</script>
