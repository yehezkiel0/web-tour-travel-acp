<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceTestimonial extends Model
{
    protected $fillable = [
        'name',
        'location',
        'photo',
        'title',
        'message',
        'service_type',
        'rating',
        'is_approved',
        'user_id'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
