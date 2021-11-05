<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'customer_id',
        'shipping_id',
        'payment_id',
        'order_note',
        'order_total',
        'order_paid',
        'status_id',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'order_id', 'order_id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    // public function order_status()
    // {
    //     return $this->belongTo(Status::class, 'status_id', 'status_id');
    // }
}
