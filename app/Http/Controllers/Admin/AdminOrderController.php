<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController
{
    public function index(Request $request)
    {
        $orders = Order::query()->with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user','items.comic']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required','in:created,paid,cancelled,completed'],
        ]);

        $order->status = $data['status'];
        if ($order->status === Order::STATUS_PAID && !$order->paid_at) {
            $order->paid_at = now();
        }
        $order->save();

        return back()->with('success', 'Статус обновлён');
    }
}
