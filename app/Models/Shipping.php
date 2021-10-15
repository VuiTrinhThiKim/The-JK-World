<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $table = 'shipping';
    protected $primaryKey = 'shipping_id';

    public function order()
    {
        return $this->hasMany(Order::class, 'order_id', 'order_id');
    }

    public function customer()
    {
        return $this->belongTo(Customer::class, 'customer_id', 'customer_id');
    }
}
