<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Requests\SizeRequest;
use App\Http\Controllers\Controller;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::select('id', 'name', 'deleted_at')->withTrashed()->paginate(15);

        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeRequest $request)
    {
        Size::create($request->validated());

        return to_route('admin.size.index');
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $size = Size::findOrFail($id);

        return view('admin.sizes.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeRequest $request, Size $size)
    {
        // dd($request->validated());
        $size->update($request->validated());
        // Size::updateSize($request->validated(), $size);

        return to_route('admin.size.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();

        return to_route('admin.size.index');
    }
    
    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        Size::onlyTrashed()->findOrFail($id)->restore();
        
        return to_route('admin.size.index');
    }
}
