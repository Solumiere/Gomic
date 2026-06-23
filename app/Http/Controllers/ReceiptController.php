<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReceiptController
{
    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id || $request->user()->is_admin, 403);

        $order->load(['items.comic', 'user']);

        return view('orders.receipt', compact('order'));
    }
}
