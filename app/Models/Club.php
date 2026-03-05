<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'Name',
        'Area',
        'Contact',
        'Email',
        'Phone',
        'Website',
        'Description',
        'Notes',
        'status',
    ];
}
