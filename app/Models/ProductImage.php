<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
      protected $fillable = ['product_id', 'image_name', 'order_by'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function getImage()
    {
        // Assuming you store images in the public directory under 'images/products/'
        return asset($this->image_name);
    }
}
