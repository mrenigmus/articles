<template>
    <div class="error-page">
        <h1 class="error-page__code">404</h1>
        <p class="error-page__description">Страница не найдена</p>
        <router-link :to="{ name: 'index' }" class="button error-page__button">Назад</router-link>
    </div>
</template>
