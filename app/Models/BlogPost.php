<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'category',
        'published',
        'created_by',
        'updated_by',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class, 'blog_post_id');
    }

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }
}
