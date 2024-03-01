<?php

namespace App\Http\Requests;

use App\Rules\MaxHtmlLength;
use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'title' => 'required|string|max:255', // Заголовок обязателен, строка, максимум 255 символов
            'content' => ['required', 'string', new MaxHtmlLength(10000)] // Содержание обязательно, строка, максимальная длина 10000 символов
        ];
    }
}
