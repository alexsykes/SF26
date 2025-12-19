<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clubmail extends Model
{
    protected $fillable = [
        'subject',
        'content',
        'attachment',
        'updatedBy',
        'replyToAddress',
        'replyToName',
        'originalName',
        'mimeType',
        'summary',
    ];

    protected function casts(): array
    {
        return [
            'UpdatedAt' => 'timestamp',
        ];
    }
}
