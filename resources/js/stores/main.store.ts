import { defineStore } from "pinia"; // Импорт функции defineStore из библиотеки Pinia

// Определение интерфейса состояния хранилища
interface MainStoreState {
    loadingItems: any[]; // Массив для отслеживания загружаемых элементов
}

// Создание и экспорт хранилища Pinia с именем "main"
export const useMainStore = defineStore("main", {
    state: (): MainStoreState => ({ // Определение начального состояния хранилища
        loadingItems: [], // Инициализация массива загружаемых элементов
    }),
    getters: { // Определение геттеров (вычисляемых свойств) хранилища
        isLoading: (state): boolean => state.loadingItems.length > 0, // Геттер для определения статуса загрузки
    },
    actions: { // Определение действий (методов) хранилища
        startLoading(): void { // Действие для начала загрузки
            this.loadingItems.push(0); // Добавление фиктивного элемента в массив загружаемых элементов
        },
        stopLoading(): void { // Действие для завершения загрузки
            setTimeout(() => this.loadingItems.splice(0, 1), 100); // Удаление первого элемента из массива загружаемых элементов с небольшой задержкой
        },
    },
});
