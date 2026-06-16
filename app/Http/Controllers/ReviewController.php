<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController
{
    public function store(Request $request, Comic $comic)
    {
        $user = $request->user();

        $request->validate([
            'rating' => ['required','integer','min:1','max:5'],
            'body' => ['required','string','min:3','max:2000'],
        ]);

        $hasPaid = Order::query()
            ->where('user_id', $user->id)
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_COMPLETED])
            ->whereHas('items', fn($q) => $q->where('comic_id', $comic->id))
            ->exists();

        if (!$hasPaid) {
            return back()->with('error', 'Отзыв можно оставить только после покупки');
        }

        Review::updateOrCreate(
            ['user_id' => $user->id, 'comic_id' => $comic->id],
            ['rating' => (int)$request->rating, 'body' => (string)$request->body, 'is_hidden' => false]
        );

        return back()->with('success', 'Отзыв сохранён');
    }
}
