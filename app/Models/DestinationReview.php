<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DestinationReview extends Model
{
    protected $fillable = [
        'user_id',
        'destination_id',
        'booking_transaction_id',
        'rating',
        'title',
        'review',
        'photos',
        'is_verified',
        'is_approved',
        'helpful_count',
    ];

    protected $casts = [
        'photos' => 'array',
        'is_verified' => 'boolean',
        'is_approved' => 'boolean',
        'rating' => 'integer',
        'helpful_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookingTransaction(): BelongsTo
    {
        return $this->belongsTo(BookingTransaction::class);
    }
}
