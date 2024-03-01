<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Создаем новый класс для миграции статей
return new class extends Migration
{
    /**
     * Выполняем миграцию.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id(); // ID статьи
            $table->string("slug")->unique(); // Уникальный слаг
            $table->string("title")->nullable(false)->index(); // Заголовок, не может быть пустым, создаем индекс для быстрого поиска
            $table->text("content")->nullable(false); // Содержание статьи, не может быть пустым
            $table->timestamps(); // Добавляем метки времени для отслеживания создания и обновления записей
        });
    }

    /**
     * Откатываем миграцию.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles'); // Удаляем таблицу статей
    }
};
