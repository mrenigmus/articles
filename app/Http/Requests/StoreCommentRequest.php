<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Определяем, может ли пользователь делать этот запрос.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Получаем правила валидации для запроса.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:64', // Имя обязательно, строка, максимум 64 символа
            'text' => 'required|string|max:255', // Текст обязателен, строка, максимум 255 символов
        ];
    }
}
