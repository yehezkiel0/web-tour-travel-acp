<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'price',
        'date_started',
        'date_ended',
        'type',
        'min_people',
        'max_people',
        'featured_photo',
        'view_count'
    ];

    public function photos(): HasMany
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
