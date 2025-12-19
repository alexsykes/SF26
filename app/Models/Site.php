<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Site extends Model
{
    use HasFactory;

    protected $fillable = ['site_name', 'near', 'site_description', 'site_access', 'site_wind_directions', 'lat', 'lng', 'created_by', 'hits', 'updated_by', 'published', 'w3w', 'updated_at', 'dir', 'from', 'to', 'begin', 'end'];

    static function getPublishedSiteList()
    {
        $sites = Site::where('published', 1)
            ->orderBy('site_name')
            ->limit(5)
            ->get();

        return $sites;
    }

    static function getFiveSites()
    {
        $sites = Site::where('published', 1)
            ->orderBy('site_name')
            ->limit(1)
            ->get();

        return $sites;
    }


//    public function notes(): hasMany {
//        return $this->hasMany(Note::class, 'item_id', 'id');
//    }
//    public function user(): BelongsTo {
//        return $this->belongsTo(User::class)->orderBy('id','asc');
//    }

    public function forecast(): HasOne
    {
        return $this->hasOne(Forecast::class, 'site_id');
    }

    public function gforecast(): HasOne
    {
        return $this->hasOne(GForecast::class, 'site_id');
    }
}
