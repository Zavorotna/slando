<?php

namespace App\Http\Controllers\User;

use App\Models\Rate;
use App\Models\Product;
use App\Models\Subsubcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $products = Product::where('user_id', Auth::user()->id)->withTrashed()->get();
        // dd(Auth::user());
        
        return view('user.products.index', compact('products'));
    }

     public function create()
    {
        $subsubcategories = Subsubcategory::select('title', 'id')->get();
        $currency = Rate::select('currency', 'id')->get();
        return view('user.products.create', compact('subsubcategories', 'currency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // $data = $request->validated();
        // $data['user_id'] = Auth::user()->id;
        // $data['saleprice'] = $data['price'] * (1 - $data['discount'] / 100);
        // Product::create($data);

        Product::createProduct($request->validated());

        return to_route('user.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $subsubcategories = Subsubcategory::select('title', 'id')->get();
        $currency = Rate::select('currency', 'id')->get();
        $product = Product::findOrFail($id);

        return view('user.products.edit', compact('subsubcategories', 'currency', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        Product::updateProduct($request->validated(), $product);
        return to_route('user.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return to_route('user.products.index');
    }
    
    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        Product::onlyTrashed()->findOrFail($id)->restore();
        
        return to_route('user.products.index');
    }
}
