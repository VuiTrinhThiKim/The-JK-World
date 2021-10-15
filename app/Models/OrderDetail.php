<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'orderdetail_id';

    public function order()
    {
        return $this->belongTo(Order::class, 'order_id', 'order_id');
    }
}
