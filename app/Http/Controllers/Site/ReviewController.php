<?php

namespace App\Http\Controllers\Site;

use App\Models\Review;
use Illuminate\Http\Request;
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
     * @param ReviewRequest $request
     * @return View
     */
    public function store(ReviewRequest $request): View
    {
        $r = Review::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));

        $r->load(['user.customer', 'product']);
        $product = $r->product;

        return view('components.review', compact('r', 'product'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param ReviewRequest $request
     * @param mixed $id
     * @return RedirectResponse|View
     */
    public function update(ReviewRequest $request, $id): RedirectResponse|View
    {
        $review = Review::findOrFail($id);

        if ($review->user_id != Auth::id()) {
            abort(403);
        }

        $review->update($request->validated());
        $review->load(['user.customer', 'product']);

        return view('components.review', ['r' => $review, 'product' => $review->product]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return JsonResponse
     * 
     */
    public function destroy(int $id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id == Auth::user()->id) {
            $review->delete();
        }

        // return back();

    }
}
