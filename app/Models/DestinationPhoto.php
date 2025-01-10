<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationPhoto extends Model
{
    protected $fillable = ['destination_id', 'photo'];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
