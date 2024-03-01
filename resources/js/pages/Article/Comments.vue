<template>
    <!-- Секция комментариев к статье -->
    <div class="article-comments">
        <!-- Заголовок с количеством комментариев -->
        <h2>Комментарии ({{ comments.length }} шт.)</h2>
        <!-- Список комментариев -->
        <ul class="article-comments__list">
            <!-- Перечисление комментариев -->
            <li class="article-comments__comment" v-for="comment of comments" :key="comment.id">
                <!-- Время создания комментария -->
                <small class="article-comments__comment-time">
                    <TimeAgo :time="comment.created_at" />
                </small>
                <!-- Имя пользователя -->
                <div class="article-comments__comment-name" v-text="comment.name"></div>
                <!-- Текст комментария -->
                <div class="article-comments__comment-text" v-text="comment.text"></div>
            </li>
        </ul>
        <!-- Форма для добавления комментария -->
        <form @submit.prevent="store" class="article-comments__form">
            <!-- Заголовок формы -->
            <h3>Оставить комментарий</h3>
            <div>
                <!-- Поле ввода имени -->
                <label for="name">Введите ваше имя:</label>
                <input :disabled="isFetching" type="text" v-model="form.name" required maxlength="64" placeholder="Имя">
            </div>
            <div>
                <!-- Поле ввода текста комментария -->
                <label for="name">Введите комментарий:</label>
                <textarea :disabled="isFetching" required v-model="form.text" maxlength="255"
                    placeholder="Напишите что-нибудь..."></textarea>
            </div>
            <div>
                <!-- Кнопка отправки комментария -->
                <button :disabled="isFetching" class="button button-lg button-block">Отправить</button>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
// Импортируем необходимые типы и методы
import type { Article } from '@/typings/interfaces/Article'
import type { Comment } from '@/typings/interfaces/Comment'
import ApiRequest, { type DefaultResponse } from '@/utils/ApiRequest'
import { defineComponent } from 'vue'

// Определяем интерфейс данных компонента
interface ComponentData {
    form: {
        name: string,
        text: string
    },
    isFetching: boolean
}

export default defineComponent({
    // Принимаем статью в качестве пропса
    props: {
        article: Object as () => Article
    },
    // Определяем данные компонента
    data: (): ComponentData => ({
        form: {
            name: null,
            text: null
        },
        isFetching: false
    }),
    computed: {
        // Вычисляемое свойство для получения списка комментариев
        comments(): Comment[] {
            return this.$props.article.comments;
        }
    },
    methods: {
        // Метод для отправки нового комментария
        async store() {
            // Если запрос уже отправлен, выходим
            if (this.isFetching) return;
            // Устанавливаем флаг отправки запроса
            this.isFetching = true;
            try {
                // Отправляем POST-запрос на сервер
                const { data } = await ApiRequest.post<DefaultResponse>(`/articles/${this.article.id}/comments`, this.form);
                if (data.status == 'success') {
                    // Очищаем форму после успешной отправки
                    this.form.name = null;
                    this.form.text = null;
                    // Загружаем обновленный список комментариев
                    this.fetch();
                }
            } catch (err) { }
            // Сбрасываем флаг отправки запроса после завершения
            this.isFetching = false;
        },
        // Метод для загрузки списка комментариев
        async fetch() {
            const { data } = await ApiRequest.get<DefaultResponse>(`/articles/${this.article.id}/comments`);
            if (data.status == 'success') {
                // Обновляем список комментариев статьи
                this.article.comments = data.data;
            }
        }
    }
})
</script>
