<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPointTransaction extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'points',
    'type', // earn, redeem, adjustment
    'description',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
