<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GenerateUniqueSlugTrait
{
    public static function bootGenerateUniqueSlugTrait(): void
    {
        static::saving(function ($model) {
            // Генерируем уникальный слаг перед сохранением модели
            $slug = Str::slug($model->title); // Преобразуем заголовок в слаг
            $model->slug = $model->generateUniqueSlug($slug); // Генерируем уникальный слаг и присваиваем его модели
        });
    }

    public function generateUniqueSlug(string $slug): string
    {
        // Проверяем, существует ли уже слаг с номером в конце
        $originalSlug = $slug; // Сохраняем оригинальный слаг
        $slugNumber = null; // Номер слага

        if (preg_match('/-(\d+)$/', $slug, $matches)) {
            $slugNumber = $matches[1];
            $slug = Str::replaceLast("-$slugNumber", '', $slug);
        }

        // Получаем список существующих слагов в таблице
        $existingSlugs = $this->getExistingSlugs($slug, $this->getTable());

        if (!in_array($slug, $existingSlugs)) {
            // Слаг уникален, не нужно добавлять номер
            return $slug . ($slugNumber ? "-$slugNumber" : '');
        }

        // Увеличиваем номер, пока не найдем уникальный слаг
        $i = $slugNumber ? ($slugNumber + 1) : 1;
        $uniqueSlugFound = false;

        while (!$uniqueSlugFound) {
            $newSlug = $slug . '-' . $i;

            if (!in_array($newSlug, $existingSlugs)) {
                // Уникальный слаг найден
                return $newSlug;
            }

            $i++;
        }

        // Возвращаем оригинальный слаг с добавлением случайного числа
        return $originalSlug . '-' . mt_rand(1000, 9999);
    }

    private function getExistingSlugs(string $slug, string $table): array
    {
        return $this->where('slug', 'LIKE', $slug . '%')
            ->where('id', '!=', $this->id ?? null) // Исключаем ID текущей модели
            ->pluck('slug')
            ->toArray();
    }
}
