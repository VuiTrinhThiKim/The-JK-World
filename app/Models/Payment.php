<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $primaryKey = 'payment_id, payment_method, payment_status';

    public function order()
    {
        return $this->belongTo(Order::class, 'order_id', 'order_id');
    }
}
