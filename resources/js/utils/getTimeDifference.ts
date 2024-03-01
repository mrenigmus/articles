import moment, { type MomentInput } from "moment"; // Импорт библиотеки moment для работы с датами
import "moment/dist/locale/ru"; // Импорт локали для русского языка
moment.locale("ru"); // Установка локали moment на русский язык

import { pluralize } from "./pluralize"; // Импорт функции pluralize для склонения слов

/**
 * Функция для вычисления разницы между текущим временем и переданным временем в прошлом
 * @param date Время в прошлом, представленное строкой или объектом MomentInput
 * @returns Строка, представляющая разницу между временем в прошлом и текущим временем
 */
export function getTimeDifference(date: string | MomentInput): string {
    // Вычисление длительности между текущим временем и переданным временем в прошлом
    const duration = moment.duration(moment().diff(moment(date)));

    // Извлечение компонентов длительности: годы, месяцы, недели, дни, часы, минуты, секунды
    const years = duration.years(),
        months = duration.months(),
        weeks = duration.weeks(),
        days = duration.days(),
        hours = duration.hours(),
        minutes = duration.minutes(),
        seconds = duration.seconds();

    // Возвращение удобочитаемой строки, представляющей разницу
    if (years > 0) {
        return pluralize(years, ["год", "года", "лет"]) + " назад";
    } else if (months > 0) {
        return pluralize(months, ["месяц", "месяца", "месяцев"]) + " назад";
    } else if (weeks > 0) {
        return pluralize(weeks, ["неделю", "недели", "недель"]) + " назад";
    } else if (days > 0) {
        return pluralize(days, ["день", "дня", "дней"]) + " назад";
    } else if (hours > 0) {
        return pluralize(hours, ["час", "часа", "часов"]) + " назад";
    } else if (minutes > 0) {
        return pluralize(minutes, ["минуту", "минуты", "минут"]) + " назад";
    } else {
        return pluralize(seconds, ["секунду", "секунды", "секунд"]) + " назад";
    }
}
