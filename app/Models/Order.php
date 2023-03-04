<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'discount',
        'total',
        'payment_method',
        'payment_status',
        'status'
    ];

    protected $with = ['items'];

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'id');
    }
}
