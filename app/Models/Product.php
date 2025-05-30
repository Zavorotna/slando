<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'sub_subcategory_id',
        'currency_id',
        'user_id',
        'title',
        'description',
        'price',
        'saleprice',
        'availability',
        'discount',
        'orders_count'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }
    
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }

    public static function createProduct($data)
    {
        $data['user_id'] = Auth::user()->id;
        $data['saleprice'] = $data['price'] * (1 - $data['discount'] / 100);

        return Product::create($data);
    }
    
    public static function updateProduct($data, $product): void
    {
        $data['user_id'] = Auth::user()->id;
        $data['saleprice'] = $data['price'] * (1 - $data['discount'] / 100);

        $product->update($data);
    }

    

}
