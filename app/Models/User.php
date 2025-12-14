<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
        'status',
        'role',
        'photo',
        'referral_code',
        'referrer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(BookingTransaction::class);
    }

    public function bookingTransactions(): HasMany
    {
        return $this->hasMany(BookingTransaction::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(DestinationReview::class);
    }

    public function loyaltyPointTransactions(): HasMany
    {
        return $this->hasMany(LoyaltyPointTransaction::class);
    }

    public function addPoints(int $amount, string $description = 'Earned points')
    {
        $this->increment('loyalty_points', $amount);
        $this->loyaltyPointTransactions()->create([
            'points' => $amount,
            'type' => 'earn',
            'description' => $description,
        ]);
        $this->updateTier();
    }

    public function redeemPoints(int $amount, string $description = 'Redeemed points')
    {
        if ($this->loyalty_points < $amount) {
            return false;
        }

        $this->decrement('loyalty_points', $amount);
        $this->loyaltyPointTransactions()->create([
            'points' => -$amount,
            'type' => 'redeem',
            'description' => $description,
        ]);

        return true;
    }

    public function updateTier()
    {
        // Simple tier logic
        if ($this->loyalty_points >= 5000) {
            $this->update(['loyalty_tier' => 'Platinum']);
        } elseif ($this->loyalty_points >= 1000) {
            $this->update(['loyalty_tier' => 'Gold']);
        } else {
            $this->update(['loyalty_tier' => 'Silver']);
        }
    }
    public function itineraries(): HasMany
    {
        return $this->hasMany(Itinerary::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }
}