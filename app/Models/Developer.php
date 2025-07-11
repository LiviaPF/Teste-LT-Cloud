<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Developer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'seniority',
        'skills'
    ];

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'developer_article', 'developer_id', 'article_id');
    }
}
