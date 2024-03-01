<?php

namespace App\Models;

use App\Traits\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory, GenerateUniqueSlugTrait;

    protected $fillable = ['slug', 'title', 'content', 'short_desc'];

    public function comments()
    {
        return $this->hasMany(Comment::class, "article_id");
    }
}
