<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    //
    protected $fillable = ['item_id', 'user_id', 'note', 'type', 'completed', 'accepted'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'item_id', 'id');
    }
}
