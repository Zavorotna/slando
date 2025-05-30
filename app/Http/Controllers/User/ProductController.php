<?php

namespace App\Http\Controllers\User;

use App\Models\Rate;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductColor;
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
        $colors = Color::select('id', 'name', 'hex')->get();
        $sizes = Size::select('id', 'name')->get();

        return view('user.products.create', compact('subsubcategories', 'currency', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $newProductId = Product::createProduct($request->validated())->id;

        ProductColor::createProductColorsRelations($newProductId, $request->validated('color_ids'));
        ProductSize::createProductSizesRelations($newProductId, $request->validated('size_ids'));

        return to_route('user.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $subsubcategories = Subsubcategory::select('title', 'id')->get();
        $currency = Rate::select('currency', 'id')->get();
        $product = Product::with('colors:id')->findOrFail($id);
        $colors = Color::select('id', 'name', 'hex')->get();
        $sizes = Size::select('id', 'name')->get();

        $productColors = [];
        foreach ($product->colors as $col) {
            $productColors[] = $col->id;
        }

        $productSizes = [];
        foreach ($product->sizes as $s) {
            $productSizes[] = $s->id;
        }
        return view('user.products.edit', compact('subsubcategories', 'currency', 'product', 'productColors', 'colors', 'productSizes', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        ProductColor::updateProductColorsRelations($product->id, $request->validated('color_ids'));
        ProductSize::updateProductSizesRelations($product->id, $request->validated('size_ids'));

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
