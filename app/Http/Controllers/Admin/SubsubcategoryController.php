<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Models\Subsubcategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubsubcategoryRequest;

class SubsubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subsubcategories = Subsubcategory::selectAll();
        // dd($subcategories);
        return view('admin.subsubcategories.index', compact('subsubcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = Subcategory::selectAll();

        return view('admin.subsubcategories.create', compact('subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubsubcategoryRequest $request)
    {
        Subsubcategory::addSubsubcategory([
            'title' => $request->validated('title'),
            'slug' => str($request->validated('title'))->slug(),
            'subcategory_id' => $request->validated('subcategory_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return to_route('admin.subsubcategory.index');
    }

   /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subsubcategory = Subsubcategory::selectSubsubcategory($id);
        $subcategories = Subcategory::selectAll();
        // dd($subcategories, $subsubcategory);
        return view('admin.subsubcategories.edit', compact('subsubcategory', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubsubcategoryRequest $request, $id)
    {
        Subsubcategory::updateSubsubcategory($request->safe()->only(['title', 'subcategory_id']), $id);

        return to_route('admin.subsubcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Subsubcategory::deleteSubsubcategory($id);

        return to_route('admin.subsubcategory.index');
    }
}
