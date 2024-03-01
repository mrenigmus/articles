<template>
    <!-- Отображаем статью, если она доступна -->
    <div class="article" v-if="article">
        <div class="article-header">
            <!-- Заголовок статьи -->
            <h1 class="article-title">{{ article.title }}</h1>
            <div class="article-info">
                <!-- Ссылка на редактирование статьи для администратора -->
                <router-link :to="{
                    name: 'admin.article.update',
                    params: {
                        slug: article.slug
                    }
                }" v-if="adminStore.isAuthed"><i class="fas fa-edit"></i>  Редактировать</router-link>
                <!-- Время создания статьи -->
                <div class="article-info__time">{{ $moment(article.created_at).format("LLL") }}</div>
                <!-- Время чтения статьи -->
                <div class="article-info__reading-time">{{ readingTime }} на прочтение</div>
            </div>
        </div>
        <!-- Содержание статьи -->
        <p class="article-content" v-html="article.content"></p>
        <!-- Комментарии к статье -->
        <Comments :article="article" />
    </div>
</template>

<script lang="ts">
import { useMainStore } from '@/stores/main.store'
import type { Article, ArticleResponse } from '@/typings/interfaces/Article'
import ApiRequest from '@/utils/ApiRequest'
import { defineComponent } from 'vue'
import { calculateReadingTime } from "@/utils/calculateReadingTime";
import Comments from './Comments.vue';
import { useAdminStore } from '@/stores/admin.store';

// Определяем интерфейс данных компонента
interface ComponentData {
    article: Article
}

export default defineComponent({
    props: ["slug"],
    setup() {
        // Используем глобальные хранилища
        const mainStore = useMainStore();
        const adminStore = useAdminStore();
        return { mainStore, adminStore };
    },
    // Определяем данные компонента
    data: (): ComponentData => ({
        article: null
    }),
    computed: {
        // Вычисляемое свойство для определения времени чтения статьи
        readingTime() {
            return calculateReadingTime(this.article.content?.length, 200);
        }
    },
    methods: {
        // Метод для загрузки данных статьи
        async fetch() {
            this.mainStore.startLoading();
            try {
                const { data } = await ApiRequest.get<ArticleResponse>(`/articles/${this.slug}`, {
                    toastErrors: false
                });
                if (data.status == 'success')
                    this.article = data.data;
            }
            catch (err) {
                if ( err.response.status === 404 ) this.$router.push({
                    name: "error.notFound"
                }) // Переадресация на страницу 404, если статья не найдена
             }
            this.mainStore.stopLoading();
        }
    },
    // Вызываем метод fetch при монтировании компонента
    mounted() {
        this.fetch();
    },
    // Регистрируем дочерний компонент Comments
    components: { Comments }
})
</script>
