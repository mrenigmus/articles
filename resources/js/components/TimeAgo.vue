<template>
    <!-- Отображаем текущее время с учетом разницы -->
    {{ timeAgo }}
</template>

<script setup lang="ts">
// Импортируем необходимые методы и типы
import { getTimeDifference } from "@/utils/getTimeDifference"
import { type MomentInput } from "moment"
import { computed, onBeforeUnmount, onMounted, ref } from "vue"

// Определяем пропсы компонента
const props = defineProps<{
    time: string | MomentInput
}>()

// Создаем реактивную переменную для отображения времени
const timeAgo = ref<string>();

// Создаем реактивную переменную для хранения идентификатора интервала
const intervalId = ref<number>();

// Вычисляем значение времени с учетом разницы
timeAgo.value = getTimeDifference(props.time);

// Запускаем интервал обновления времени при монтировании компонента
onMounted(() => {
    // Устанавливаем интервал обновления времени каждые 10 секунд
    intervalId.value = setInterval(() => timeAgo.value = getTimeDifference(props.time), 10 * 1000)
})

// Очищаем интервал перед удалением компонента
onBeforeUnmount(() => clearInterval(intervalId.value))
</script>
