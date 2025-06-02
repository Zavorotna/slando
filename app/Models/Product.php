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


    public static function popularProducts()
    {
        return Product::select('id', 'title', 'price', 'saleprice', 'availability', 'orders_count')
            ->where('availability', 'available')
            ->where('orders_count', '>', function($query){
                $query->selectRaw('AVG(orders_count)')
                ->from('products');
            })
            ->inRandomOrder()
            ->limit(8)
            ->get();
    }

    public static function newProducts()
    {
        return Product::select('id', 'title', 'price', 'saleprice', 'availability', 'created_at')
            ->where('availability', 'available')
            ->where('created_at', '>=', now()->subDays(10))
            ->inRandomOrder()
            ->limit(8)
            ->get();
        
    }

    public static function catalogueProducts()
    {
        return Product::select('id', 'title', 'price', 'saleprice')
            ->inRandomOrder()
            ->get();
    }

    public static function oneProduct($id)
    {
        return Product::select('id', 'title', 'price', 'saleprice', 'availability', 'description', 'user_id')
            ->with(['user:id,customer_id', 'user.customer:id,name'])
            ->findOrFail($id);

    }
}
