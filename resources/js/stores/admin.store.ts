import { defineStore } from "pinia"; // Импортируем функцию defineStore из библиотеки Pinia
import ApiRequest, { type DefaultResponse } from "@/utils/ApiRequest"; // Импортируем функцию ApiRequest и тип DefaultResponse из соответствующих модулей

// Определяем интерфейс состояния хранилища
interface MainStoreState {
    isAuthed: boolean; // Флаг аутентификации
}

// Создаем и экспортируем хранилище Pinia с именем "admin"
export const useAdminStore = defineStore("admin", {
    state: (): MainStoreState => ({ // Определяем начальное состояние хранилища
        isAuthed: false, // Начальное значение флага аутентификации
    }),
    actions: { // Определяем действия, доступные в хранилище
        async auth(code: string) { // Действие для аутентификации
            try {
                // Сохраняем код аутентификации в локальное хранилище
                localStorage.setItem("bearer-token", code);
                // Отправляем запрос на аутентификацию на сервер
                const { data } = await ApiRequest.post<DefaultResponse>("/auth", {}, {
                    toastErrors: false
                });
                // Если аутентификация прошла успешно, устанавливаем флаг аутентификации в true
                if (data.status == "success") this.isAuthed = true;
                return true; // Возвращаем true, если аутентификация успешна
            } catch (err) {
                // Если произошла ошибка при аутентификации, удаляем токен из локального хранилища
                localStorage.removeItem("bearer-token");
                return false; // Возвращаем false, если аутентификация не удалась
            }
        },
    },
});
