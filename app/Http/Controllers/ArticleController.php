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
    public function __construct()
    {
        $this->middleware("admin", ["except" => ["index", "show"]]);
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Article::orderBy("id", "desc")->paginate(1)
        ]);
    }

    public function show(string $slug)
    {
        return response()->json([
            'status' => 'success',
            'data' => Article::where("slug", $slug)->first()
        ]);
    }

    public function store(StoreArticleRequest $r)
    {
        if ($article = Article::create($r->validated()))
            return response()->json([
                'status' => 'success',
                'data' => $article
            ]);


        return abort(500);
    }

    public function update(UpdateArticleRequest $r, int $id)
    {
        $article = Article::findOrFail($id);

        if ($article->update($r->validated()))  return response()->json([
            'status' => 'success',
            'data' => $article
        ]);

        return abort(500);
    }

    public function destroy(int $id)
    {
        $article = Article::findOrFail($id);


        if ($article->delete())  return response()->json([
            'status' => 'success',
        ]);

        return abort(500);
    }
}
