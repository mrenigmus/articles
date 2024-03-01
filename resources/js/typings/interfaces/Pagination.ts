import type { DefaultResponse } from "@/utils/ApiRequest"; // Импорт типа DefaultResponse из модуля ApiRequest

// Интерфейс для пагинации
export interface Pagination {
    current_page: number; // Номер текущей страницы
    data: any[]; // Массив данных текущей страницы
    first_page_url: string | null; // URL первой страницы (если доступен)
    from: number; // Номер первого элемента на текущей странице
    last_page: number; // Номер последней страницы
    last_page_url: string | null; // URL последней страницы (если доступен)
    next_page_url: string | null; // URL следующей страницы (если доступен)
    path: string | null; // Путь к ресурсу пагинации
    per_page: string; // Количество элементов на странице
    prev_page_url: string | null; // URL предыдущей страницы (если доступен)
    to: number; // Номер последнего элемента на текущей странице
    total: number; // Общее количество элементов
}

// Интерфейс для ответа от сервера на запрос данных с пагинацией
export interface PaginationResponse extends DefaultResponse {
    data: Pagination; // Данные пагинации
}
