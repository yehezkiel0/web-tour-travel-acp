<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
