<?php

namespace App\Http\Controllers\Site;

use App\Models\Product;
use App\Models\LikedProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $popularProducts = Product::popularProducts();
        $newProducts = Product::newProducts();
        $user = null;

        if(Auth::check()) {
            $user = Auth::user()->load('likedProducts');
        }
        
        return view('site.index', compact('popularProducts', 'newProducts', 'user'));
    }

    public function catalogue()
    {
        $catalogueProducts = Product::catalogueProducts();
        $user = null;

        if(Auth::check()) {
            $user = Auth::user()->load('likedProducts');
        }

        return view('site.catalogue', compact('catalogueProducts', 'user'));
    }

    public function product($id) 
    {
        $product = Product::oneProduct($id);
        
        return view('site.product', compact('product'));
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
