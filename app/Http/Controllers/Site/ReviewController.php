<?php

namespace App\Http\Controllers\Site;

use App\Models\Review;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 
     * @param \App\Http\Requests\ReviewRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReviewRequest $request): RedirectResponse
    {
        Review::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));

        return back();
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \App\Http\Requests\ReviewRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReviewRequest $request, $id): RedirectResponse
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
    public function destroy(int $id): RedirectResponse
    {
        $review = Review::findOrFail($id);

        if ($review->user_id == Auth::user()->id) {
            $review->delete();
        }

        return back();
    }
}
