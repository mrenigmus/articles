import type { DefaultResponse } from "@/utils/ApiRequest"; // Импорт типа DefaultResponse из модуля ApiRequest
import type { Comment } from "./Comment"; // Импорт типа Comment из соответствующего модуля
import type { Pagination, PaginationResponse } from "./Pagination"; // Импорт типов Pagination и PaginationResponse из соответствующего модуля

// Интерфейс для статьи
export interface Article {
    id: number; // Уникальный идентификатор статьи
    slug: string; // Слаг статьи (часть URL)
    title: string; // Заголовок статьи
    content: string; // Содержимое статьи
    short_desc: string | null; // Краткое описание статьи (может быть null)
    created_at: string; // Дата и время создания статьи
    updated_at: string; // Дата и время последнего обновления статьи
    comments?: Comment[]; // Комментарии к статье (опционально)
}

// Интерфейс для ответа от сервера на запрос одной статьи
export interface ArticleResponse extends DefaultResponse {
    data: Article; // Данные одной статьи
}

// Интерфейс для ответа от сервера на запрос списка статей с пагинацией
export interface ArticleListResponse extends PaginationResponse {
    data: Pagination & { // Данные пагинации вместе с массивом статей
        data: Article[]; // Массив статей
    };
}
