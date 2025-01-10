<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
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

    public function photos()
    {
        return $this->hasMany(DestinationPhoto::class);
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
