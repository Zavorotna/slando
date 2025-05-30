<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class ProductColor extends Model
{
    use HasFactory;

    protected $table = 'product_color';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'color_id',
    ];

    public static function createProductColorsRelations($productId, $colorIds)
    {
        foreach ($colorIds as $colorId) {
            ProductColor::create(['product_id' => $productId, 'color_id' => $colorId]);
        }
    }

    public static function updateProductColorsRelations($productId, $colorIds)
    {
        ProductColor::where('product_id', '=', $productId)->delete();
        foreach ($colorIds as $colorId) {
            ProductColor::create(['product_id' => $productId, 'color_id' => $colorId]);
        }
    }


}
