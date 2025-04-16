<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::selectAll();
        // dd($subcategories);
        return view('admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::selectAll();

        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Subcategory::addSubcategory($request->only(['title', 'category_id']));

        return to_route('admin.subcategory.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subcategory = Subcategory::selectSubcategory($id);
        $categories = Category::selectAll();
        // dd($category);
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Subcategory::updateSubcategory($request->only(['title', 'category_id']), $id);

        return to_route('admin.subcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Subcategory::deleteSubcategory($id);

        return to_route('admin.subcategory.index');
    }
}
