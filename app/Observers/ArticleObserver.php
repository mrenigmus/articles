<?php

namespace App\Observers;

use App\Models\Article;

class ArticleObserver
{
    // Метод для замены контента статьи
    private function replaceContent(Article $article)
    {
        $article->content = nl2br(trim(preg_replace('#<p[^>]*>(.*?)</p>#is', "$1\n", $article->content)));
    }

    // Вызываем метод замены контента перед сохранением, обновлением или созданием статьи
    public function saving(Article $article): void
    {
        $this->replaceContent($article);
    }

    public function updating(Article $article): void
    {
        $this->replaceContent($article);
    }

    public function creating(Article $article): void
    {
        $this->replaceContent($article);
    }
}
