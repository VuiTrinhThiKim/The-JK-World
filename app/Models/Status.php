<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';
    protected $primaryKey = 'status_id';

    protected $fillable = [
        'status_name',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'status_id', 'status_id');
    }
}
