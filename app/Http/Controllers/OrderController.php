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

        $order->load(['items.comic', 'user']);

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        // keep only digits in card number and CVV
        $request->merge([
            'card_number' => preg_replace('/\\D/', '', (string) $request->input('card_number')),
            'card_cvv' => preg_replace('/\\D/', '', (string) $request->input('card_cvv')),
        ]);

        $validated = $request->validate([
            'card_number' => ['required', 'regex:/^\\d{16}$/'],
            'card_exp' => ['required', 'regex:/^(0[1-9]|1[0-2])\\/\\d{2}$/'],
            'card_cvv' => ['required', 'regex:/^\\d{3,4}$/'],
        ], [
            'card_number.required' => 'Введите номер карты',
            'card_number.regex' => 'Номер карты должен содержать 16 цифр',
            'card_exp.required' => 'Введите срок действия карты',
            'card_exp.regex' => 'Срок действия в формате ММ/ГГ',
            'card_cvv.required' => 'Введите CVV-код',
            'card_cvv.regex' => 'CVV должен содержать 3 цифры',
        ]);

        // card must not be expired (MM/YY)
        [$expMonth, $expYear] = array_map('intval', explode('/', $validated['card_exp']));
        $expYearFull = 2000 + $expYear;
        $nowYear = (int) now()->format('Y');
        $nowMonth = (int) now()->format('n');
        if ($expYearFull < $nowYear || ($expYearFull === $nowYear && $expMonth < $nowMonth)) {
            return back()->withErrors(['card_exp' => 'Срок действия карты истёк'])->withInput();
        }

        $cart = $request->session()->get('cart', []);
        $ids = array_keys($cart);
        $comics = $ids ? Comic::whereIn('id', $ids)->get() : collect();

        if ($comics->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $user = $request->user();

        $owned = $user->purchasedComicIds();
        $comics = $comics->reject(fn ($c) => $owned->contains($c->id))->values();

        if ($comics->isEmpty()) {
            $request->session()->forget('cart');
            return redirect()->route('cart.index')->with('error', 'Вы уже купили все комиксы из корзины');
        }

        return DB::transaction(function () use ($request, $user, $comics) {
            $total = (float) $comics->sum('price');

            $order = Order::create([
                'user_id' => $user->id,
                'status' => Order::STATUS_CREATED,
                'total' => $total,
                'payment_method' => 'card',
            ]);

            foreach ($comics as $comic) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'comic_id' => $comic->id,
                    'unit_price' => $comic->price,
                    'qty' => 1,
                ]);
            }

            $request->session()->forget('cart');

            return redirect()->route('orders.show', $order)->with('success', 'Заказ создан. Проверьте данные и нажмите «Оплатить».');
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

        return redirect()->route('profile.index')->with('success', 'Оплата прошла успешно! Купленные комиксы доступны в профиле.');
    }
}
