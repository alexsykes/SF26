<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataRequest extends Model
{
    protected $fillable = [
        'created_by',
        'description',
        'purpose',
        'comments',
        'approved',
        'accept',
        'data_format',
    ];

    protected function casts(): array
    {
        return [
            'accept' => 'boolean',
        ];
    }
}
