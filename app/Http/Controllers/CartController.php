<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class CartController
{
    private function cart(Request $request): array
    {
        return $request->session()->get('cart', []);
    }

    private function save(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);
    }

    public function index(Request $request)
    {
        $cart = $this->cart($request); // [comicId => qty]
        $ids = array_keys($cart);
        $comics = $ids ? Comic::whereIn('id', $ids)->get()->keyBy('id') : collect();

        $items = [];
        $total = 0;
        foreach ($cart as $comicId => $qty) {
            $comic = $comics->get((int)$comicId);
            if (!$comic) continue;
            $line = (float)$comic->price * (int)$qty;
            $total += $line;
            $items[] = compact('comic', 'qty', 'line');
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Comic $comic)
    {
        $cart = $this->cart($request);
        $cart[$comic->id] = 1; // цифровой товар — всегда 1
        $this->save($request, $cart);
        return back()->with('success', 'Добавлено в корзину');
    }

    public function remove(Request $request, Comic $comic)
    {
        $cart = $this->cart($request);
        unset($cart[$comic->id]);
        $this->save($request, $cart);
        return back()->with('success', 'Удалено из корзины');
    }
}
