<?php

namespace App\Http\Controllers\Site;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 
     * @param \App\Http\Requests\ReviewRequest $request
     * @return \Illuminate\Http\RedirectResponse|View
     */
    public function store(ReviewRequest $request): RedirectResponse|View
    {
        $r = Review::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));
        
        if($request->ajax()) {
            $product = $r->product;
            $r->load(['user.customer', 'product']);
            return view('components.review', compact('r', 'product'));
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \App\Http\Requests\ReviewRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse|View
     */
    public function update(ReviewRequest $request, $id): RedirectResponse|View
    {
        $review = Review::findOrFail($id);

        if ($review->user_id != Auth::id()) {
            abort(403);
        }

        if (request()->ajax()) {
            $review->update($request->validated());
            $review->load(['user.customer', 'product']);
            return view('components.review', ['r' => $review, 'product' => $review->product]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|JsonResponse
     * 
     */
    public function destroy(int $id): RedirectResponse|JsonResponse
    {
        $review = Review::findOrFail($id);

        if ($review->user_id == Auth::user()->id) {
            $review->delete();
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back();
    }
}
