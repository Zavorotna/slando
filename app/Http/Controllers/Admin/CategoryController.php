<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::selectAll();
        // dd($categories);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Category::addCategory($request->post('title'));

        return to_route('admin.category.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::selectCategory($id);
        // dd($category);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Category::updateCategory($request->post('title'), $id);

        return to_route('admin.category.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Category::deleteCategory($id);

        return to_route('admin.category.index');
    }
}
