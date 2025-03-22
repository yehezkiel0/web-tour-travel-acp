<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DestinationPhoto extends Model
{
    protected $fillable = ['destination_id', 'photo'];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
