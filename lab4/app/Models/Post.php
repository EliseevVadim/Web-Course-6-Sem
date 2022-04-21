<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *  title="Post",
 *  description="Post model",
 *  @OA\Property(
 *      property="id",
 *      type="integer"
 *  ),
 *  @OA\Property(
 *      property="title",
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
 *      property="posting_time",
 *      type="date"
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
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'posting_time'
    ];
}
