<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteWindDirections extends Model
{
    public $timestamps = false;

    protected $fillable = ['siteID', 'direction'];
}
