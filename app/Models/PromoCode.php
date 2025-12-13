<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_transaction',
        'max_discount',
        'usage_limit',
        'usage_count',
        'per_user_limit',
        'start_date',
        'end_date',
        'is_active',
        'applicable_to',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_transaction' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'per_user_limit' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($now->format('Y-m-d') < $this->start_date->format('Y-m-d') || $now->format('Y-m-d') > $this->end_date->format('Y-m-d')) {
            return false;
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'percentage') {
            $discount = $amount * ($this->value / 100);
            if ($this->max_discount) {
                $discount = min($discount, $this->max_discount);
            }
            return $discount;
        }

        return min($this->value, $amount);
    }
}