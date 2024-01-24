<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $table = 'article_categories';
    protected $fillable = ['name'];

    public static $rules = [
        'nama' => 'required|string|unique:article_categories|max:100',
    ];

}
