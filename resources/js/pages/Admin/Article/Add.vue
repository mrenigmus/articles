<template>
    <!-- Секция создания новой статьи -->
    <div class="article">
        <!-- Заголовок статьи -->
        <div class="article-header">
            <!-- Редактируемое поле для заголовка -->
            <contenteditable placeholder="Название" class="article-title" tag="h1" v-model="form.title" :no-nl="true"
                :no-html="true" />
            <!-- Кнопка для публикации статьи -->
            <div class="article-info">
                <button @click="store" class="button" :disabled="isFetching">Опубликовать</button>
            </div>
        </div>
        <!-- Редактор контента статьи -->
        <editor v-model="form.content" :limit="10000" />
    </div>
</template>

<script lang="ts">
// Импортируем необходимые компоненты и типы
import Editor from '@/components/Editor.vue'
import type { ArticleResponse } from '@/typings/interfaces/Article';
import ApiRequest from '@/utils/ApiRequest';
import { defineComponent } from 'vue'

// Определяем интерфейс данных компонента
interface ComponentData {
    form: {
        title: string,
        content: string,
    },
    isFetching: boolean,
}

export default defineComponent({
    components: { Editor },
    // Определяем данные компонента
    data: (): ComponentData => ({
        form: {
            title: null,
            content: null,
        },
        isFetching: false,
    }),
    methods: {
        // Метод для отправки новой статьи на сервер
        async store() {
            if (this.isFetching) return;
            this.isFetching = true;

            try {
                // Отправляем POST-запрос на сервер
                const { data } = await ApiRequest.post<ArticleResponse>("/articles", this.form);
                if (data.status == 'success') {
                    // Перенаправляем пользователя на страницу созданной статьи
                    this.$router.push({
                        name: 'article',
                        params: {
                            slug: data.data.slug
                        }
                    });
                }
            } catch (err) { }
            this.isFetching = false;
        }
    }
})
</script>
