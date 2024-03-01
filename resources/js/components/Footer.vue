<template>
    <!-- Футер страницы -->
    <footer class="footer">
        <div class="container">
            <!-- Отображение текущего года -->
            <p>&copy; {{ currentYear }} Articles</p>
        </div>
    </footer>
</template>

<script setup>
import { computed } from 'vue';

// Вычисляемое свойство для получения текущего года
const currentYear = computed(() => new Date().getFullYear());
</script>
