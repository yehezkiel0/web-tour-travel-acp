<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingSetting extends Model
{
    protected $fillable = [
        'individual_visa_rate',
        'group_visa_rate',
        'tax_percentage',
        'group_discount_threshold',
        'group_discount_percentage',
    ];
}
