<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image'
    ];

    public function developers(): BelongsToMany
    {
        return $this->belongsToMany(Developer::class, 'developer_article', 'developer_id', 'article_id');
    }
}
