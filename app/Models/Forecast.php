<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    /** @use HasFactory<\config\database\factories\ForecastFactory> */
    use HasFactory;

    protected $fillable = ['site_id', 'data', 'updated_at', 'version'];

    public function site()
    {
        return $this->belongsTo('App\Models\Site');
    }
}
