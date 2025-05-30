<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
   use HasFactory;
   use SoftDeletes;

   protected $table = 'sizes';
   protected $primaryKey = 'id';
   protected $fillable = [
    'name',
   ];

   protected $casts = [
    'deleted_at' => 'datetime',
   ];

   /**
     * Get all products associated with this color.
     *
     * @return Relations/BelongsToMany
   */
   public function products() 
   {
      return $this->belongsToMany(Product::class, 'product_color');
   }
}
