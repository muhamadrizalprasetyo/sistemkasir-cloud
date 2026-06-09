<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'stamp_count',
        'total_rewards_claimed',
        'membership_type',
        'member_code',
        'member_joined_at',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
