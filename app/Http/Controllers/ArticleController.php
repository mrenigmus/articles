<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class ArticleController extends Controller
{
    // Устанавливаем middleware "admin" для всех методов контроллера, кроме "index" и "show"
    public function __construct()
    {
        $this->middleware("admin", ["except" => ["index", "show"]]);
    }

    // Возвращает список статей
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Article::orderBy("id", "desc")->paginate(1) // Получаем статьи, отсортированные по ID в обратном порядке с пагинацией
        ]);
    }

    // Показывает информацию о статье по ее слагу
    public function show(string $slug)
    {
        return response()->json([
            'status' => 'success',
            'data' => Article::with("comments")->where("slug", $slug)->firstOrFail() // Получаем статью по ее слагу вместе с комментариями
        ]);
    }

    // Создает новую статью
    public function store(StoreArticleRequest $r)
    {
        if ($article = Article::create($r->validated())) { // Создаем статью из валидированных данных
            return response()->json([
                'status' => 'success',
                'data' => $article // Возвращаем созданную статью
            ]);
        }

        return abort(500); // Если не удалось создать статью, возвращаем ошибку сервера
    }

    // Обновляет существующую статью по ее слагу
    public function update(UpdateArticleRequest $r, string $slug)
    {
        $article = Article::where("slug", $slug)->firstOrFail(); // Находим статью по ее слагу

        if ($article->update($r->validated())) { // Обновляем статью из валидированных данных
            return response()->json([
                'status' => 'success',
                'data' => $article // Возвращаем обновленную статью
            ]);
        }

        return abort(500); // Если не удалось обновить статью, возвращаем ошибку сервера
    }

    // Удаляет существующую статью по ее слагу
    public function destroy(string $slug)
    {
        $article = Article::where("slug", $slug)->firstOrFail(); // Находим статью по ее слагу

        if ($article->delete()) { // Удаляем статью
            return response()->json([
                'status' => 'success',
            ]);
        }

        return abort(500); // Если не удалось удалить статью, возвращаем ошибку сервера
    }
}
