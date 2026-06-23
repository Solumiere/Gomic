<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class CheckoutController
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $ids = array_keys($cart);
        $comics = $ids ? Comic::whereIn('id', $ids)->get() : collect();

        if ($comics->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        // Исключаем уже купленные комиксы
        $owned = $request->user()->purchasedComicIds();
        $comics = $comics->reject(fn ($c) => $owned->contains($c->id))->values();

        if ($comics->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Вы уже купили все комиксы из корзины');
        }

        $total = (float) $comics->sum('price');

        return view('checkout.index', compact('comics', 'total'));
    }
}
