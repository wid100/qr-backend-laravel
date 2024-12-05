<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'product_category_id',
        'buy_price',
        'price',
        'discount_price',
        'quantity',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'description',
        'status',
    ];

    public function productCategorys()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }



    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('order_by', 'asc');
    }
}
