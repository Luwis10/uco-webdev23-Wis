<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        'content',
        'slug',
        'article_category_id',
    ];

    protected $appends = [
        'comments_count'
    ];

    function comments(): HasMany {
        return $this->hasMany(ArticleComment::class);
    }

    function category(): BelongsTo {
        return $this->belongsTo(ArticleCategory::class,'article_category_id');
    }

    function getCommentsCountAttribute() {
        return $this->comments()->count();
    }
}
