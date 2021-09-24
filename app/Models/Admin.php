<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $primaryKey = 'admin_id';
    
    protected $fillable = ['username', 'phone', 'email', 'gender', 'dob',];
    protected $hidden = [
        'password',
    ];
   	public function role()
    {
        return $this->hasOne(Role::class, 'role_id', 'role_id');
    }
}
