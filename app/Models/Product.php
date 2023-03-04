<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'slug',
        'name',
        'short_description',
        'long_description',
        'view_count',
        'status'
    ];

    protected $with = ['medias'];

    public function medias()
    {
        return $this->hasMany('App\Models\ProductMedia', 'product_id', 'id');
    }

    public function variants()
    {
        return $this->hasMany('App\Models\ProductVariant', 'product_id', 'id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
}
