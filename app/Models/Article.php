<?php

namespace App\Models;

use App\Observers\ArticleObserver;
use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([ArticleObserver::class])]
class Article extends Model
{
    use HasFactory, GenerateUniqueSlugTrait;

    protected $fillable = ['slug', 'title', 'content'];

    protected $appends = ['short_desc'];

    public function getShortDescAttribute(){
        return substr(strip_tags($this->content), 0, 255);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "article_id");
    }
}
