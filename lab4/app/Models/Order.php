<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema (
 *  title="Order",
 *  description="Order model",
 *  @OA\Property(
 *      property="id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="product_id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="quantity",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="sum",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="cart_id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="product",
 *      type="object"
 *  ),
 *  @OA\Property(
 *      property="created_at",
 *      type="date"
 *  ),
 *  @OA\Property(
 *      property="updated_at",
 *      type="date"
 *  ),
 * )
 */
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
        return $this->belongsTo(Product::class, 'product_id');
    }
}
