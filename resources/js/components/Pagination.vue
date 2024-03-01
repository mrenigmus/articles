<template>
    <!-- Рендерлесс компонент для пагинации -->
    <RenderlessPagination
        :data="data"
        :limit="limit"
        :keep-length="keepLength"
        @pagination-change-page="onPaginationChangePage"
        v-slot="slotProps"
    >
        <!-- Навигация по страницам -->
        <nav class="pagination"
            v-bind="$attrs"
            aria-label="Pagination"
            v-if="slotProps.computed.total > slotProps.computed.perPage"
        >
            <!-- Кнопка "Назад" -->
            <button class="pagination-button"
                :disabled="!slotProps.computed.prevPageUrl"
                v-on="slotProps.prevButtonEvents"
            >
                <slot name="prev-nav">
                    Назад
                </slot>
            </button>

            <!-- Кнопки для отдельных страниц -->
            <button class="pagination-button"
                :class="{
                    'pagination-button__active': slotProps.computed.currentPage == page
                }"
                :aria-current="slotProps.computed.currentPage ? 'page' : null"
                v-for="(page, key) in slotProps.computed.pageRange"
                :key="key"
                v-on="slotProps.pageButtonEvents(page)"
            >
                {{ page }}
            </button>

            <!-- Кнопка "Вперед" -->
            <button class="pagination-button"
                :disabled="!slotProps.computed.nextPageUrl"
                v-on="slotProps.nextButtonEvents"
            >
                <slot name="next-nav">
                    Вперед
                </slot>
            </button>
        </nav>
    </RenderlessPagination>
</template>

<script lang="ts">
import RenderlessPagination from 'laravel-vue-pagination/src/RenderlessPagination.vue';
import { defineComponent } from 'vue';

export default defineComponent({

    inheritAttrs: false,

    emits: ['pagination-change-page'],

    components: {
        RenderlessPagination
    },

    props: {
        // Данные для пагинации
        data: {
            type: Object,
            default: () => {}
        },
        // Лимит элементов на странице
        limit: {
            type: Number,
            default: 0
        },
        // Флаг для сохранения длины
        keepLength: {
            type: Boolean,
            default: false
        },
    },

    methods: {
        // Обработчик события изменения страницы пагинации
        onPaginationChangePage(page) {
            this.$emit('pagination-change-page', page);
        }
    }
})
</script>
