<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ProfileController
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->latest()
            ->with('items.comic')
            ->get();

        // Купленные комиксы из оплаченных заказов (без дублей)
        $purchasedComics = $orders
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_COMPLETED])
            ->flatMap(fn ($order) => $order->items->pluck('comic'))
            ->filter()
            ->unique('id')
            ->values();

        return view('profile.index', compact('user', 'orders', 'purchasedComics'));
    }
}
