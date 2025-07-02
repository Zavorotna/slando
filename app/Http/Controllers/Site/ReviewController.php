<?php

namespace App\Http\Controllers\Site;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request)
    {
        Review::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRequest $request, $id)
    {
        $review = Review::findOrFail($id);
        if ($review->user_id == Auth::user()->id) {
            $review->update($request->validated());
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function destroy(int $id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id == Auth::user()->id) {
            $review->delete();
        }

        return back();
    }
}
