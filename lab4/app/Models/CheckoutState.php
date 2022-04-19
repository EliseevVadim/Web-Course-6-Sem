<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutState extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function checkout()
    {
        return $this->hasMany(Checkout::class, 'checkout_state_id');
    }
}
