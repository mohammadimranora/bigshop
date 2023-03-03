<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    use HasFactory;

    const UPLOAD_PATH = 'uploads/media/';

    protected $fillable = [
        'product_id',
        'media',
        'status'
    ];
}
