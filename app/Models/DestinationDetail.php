<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DestinationDetail extends Model
{
    protected $fillable = [
        'itinerary',
        'arrival',
        'departure',
        'tnc',
        'include',
        'exclude',
        'nearby_hotel',
        'map_url',
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
