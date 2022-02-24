<?php

namespace App\Models;

use App\Traits\Eloquent\Uploadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    use Uploadable;

    protected $fillable = ['name', 'path'];
}
