<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GForecast extends Model
{
    protected $fillable = [
        'site_id',
        'data',
        'version',
    ];

    protected $primaryKey = 'site_id';

    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }
}
