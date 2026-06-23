<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReceiptController
{
    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id || $request->user()->is_admin, 403);

        if (!in_array($order->status, [Order::STATUS_PAID, Order::STATUS_COMPLETED])) {
            return redirect()->route('orders.show', $order)->with('error', 'Чек доступен только после оплаты заказа');
        }

        $order->load(['items.comic', 'user']);

        return view('orders.receipt', compact('order'));
    }
}
