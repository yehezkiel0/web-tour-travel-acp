<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Destination extends Model
{
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'country',
        'city',
        'latitude',
        'longitude',
        'price',
        'date_started',
        'date_ended',
        'type',
        'min_people',
        'max_people',
        'featured_photo',
        'view_count',
        'virtual_tour_images',
    ];

    protected $casts = [
        'virtual_tour_images' => 'array',
        'date_started' => 'date',
        'date_ended' => 'date',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(DestinationPhoto::class);
    }

    public function destinationPhotos(): HasMany
    {
        return $this->hasMany(DestinationPhoto::class);
    }

    public function destination_detail(): HasOne
    {
        return $this->hasOne(DestinationDetail::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(BookingTransaction::class);
    }

    public function bookingTransactions(): HasMany
    {
        return $this->hasMany(BookingTransaction::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(DestinationReview::class);
    }

    public function wishlists(): MorphMany
    {
        return $this->morphMany(Wishlist::class, 'wishlistable');
    }

    public function averageRating()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
    }

    public function totalReviews()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = Str::slug($model->title);
            }
        });
    }
}
