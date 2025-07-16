<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Requests\ColorRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * return view all color with trashed
     */
    public function index()
    {
        $colors = Color::select('id', 'name', 'hex', 'deleted_at')->withTrashed()->paginate(15);

        return view('admin.colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new color.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created color in storage.
     * 
     * @param ColorRequest $request
     * @return RedirectResponse
     */
    public function store(ColorRequest $request): RedirectResponse
    {
        Color::createColor($request->validated());

        return to_route('admin.color.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $color = Color::findOrFail($id);

        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, Color $color)
    {
        // dd($request->validated());
        Color::updateColor($request->validated(), $color);

        return to_route('admin.color.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();
        
        return to_route('admin.color.index');
    }
    
    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        Color::onlyTrashed()->findOrFail($id)->restore();
        
        return to_route('admin.color.index');
    }
}
