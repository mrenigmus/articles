<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxHtmlLength implements ValidationRule
{
    protected $max;

    public function __construct($max)
    {
        $this->max = $max; // Устанавливаем максимальную длину текста
    }

    /**
     * Выполняем правило валидации.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $textLength = strlen(trim(strip_tags($value))); // Получаем длину текста после удаления HTML-тегов и лишних пробелов
        // Проверяем, не превышает ли длина текста максимальное значение
        if ($textLength > $this->max) {
            $fail(":attribute не может быть длиннее {$this->max} символов"); // Выводим сообщение об ошибке
        }
    }
}
