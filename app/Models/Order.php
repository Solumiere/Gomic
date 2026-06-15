<?php

namespace App\Models;

class Order
{
    public const STATUS_CREATED = 'created';
    public const STATUS_PAID = 'paid';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_COMPLETED = 'completed';

    public int $id;
    public int $user_id;
    public string $status = self::STATUS_CREATED;
    public float $total;
}
