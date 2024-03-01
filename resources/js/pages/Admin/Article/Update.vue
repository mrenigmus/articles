<template>
    <!-- Секция статьи -->
    <div class="article" v-if="article">
        <!-- Заголовок статьи -->
        <div class="article-header">
            <!-- Редактируемое поле для заголовка -->
            <contenteditable placeholder="Название" class="article-title" tag="h1" v-model="form.title" :no-nl="true"
                :no-html="true" />
            <!-- Кнопки для сохранения и удаления статьи -->
            <div class="article-info">
                <button :disabled="isFetching" @click="update" class="button">Сохранить</button>
                <button @click="destroy" :disabled="isFetching" class="button button-red">Удалить</button>
            </div>
        </div>
        <!-- Редактор контента статьи -->
        <editor v-model="form.content" :limit="10000" />
    </div>
</template>

<script lang="ts">
// Импортируем необходимые компоненты и методы
import Editor from '@/components/Editor.vue'
import { useMainStore } from '@/stores/main.store';
import type { Article, ArticleResponse } from '@/typings/interfaces/Article';
import ApiRequest, { type DefaultResponse } from '@/utils/ApiRequest';
import { defineComponent } from 'vue'
import { useToast } from 'vue-toastification';

// Определяем интерфейс данных компонента
interface ComponentData {
    article: Article,
    form: {
        title: string,
        content: string,
    },
    isFetching: boolean,
}

export default defineComponent({
    components: { Editor },
    props: ["slug"],
    setup() {
        // Используем главное хранилище и уведомления toast
        const mainStore = useMainStore();
        const toast = useToast();
        return { mainStore, toast };
    },
    // Определяем данные компонента
    data: (): ComponentData => ({
        article: null,
        form: {
            title: null,
            content: null,
        },
        isFetching: false,
    }),
    computed: {
        // Вычисляемое свойство для определения изменений в статье
        isChanged(): boolean {
            return this.article.content !== this.form.content || this.article.title !== this.form.title;
        },
    },
    methods: {
        // Метод для загрузки данных статьи
        async fetch() {
            this.mainStore.startLoading();
            try {
                const { data } = await ApiRequest.get<ArticleResponse>(`/articles/${this.slug}`, {
                    toastErrors: false,
                });
                if (data.status == 'success') {
                    this.article = data.data;
                    this.form.title = data.data.title;
                    this.form.content = data.data.content;
                }
            }
            catch (err) {
                if (err.response.status === 404) this.$router.push({
                    name: "error.notFound"
                }) // Переадресация на страницу 404, если статья не найдена
            }
            this.mainStore.stopLoading();
        },
        // Метод для удаления статьи
        async destroy() {
            if (this.isFetching) return;
            this.isFetching = true;
            try {
                const { data } = await ApiRequest.delete<DefaultResponse>(`/articles/${this.slug}`);
                if (data.status == 'success') {
                    // Перенаправляем пользователя на главную страницу
                    this.$router.push({
                        name: 'index',
                    });
                    // Показываем уведомление об успешном удалении статьи
                    this.toast.success("Статья удалена")
                }
            } catch (err) { }
            this.isFetching = false;
        },
        // Метод для обновления статьи
        async update() {
            if (!this.isChanged) return this.$router.push({
                name: 'article',
                params: {
                    slug: data.data.slug
                }
            })
            if (this.isFetching) return;
            this.isFetching = true;
            try {
                const { data } = await ApiRequest.put<ArticleResponse>(`/articles/${this.slug}`, this.form);
                if (data.status == 'success') {
                    // Перенаправляем пользователя на страницу статьи после обновления
                    this.$router.push({
                        name: 'article',
                        params: {
                            slug: data.data.slug
                        }
                    })
                }
            } catch (err) { }
            this.isFetching = false;
        },
    },
    // Вызываем метод fetch при монтировании компонента
    mounted() {
        this.fetch();
    },
})
</script>
