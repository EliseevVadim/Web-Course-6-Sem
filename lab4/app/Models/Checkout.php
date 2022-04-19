<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'checkout_state_id',
        'sum'
    ];

    public function checkoutState()
    {
        return $this->belongsTo(CheckoutState::class, 'checkout_state_id');
    }
}
