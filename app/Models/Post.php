<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'context',
        'category',
        'created_by',
        'updated_by',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
