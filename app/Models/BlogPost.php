<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
    ];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }
}
