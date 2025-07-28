<?php

namespace App\Http\Controllers\Site;

use App\Models\Size;
use App\Models\Color;
use App\Models\Review;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\LikedProduct;
use Illuminate\Http\Request;
use App\Models\Subsubcategory;
use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\FilterRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $popularProducts = Product::popularProducts();
        $newProducts = Product::newProducts();
        $user = null;
        // dd($popularProducts);
        if(Auth::check()) {
            $user = Auth::user()->load('likedProducts');
        }
        
        return view('site.index', compact('popularProducts', 'newProducts', 'user'));
    }

    public function catalogue(FilterRequest $request)
    {
        $filters = app()->make(ProductFilter::class, ['queryParams' => array_filter($request->validated())]);

        $catalogueProducts = Product::catalogueProducts($filters, 15);
        $user = null;

        if(Auth::check()) {
            $user = Auth::user()->load('likedProducts');
        }

        if ($request->ajax()) {
            return view('components.catalogue_page', compact('catalogueProducts', 'user'));
        }

        $subsubcategories = Subsubcategory::selectSubsubcategoryCatalog();
        $colors = Color::selectColors(); 
        $sizes = Size::selectSizes(); 
        $priceMin = Product::selectMinPrice();
        // dd($priceMin);
        $priceMax = Product::selectMaxPrice();
        
        return view('site.catalogue', compact('catalogueProducts', 'user', 'subsubcategories', 'colors', 'sizes', 'priceMin', 'priceMax'));
    }

    public function product(Request $request, $id) 
    {
        $product = Product::oneProduct($id);
        $reviews = Review::getProductReviews($id);
        
        if ($request->ajax()) {
            return view('components.page_reviews', compact('product', 'reviews'));
        }

        return view('site.product', compact('product', 'reviews'));
    }
    
    public function liked(Request $request) 
    {
        $productId = $request->validate(['id' => 'required|integer|exists:products,id'])['id'];
        LikedProduct::create(['product_id' => $productId, 'user_id' => Auth::user()->id]);
        
        return back();
    }

    public function likedPage()
    {
        $likedProducts = LikedProduct::where('user_id', Auth::user()->id)->with('product')->get()->pluck('product');
        return view('site.liked', compact('likedProducts'));
    }

    public function removeLiked(Request $request)
    {
        $deleteId = $request->validate(['id' => 'required|integer|exists:products,id'])['id'];

        LikedProduct::where('user_id', Auth::user()->id)
        ->where('product_id', $deleteId)
        ->delete();

        return back();
    }
}
