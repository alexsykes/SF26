<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'post_id',
        'comment',
        'published',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }
}
