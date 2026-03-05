<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
            'completed_at' => 'timestamp',
        ];
    }

    protected $fillable = [
        'siteID',
        'userID',
        'suggestion',
        'completed',
        'completed_at',
        'action',
    ];
}
