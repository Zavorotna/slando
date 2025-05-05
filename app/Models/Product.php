<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'sub_subcategory_id',
        'currency_id',
        'title',
        'description',
        'price',
        'saleprice',
        'availability',
        'discount',
        'orders_count',
    ];
    //
}
