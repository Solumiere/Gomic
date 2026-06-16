<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id || $request->user()->is_admin, 403);

        $order->load(['items.comic']);

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $ids = array_keys($cart);
        $comics = $ids ? Comic::whereIn('id', $ids)->get() : collect();

        if ($comics->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $user = $request->user();

        return DB::transaction(function () use ($request, $user, $comics) {
            $total = (float) $comics->sum('price');

            $order = Order::create([
                'user_id' => $user->id,
                'status' => Order::STATUS_CREATED,
                'total' => $total,
                'payment_method' => 'demo',
            ]);

            foreach ($comics as $comic) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'comic_id' => $comic->id,
                    'unit_price' => $comic->price,
                    'qty' => 1,
                ]);
            }

            // очистить корзину
            $request->session()->forget('cart');

            return redirect()->route('orders.show', $order)->with('success', 'Заказ создан. Нажми «Оплатить» для имитации оплаты.');
        });
    }

    public function pay(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        if ($order->status !== Order::STATUS_CREATED) {
            return back()->with('error', 'Оплата недоступна для этого статуса');
        }

        $order->update([
            'status' => Order::STATUS_PAID,
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Оплата имитирована. Доступ к PDF открыт навсегда.');
    }
}
