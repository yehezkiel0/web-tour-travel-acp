<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingTransaction extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'destination_id',
        'from_date',
        'to_date',
        'adult_count',
        'child_count',
        'total_price',
        'traveller_details',
        'status',
        'contact_name',
        'contact_phone',
        'contact_email',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
