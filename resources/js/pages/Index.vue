<template>
    <!-- Выводим сообщение, если статей нет -->
    <p v-if="articles?.total < 1" class="text-center">На сайт еще не добавили ни одной статьи</p>
    <!-- Отображаем список статей -->
    <section class="articles-list" v-if="articles">
        <!-- Создаем ссылку для каждой статьи -->
        <router-link :to="{
            name: 'article',
            params: {
                slug: article.slug
            }
        }" v-for="article of articles.data" :key="article.id">
            <!-- Отображаем каждую статью -->
            <article class="articles-list__item">
                <span class="articles-list__time">{{ $getTimeDifference(article.created_at) }}</span>
                <h2 class="articles-list__title">{{ article.title }}</h2>
                <p class="articles-list__description">{{ article.short_desc }}</p>
            </article>
        </router-link>
    </section>
    <!-- Выводим пагинацию -->
    <Pagination :data="articles" @pagination-change-page="changePage" v-if="articles" />
</template>

<script lang="ts">
import type { Article, ArticleListResponse } from '@/typings/interfaces/Article';
import type { Pagination } from '@/typings/interfaces/Pagination';
import ApiRequest from '@/utils/ApiRequest';
import { defineComponent } from 'vue'
import { useMainStore } from "@/stores/main.store";

// Определяем интерфейс данных компонента
interface ComponentData {
    page: number;
    articles: Pagination & {
        data: Article[]
    }
}

export default defineComponent({
    setup() {
        // Используем глобальное хранилище
        const mainStore = useMainStore();
        return { mainStore }
    },
    // Определяем данные компонента
    data: (): ComponentData => ({
        page: 1,
        articles: null
    }),
    methods: {
        // Метод для изменения текущей страницы
        changePage(page: number) {
            this.page = page;
        },
        // Метод для получения данных о статьях
        async fetch() {
            this.mainStore.startLoading();
            try {
                const { data } = await ApiRequest.get<ArticleListResponse>("/articles", {
                    params: {
                        page: this.page
                    }
                })

                if (data.status == 'success') this.articles = data.data;
            } catch (err) { }
            this.mainStore.stopLoading();
        }
    },
    // Наблюдение за изменением номера страницы и обновление данных
    watch: {
        page(v) {
            this.$router.replace({
                name: 'index',
                query: {
                    page: v
                }
            })
            this.fetch();
        }
    },
    // Выполнение при монтировании компонента
    mounted() {
        // Установка начальной страницы из параметра запроса
        if (this.$route.query.page) this.page = Number(this.$route.query.page);
        this.fetch();
    },
})
</script>
