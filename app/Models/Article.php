<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image'
    ];

    public function developers(): BelongsToMany
    {
//        return $this->belongsToMany(Developer::class, 'developer_article', 'article_id', 'developer_id');
        return $this->belongsToMany(Developer::class);
    }
}
