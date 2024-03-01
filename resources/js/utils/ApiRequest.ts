import axios, { AxiosError } from "axios"; // Импорт библиотеки Axios и типа AxiosError

import { useToast } from "vue-toastification"; // Импорт функции useToast для создания уведомлений

// Интерфейс для стандартного ответа от сервера
export interface DefaultResponse {
    status: "success" | "error"; // Статус ответа: успех или ошибка
    data?: any; // Данные ответа
}

// Интерфейс для ошибки
export interface ErrorResponse {
    status: "error"; // Статус ошибки
    message: string; // Сообщение об ошибке
    errors?: {
        [key: string]: string[] | string;
    }; // Дополнительные детали ошибки
}

const toast = useToast(); // Создание экземпляра уведомлений

// Создание экземпляра Axios для отправки HTTP-запросов
const ApiRequest = axios.create({
    baseURL: "/api", // Базовый URL API
    headers: {
        Accept: "application/json", // Заголовок Accept
        "Content-Type": "application/json", // Заголовок Content-Type
    },
    transformRequest: axios.defaults.transformRequest, // Функция преобразования запроса
    transformResponse: axios.defaults.transformResponse, // Функция преобразования ответа
});

// Добавление параметра toastErrors в конфигурацию запроса по умолчанию
ApiRequest.defaults.toastErrors = true;

// Интерцептор для добавления токена авторизации в заголовок запроса
ApiRequest.interceptors.request.use((request) => {
    request.headers.Authorization =
        "Bearer " + localStorage.getItem("bearer-token"); // Добавление токена авторизации в заголовок Authorization
    return request;
});

// Интерцептор для обработки ошибок при получении ответа
ApiRequest.interceptors.response.use(
    (response) => response,
    (error: AxiosError) => {
        try {
            if (error.response.config.toastErrors) { // Проверка наличия параметра toastErrors в конфигурации запроса
                const responseData = error.response.data as ErrorResponse; // Получение данных об ошибке
                if (responseData.message) { // Если есть сообщение об ошибке
                    toast.error(responseData.message); // Вывод сообщения об ошибке
                }
            }
        } catch (err) {}
        throw error; // Пробрасывание ошибки дальше
    }
);

export default ApiRequest; // Экспорт экземпляра Axios для использования в других частях приложения
