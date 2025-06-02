<?php

namespace App\Http\Controllers\Site;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $popularProducts = Product::popularProducts();
        $newProducts = Product::newProducts();
        
        return view('site.index', compact('popularProducts', 'newProducts'));
    }

    public function catalogue()
    {
        $catalogueProducts = Product::catalogueProducts();

        return view('site.catalogue', compact('catalogueProducts'));
    }

    public function product($id) 
    {
        $product = Product::oneProduct($id);
        
        return view('site.product', compact('product'));
    }
}
