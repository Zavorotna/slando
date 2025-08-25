<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'customer_id',
        'user_id',
        'color',
        'size',
        'count',
        'address',
        'total_price',
    ];

     /**
     * Get the product that owns the model.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    
    /**
     * Get the customer for the order.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    
    public static function createOrder($userData, $cartData) 
    {
        $orderData = [];
        foreach ($cartData as $item) {
            $orderData['product_id'] = $item->attributes->product_id;
            $orderData['count'] = $item->quantity;
            $orderData['user_id'] = $item->attributes->user_id;
            $orderData['color'] = $item->attributes->color_name;
            $orderData['size'] = $item->attributes->size;
            $orderData['total_price'] = $item->quantity * $item->price;
            $orderData['customer_id'] = $userData['customer_id'];
            $orderData['address'] = $userData['adress'];
    
            Order::create($orderData);
        }   
    }

}
