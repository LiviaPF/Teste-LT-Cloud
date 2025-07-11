<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function developers(): BelongsToMany
    {
        return $this->belongsToMany(Developer::class);
    }
}
