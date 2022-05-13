<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_title',
        'document_size',
        'document_path',
        'highest_similarity',
        'uploader_id',
        'most_similar_document_id'
    ];
}
