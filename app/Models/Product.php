<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'product_name',
        'product_description',
        'content',
        'price',
        'category_id',
        'brand_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_id', 'product_id');
    }

	public function brand()
    {
        return $this->belongsTo(Brand::class, 'product_id', 'product_id');
    }    
}
