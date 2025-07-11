<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;
    
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

    /**
     * Get the user that owns the model.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the colors associated with the product.
     *
     * @return BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }
    
    
    /**
     * Get the sizes associated with the product.
     *
     * @return BelongsToMany
     */
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }

    /**
     * Get the reviews for the product.
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Create product with media
     *
     * @param mixed $data
     * @return newProduct
     */
    public static function createProduct($data)
    {
        $data['user_id'] = Auth::user()->id;
        $data['saleprice'] = $data['price'] * (1 - $data['discount'] / 100);

        $newProduct = Product::create($data);

        foreach($data['img'] as $key => $img) {
            $newProduct->addMedia($img)->withCustomProperties(['color_id' => $key])->toMediaCollection('product');
        }

        return $newProduct;
    }
    /**
    * 
    * update product data
    * 
    * @param mixed $data
    * @param mixed $product
    * @param mixed $images
    * @return void
    */
    public static function updateProduct($data, $product, $images): void
    {
        $data['user_id'] = Auth::user()->id;
        $data['saleprice'] = $data['price'] * (1 - $data['discount'] / 100);
        
        $product->update($data);

        $imagesOld = [];
        foreach ($product->getMedia('product') as $img) {
            $colorId = $img->getCustomProperty('color_id') ?? null;
            if ($colorId) {
                $imagesOld[$colorId] = $img;
            }
        }
        if($images) {
            foreach($images as $key => $img) {
                if(isset($imagesOld[$key])) {
                    $imagesOld[$key]->delete();
                }
                $product->addMedia($img)->withCustomProperties(['color_id' => $key])->toMediaCollection('product');
            }
        }
    }

    public static function popularProducts()
    {
        return Product::with('colors', 'sizes', 'media')
            ->select('id', 'title', 'price', 'saleprice', 'availability', 'orders_count')
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
        return Product::with('colors', 'sizes', 'media')
            ->select('id', 'title', 'price', 'saleprice', 'availability', 'created_at')
            ->where('availability', 'available')
            ->where('created_at', '>=', now()->subDays(10))
            ->inRandomOrder()
            ->limit(8)
            ->get();
        
    }

    public static function catalogueProducts()
    {
        $availableProducts = Product::with('colors', 'sizes', 'media')
            ->select('id', 'title', 'price', 'saleprice','availability')
            ->where('availability', 'available')
            ->inRandomOrder()
            ->get();
            
        $notAvailableProducts = Product::with('colors', 'sizes', 'media')
            ->select('id', 'title', 'price', 'saleprice','availability')
            ->where('availability', '!=' ,'available')
            ->inRandomOrder()
            ->get();        

        return $availableProducts->merge($notAvailableProducts);
    }

    public static function oneProduct($id)
    {
        return Product::select('id', 'title', 'price', 'saleprice', 'availability', 'description', 'user_id')
            ->with([
                'user:id,customer_id', 
                'user.customer:id,name', 
                'reviews' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }, 
                'reviews.user.customer:id,name'
            ])
            ->findOrFail($id);
    }
}
