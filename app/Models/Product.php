<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, Filterable;
    
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
     * Get the user that owns the model.
     *
     * @return BelongsTo
     */
    public function subsubcategory(): BelongsTo
    {
        return $this->belongsTo(Subsubcategory::class, 'sub_subcategory_id', 'id');
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
     * Get the reviews for the product.
     *
     * @return belongsTo
     */
    public function rate(): belongsTo
    {
        return $this->belongsTo(Rate::class, 'currency_id', 'id');
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
        if(isset($data['img'])) {
            foreach($data['img'] as $key => $img) {
                $newProduct->addMedia($img)->withCustomProperties(['color_id' => $key])->toMediaCollection('product');
            }
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
        return Product::with('colors', 'sizes', 'media', 'rate')
            ->select('id', 'title', 'price', 'saleprice', 'availability', 'orders_count', 'currency_id')
            ->where('availability', 'available')
            ->where('orders_count', '>', function($query){
                $query->selectRaw('AVG(orders_count)')
                ->from('products');
            })
            ->inRandomOrder()
            ->limit(8)
            ->get()
            ->each(function($item){
                $item->updatePrice();
            });
    }

    public static function newProducts()
    {
        return Product::with('colors', 'sizes', 'media', 'rate')
            ->select('id', 'title', 'price', 'saleprice', 'availability', 'created_at', 'currency_id')
            ->where('availability', 'available')
            ->where('created_at', '>=', now()->subDays(10))
            ->inRandomOrder()
            ->limit(8)
            ->get()
            ->each(function($item){
                $item->updatePrice();
            });
        
    }

    public static function catalogueProducts($filters, $itemsPerPage)
    {
        $paginator = Product::with('colors', 'sizes', 'media', 'subsubcategory', 'rate')
            ->select('id', 'title', 'price', 'saleprice', 'availability', 'sub_subcategory_id', 'currency_id')
            ->filter($filters)
            ->orderByRaw("CASE WHEN availability = 'available' THEN 0 ELSE 1 END")
            // ->inRandomOrder()
            ->paginate($itemsPerPage);

        $paginator->getCollection()->each(function ($item) {
            $item->updatePrice();
        });

        return $paginator;


        // $availableProducts = Product::with('colors', 'sizes', 'media')
        //     ->select('id', 'title', 'price', 'saleprice','availability')
        //     ->where('availability', 'available')
        //     ->inRandomOrder()
        //     ->get();
            
        // $notAvailableProducts = Product::with('colors', 'sizes', 'media')
        //     ->select('id', 'title', 'price', 'saleprice','availability')
        //     ->where('availability', '!=' ,'available')
        //     ->inRandomOrder()
        //     ->get();        

        // $merged = $availableProducts->merge($notAvailableProducts);

        // $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // $currentItems = $merged->forPage($currentPage, $itemsPerPage);

        // $paginator = new LengthAwarePaginator(
        //     $currentItems,
        //     $merged->count(),
        //     $itemsPerPage,
        //     $currentPage,
        //     [
        //         'path' => LengthAwarePaginator::resolveCurrentPath(),
        //         'query' => Request::query(),
        //     ]
        // );

        // return $paginator;
    }

    public static function getProductToCart($id, $colorId, $sizeId)
    {
        $product =  Product::select('id', 'title', 'saleprice', 'price', 'availability', 'currency_id', 'user_id')
            ->with(['colors', 'sizes', 'media', 'rate'])
            ->findOrFail($id);   
            
        $product->chousen_color = $product->colors->find($colorId);
        $product->chousen_size = $product->sizes->find($sizeId);
        $product->img_url = $product->getMedia('product')->firstWhere('custom_properties.color_id', (int)$colorId)?->getUrl();

        return $product->updatePrice(true);
    }

    public static function oneProduct($id)
    {
        return Product::select('id', 'title', 'price', 'saleprice', 'availability', 'description', 'user_id', 'currency_id')
            ->with([
                'user:id,customer_id', 
                'user.customer:id,name',
                'rate'
            ])
            ->findOrFail($id)
            ->updatePrice(true);
    }

    public static function selectMinPrice()
    {
        return floor(Product::min('saleprice'));
    }

    public static function selectMaxPrice()
    {
        return ceil(Product::max('saleprice'));
    }

    public function updatePrice(bool $isProductCard = false) 
    {
        if ($this->rate) {
            $this->saleprice = round($this->saleprice * $this->rate->exchange_rate);
            if($isProductCard) $this->price = round($this->price * $this->rate->exchange_rate);
            // dd($this->price);
        }
        return $this;
    }
    
}
