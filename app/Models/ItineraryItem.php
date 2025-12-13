<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItineraryItem extends Model
{
  protected $fillable = [
    'itinerary_id',
    'destination_id',
    'order',
    'visit_date',
    'notes'
  ];

  protected $casts = [
    'visit_date' => 'date',
  ];

  public function itinerary(): BelongsTo
  {
    return $this->belongsTo(Itinerary::class);
  }

  public function destination(): BelongsTo
  {
    return $this->belongsTo(Destination::class);
  }
}
