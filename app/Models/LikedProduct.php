<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class LikedProduct extends Model
{
    protected $table = 'liked_products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id', 
        'user_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
