<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'sum',
        'cart_id'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id');
    }
}
