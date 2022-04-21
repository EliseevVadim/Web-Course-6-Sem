<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema (
 *  title="Cart",
 *  description="Cart model",
 *  @OA\Property(
 *      property="id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="user_id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="orders",
 *      type="collection"
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
class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'cart_id');
    }
}
