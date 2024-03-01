<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Создаем новый класс для миграции комментариев
return new class extends Migration
{
    /**
     * Выполняем миграцию.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // ID комментария
            $table->integer("article_id")->nullable(false)->index(); // ID статьи, не может быть пустым, создаем индекс для быстрого поиска
            $table->string("name", 64)->nullable(false); // Имя автора комментария, не может быть пустым
            $table->string("text")->nullable(false); // Текст комментария, не может быть пустым
            $table->timestamps(); // Добавляем метки времени для отслеживания создания и обновления комментариев
        });
    }

    /**
     * Откатываем миграцию.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments'); // Удаляем таблицу комментариев
    }
};
