@php
  $statusLabels = ['created' => 'Создан', 'paid' => 'Оплачен', 'completed' => 'Завершён', 'cancelled' => 'Отменён'];
  $statusLabel = $statusLabels[$order->status] ?? $order->status;
  $payLabel = $order->payment_method === 'card' ? 'Банковская карта' : $order->payment_method;
@endphp
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Чек по заказу #<?= e($order->id) ?> — Gomic</title>
  <style>
    body { font-family: Arial, Helvetica, sans-serif; color:#1b1f27; background:#fff; margin:0; padding:32px; }
    .receipt { max-width:720px; margin:0 auto; }
    .head { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:2px solid #1b1f27; padding-bottom:16px; margin-bottom:24px; }
    .brand { font-size:24px; font-weight:700; }
    .muted { color:#6b7280; }
    .meta { margin-bottom:6px; }
    table { width:100%; border-collapse:collapse; margin:20px 0; }
    th, td { text-align:left; padding:10px 8px; border-bottom:1px solid #e5e7eb; }
    th { font-size:12px; text-transform:uppercase; color:#6b7280; }
    td.num, th.num { text-align:right; white-space:nowrap; }
    .total { text-align:right; font-size:20px; font-weight:700; margin-top:8px; }
    .actions { max-width:720px; margin:24px auto 0; display:flex; gap:12px; }
    .btn { display:inline-block; padding:10px 18px; border-radius:8px; text-decoration:none; font-weight:600; border:0; cursor:pointer; font-size:14px; }
    .btn-print { background:#2563eb; color:#fff; }
    .btn-back { background:#e5e7eb; color:#1b1f27; }
    @@media print { .actions { display:none; } body { padding:0; } }
  </style>
</head>
<body>
  <div class="receipt">
    <div class="head">
      <div>
        <div class="brand">Gomic</div>
        <div class="muted">Магазин комиксов</div>
      </div>
      <div style="text-align:right">
        <div><strong>Чек №<?= e($order->id) ?></strong></div>
        <div class="muted"><?= e($order->created_at->format('d.m.Y H:i')) ?></div>
      </div>
    </div>

    <div class="meta"><span class="muted">Покупатель:</span> <?= e($order->user->name) ?></div>
    <div class="meta"><span class="muted">E-mail:</span> <?= e($order->user->email) ?></div>
    <div class="meta"><span class="muted">Статус:</span> <?= e($statusLabel) ?></div>
    <div class="meta"><span class="muted">Способ оплаты:</span> <?= e($payLabel) ?></div>
    @if($order->paid_at)
      <div class="meta"><span class="muted">Оплачен:</span> <?= e($order->paid_at->format('d.m.Y H:i')) ?></div>
    @endif

    <table>
      <thead>
        <tr><th>Комикс</th><th class="num">Цена</th></tr>
      </thead>
      <tbody>
        @foreach($order->items as $it)
          <tr>
            <td><?= e($it->comic->title) ?></td>
            <td class="num"><?= e(number_format($it->unit_price, 0, '.', ' ')) ?> ₽</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="total">Итого: <?= e(number_format($order->total, 0, '.', ' ')) ?> ₽</div>
  </div>

  <div class="actions">
    <button class="btn btn-print" onclick="window.print()">Печать / Сохранить в PDF</button>
    <a class="btn btn-back" href="<?= e(route('orders.show', $order)) ?>">Назад к заказу</a>
  </div>
</body>
</html>
