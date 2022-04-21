<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema (
 *  title="CheckoutState",
 *  description="CheckoutState model",
 *  @OA\Property(
 *      property="id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="name",
 *      type="string"
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
