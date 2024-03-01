<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Возвращает список комментариев для определенной статьи
    public function index(int $article_id)
    {
        return response()->json([
            'status' => 'success',
            'data' => Comment::where("article_id", $article_id)->get() // Получаем комментарии для указанной статьи
        ]);
    }

    // Создает новый комментарий для указанной статьи
    public function store(StoreCommentRequest $r, int $article_id)
    {
        $article = Article::findOrFail($article_id); // Находим статью по ID

        // Создаем комментарий
        if ($comment = Comment::create([
            'article_id' => $article->id,
            'name' => $r->name,
            'text' => $r->text
        ])) {
            return response()->json([
                'status' => 'success',
                'data' => $comment // Возвращаем созданный комментарий
            ]);
        }

        return abort(500); // Если не удалось создать комментарий, возвращаем ошибку сервера
    }
}
