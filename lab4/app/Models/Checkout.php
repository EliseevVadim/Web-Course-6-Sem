<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema (
 *  title="Checkout",
 *  description="Checkout model",
 *  @OA\Property(
 *      property="id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="cart_id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="checkout_state_id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="sum",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="client_full_name",
 *      type="string"
 *  ),
 *  @OA\Property(
 *      property="client_email",
 *      type="string"
 *  ),
 *  @OA\Property(
 *      property="client_address",
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
class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'checkout_state_id',
        'sum',
        'client_full_name',
        'client_email',
        'client_address'
    ];

    public function checkoutState()
    {
        return $this->belongsTo(CheckoutState::class, 'checkout_state_id');
    }
}
