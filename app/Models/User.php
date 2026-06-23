<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password','is_admin'];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'password' => 'hashed',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * ID комиксов, которые пользователь уже купил (оплаченные/завершённые заказы).
     */
    public function purchasedComicIds(): Collection
    {
        return Order::where('user_id', $this->id)
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_COMPLETED])
            ->with('items')
            ->get()
            ->flatMap(fn ($order) => $order->items->pluck('comic_id'))
            ->unique()
            ->values();
    }

    public function hasPurchased($comicId): bool
    {
        return $this->purchasedComicIds()->contains((int) $comicId);
    }
}
