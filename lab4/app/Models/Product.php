<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema (
 *  title="Product",
 *  description="Product model",
 *  @OA\Property(
 *      property="id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="name",
 *      type="string"
 *  ),
 *  @OA\Property(
 *      property="description",
 *      type="string"
 *  ),
 *  @OA\Property(
 *      property="image_path",
 *      type="string"
 *  ),
 *  @OA\Property(
 *      property="weight",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="price",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="orders_count",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="category_id",
 *      type="integer"
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
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'weight',
        'price',
        'orders_count',
        'category_id',
        'image_path'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
