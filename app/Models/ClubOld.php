<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClubOld extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'contact', 'contact_email', 'contact_name', 'created_by', 'updated_by', 'updated_at', 'website'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->orderBy('id', 'asc');
    }

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }
}
