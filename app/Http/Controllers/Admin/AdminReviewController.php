<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;

class AdminReviewController
{
    public function index()
    {
        $reviews = Review::query()->with(['user','comic'])->latest()->paginate(30);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Отзыв удалён');
    }
}
