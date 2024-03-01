import { pluralize } from "./pluralize"; // Импорт функции pluralize для склонения слов

/**
 * Функция для вычисления примерного времени чтения текста
 * @param wordCount Количество слов в тексте
 * @param wordsPerMinute Среднее количество слов в минуту при чтении
 * @returns Примерное время чтения текста в формате строки
 */
export function calculateReadingTime(
    wordCount: number,
    wordsPerMinute: number
): string {
    // Вычисление количества минут на основе количества слов и средней скорости чтения
    const minutes = Math.ceil(wordCount / wordsPerMinute);

    // Использование функции pluralize для склонения слова "минута" в зависимости от количества минут
    return pluralize(minutes, ["минута", "минуты", "минут"]);
}
