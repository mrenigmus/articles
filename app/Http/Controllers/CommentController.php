<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(int $article_id)
    {
        return response()->json([
            'status' => 'success',
            'data' => Comment::where("article_id", $article_id)->orderBy("id", "desc")->get()
        ]);
    }

    public function store(StoreCommentRequest $r, int $article_id)
    {
        $article = Article::findOrFail($article_id);

        if ($comment = Comment::create([
            'article_id' => $article->id,
            'name' => $r->name,
            'text' => $r->text
        ])) return response()->json([
            'status' => 'success',
            'data' => $comment
        ]);

        return abort(500);
    }
}
