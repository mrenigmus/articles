<template>
    <!-- Шапка страницы -->
    <header class="header">
        <div class="container">
            <!-- Ссылка на главную страницу с логотипом -->
            <router-link class="header__logo" :to="{ name: 'index' }">
                <h1><span>A</span>rticles</h1>
            </router-link>
            <!-- Навигация -->
            <nav class="header__nav">
                <ul>
                    <li class="header__nav-item" v-if="!adminStore.isAuthed">
                        <!-- Вход в административный режим -->
                        <a href="#" @click="adminInput = true" v-if="!adminInput">Админ-режим</a>
                        <!-- Форма для аутентификации в админ-режиме -->
                        <form @submit.prevent="auth" v-else class="admin-auth">
                            <input v-model="adminCode" :disabled="isFetching" required type="password"
                                placeholder="Введите код доступа">
                            <span class="error" v-if="authError">Неверный код доступа</span>
                            <button type="submit" :disabled="isFetching" class="button btn-block">Войти</button>
                            <button type="button" @click="adminInput = false"
                                class="button button-secondary btn-block">Закрыть</button>
                        </form>
                    </li>
                    <!-- Если пользователь аутентифицирован как администратор -->
                    <template v-else>
                        <!-- Ссылка для добавления новой статьи -->
                        <li class="header__nav-item">
                            <router-link :to="{name: 'admin.article.add'}" v-if="$route.name != 'admin.article.add'"><i class="fas fa-plus"></i> Добавить статью</router-link>
                        </li>
                    </template>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script lang="ts">
// Импорт необходимых методов и типов
import { useAdminStore } from '@/stores/admin.store';
import ApiRequest, { type DefaultResponse } from '@/utils/ApiRequest';
import { defineComponent } from 'vue'

export default defineComponent({
    // Настройка компонента
    setup() {
        // Использование хранилища администратора
        const adminStore = useAdminStore();
        return { adminStore };
    },
    // Определение данных компонента
    data: () => ({
        adminInput: false, // Флаг для отображения формы ввода кода доступа
        adminCode: null, // Код доступа для аутентификации
        authError: false, // Флаг для отображения ошибки аутентификации
        isFetching: false, // Флаг для отображения процесса загрузки
    }),
    methods: {
        // Метод для аутентификации пользователя в админ-режиме
        async auth() {
            // Проверка наличия активного запроса
            if (this.isFetching) return;
            this.authError = false; // Сброс ошибки аутентификации
            this.isFetching = true; // Установка флага загрузки
            // Аутентификация с использованием хранилища администратора
            var auth = await this.adminStore.auth(this.adminCode)
            // Обработка результата аутентификации
            if (!auth) this.authError = true; // Ошибка аутентификации
            this.isFetching = false; // Сброс флага загрузки
        }
    }
})
</script>
