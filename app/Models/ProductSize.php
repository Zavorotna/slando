<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $table = 'product_size';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'size_id',
        'stock'
    ];

    public static function createProductSizesRelations($productId, $sizeIds)
    {
        foreach ($sizeIds as $sizeId) {
            ProductSize::create(['product_id' => $productId, 'size_id' => $sizeId]);
        }
    }
    
    public static function updateProductSizesRelations($productId, $sizeIds)
    {
        ProductSize::where('product_id', '=', $productId)->delete();
        foreach ($sizeIds as $sizeId) {
            ProductSize::create(['product_id' => $productId, 'size_id' => $sizeId]);
        }
    }
}
