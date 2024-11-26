<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'slug', 
        'content', 
        'news_category_id', 
        'image', 
        'status',
    ];

    public function newscategory()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id', 'id');
    }

}
